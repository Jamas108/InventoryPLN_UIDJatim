<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BarangMasuk;
use App\Models\StaffGudang;
use App\Models\Notification;
use App\Models\StatusBarang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\KategoriBarang;
use App\Events\NewNotification;
use RealRashid\SweetAlert\Facades\Alert;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class BarangMasukController extends Controller
{
    protected $database;
    protected $storage;

    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env("FIREBASE_DATABASE_URL"));

        $this->database = $firebase->createDatabase();
        $this->storage = $firebase->createStorage();
        $this->middleware('auth');
    }
    public function index()
    {
        confirmDelete();
        // Ambil data dari Firebase
        $barangMasuksSnapshot = $this->database->getReference('barang_masuk')->getSnapshot();
        $barangMasuksData = $barangMasuksSnapshot->getValue();

        $barangMasuks = collect($barangMasuksData)->map(function ($item) {
            // Convert arrays to objects
            $item['barang'] = collect($item['barang'])->map(function ($barang) {
                return (object) $barang; // Convert each barang to object
            });
            return (object) $item; // Convert main item to object
        });

        // Calculate remaining warranty days for each item
        foreach ($barangMasuks as $barangMasuk) {
            foreach ($barangMasuk->barang as $barang) {
                if (isset($barang->garansi_barang_awal) && isset($barang->garansi_barang_akhir)) {
                    $garansiAwal = Carbon::parse($barang->garansi_barang_awal);
                    $garansiAkhir = Carbon::parse($barang->garansi_barang_akhir);
                    $currentDate = Carbon::now();

                    if ($currentDate->lessThan($garansiAwal)) {
                        $sisaHari = 'Garansi belum mulai';
                    } elseif ($currentDate->greaterThan($garansiAkhir)) {
                        $sisaHari = 'Garansi telah berakhir';
                    } else {
                        $sisaHari = $currentDate->diffInDays($garansiAkhir, false) . ' hari tersisa';
                    }

                    $barang->sisa_hari_garansi = $sisaHari;
                } else {
                    $barang->sisa_hari_garansi = 'Informasi garansi tidak lengkap';
                }
            }
        }

        // Hitung total barang untuk setiap grup dan calculate approval status
        $groupedBarangMasuks = $barangMasuks->groupBy('id')->map(function ($items) {
            $approvalStatuses = $items->flatMap(fn($item) => $item->barang->pluck('Status'));

            $overallApprovalStatus = 'Accept'; // Default status
            if ($approvalStatuses->contains('Pending')) {
                $overallApprovalStatus = 'Pending';
            } elseif ($approvalStatuses->contains('Reject')) {
                $overallApprovalStatus = 'Reject';
            }

            return collect([
                'items' => $items->flatMap(fn($item) => $item->barang),
                'Jumlah_barang' => $items->flatMap(fn($item) => $item->barang)->count(),
                'File_SuratJalan' => $items->first()->File_SuratJalan ?? null,
                'File_BeritaAcara' => $items->first()->File_BeritaAcara ?? null,
                'NamaPerusahaan_Pengirim' => $items->first()->NamaPerusahaan_Pengirim ?? null,
                'Jumlah_BarangMasuk' => $items->first()->Jumlah_BarangMasuk ?? null,
                'No_Surat' => $items->first()->No_Surat ?? null,
                'TanggalPengiriman_Barang' => $items->first()->TanggalPengiriman_Barang,
                'id' => $items->first()->id ?? null,
                'Status' => $overallApprovalStatus, // Add overall approval status
            ]);
        });

        $Id_role = Auth::user()->Id_Role;

        return view('barangmasuk.index', ['groupedBarangMasuks' => $groupedBarangMasuks]);
    }

    public function edit($itemId)
    {
        // Ambil data berdasarkan itemId dari Firebase
        $barangMasukSnapshot = $this->database->getReference('barang_masuk/' . $itemId)->getSnapshot();
        $barangMasukData = $barangMasukSnapshot->getValue();

        // Periksa apakah data ditemukan
        if (!$barangMasukData) {
            return redirect()->route('barangmasuk.index')->with('error', 'Data tidak ditemukan');
        }

        // Ubah array menjadi object (jika diperlukan)
        $barangMasuk = (object) $barangMasukData;

        // Konversi barang menjadi object
        if (isset($barangMasuk->barang)) {
            $barangMasuk->barang = collect($barangMasuk->barang)->map(function ($barang) {
                $barang = (object) $barang;

                // Jika gambar_barang ada, ambil URL dari Firebase Storage
                if (isset($barang->gambar_barang)) {
                    $object = $this->storage->getBucket()->object($barang->gambar_barang);
                    $barang->url_gambar = $object->signedUrl(new \DateTime('1 hour')); // URL sementara (1 jam)
                } else {
                    // Jika tidak ada gambar, berikan nilai default
                    $barang->url_gambar = 'URL gambar tidak tersedia';
                }

                return $barang;
            });
        }

        // Hitung sisa hari garansi untuk setiap barang (jika ada)
        foreach ($barangMasuk->barang as $barang) {
            if (isset($barang->garansi_barang_awal) && isset($barang->garansi_barang_akhir)) {
                $garansiAwal = Carbon::parse($barang->garansi_barang_awal);
                $garansiAkhir = Carbon::parse($barang->garansi_barang_akhir);
                $currentDate = Carbon::now();

                if ($currentDate->lessThan($garansiAwal)) {
                    $sisaHari = 'Garansi belum mulai';
                } elseif ($currentDate->greaterThan($garansiAkhir)) {
                    $sisaHari = 'Garansi telah berakhir';
                } else {
                    $sisaHari = $currentDate->diffInDays($garansiAkhir, false) . ' hari tersisa';
                }

                $barang->sisa_hari_garansi = $sisaHari;
            } else {
                $barang->sisa_hari_garansi = 'Informasi garansi tidak lengkap';
            }
        }

        // Tampilkan view halaman edit dan kirim data barang
        return view('barangmasuk.edit', compact('barangMasuk'));
    }





    public function create()
    {
        $staffGudangs = User::all();
        $kategoriBarangs = KategoriBarang::all();
        $statusBarangs = StatusBarang::all();

        return view('barangmasuk.create', compact('staffGudangs', 'kategoriBarangs', 'statusBarangs'));
    }


    public function store(Request $request)
    {
        // Validasi data dengan pesan khusus
        $validator = Validator::make($request->all(), [
            'No_Surat' => 'required|max:255',
            'NamaPerusahaan_Pengirim' => 'required|max:255',
            'TanggalPengiriman_Barang' => 'required|date',
            'Id_Petugas' => 'required|string', // Since this is populated from the logged-in user
            'jumlah_barangmasuk' => 'required|integer|min:1', // Read-only but must have a valid number
            'File_SuratJalan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Ensure file format and size

        ], [
            'No_Surat.required' => 'Nomor Surat harus diisi.',
            'NamaPerusahaan_Pengirim.required' => 'Nama Perusahaan Pengirim harus diisi.',
            'TanggalPengiriman_Barang.required' => 'Tanggal Pengiriman Barang harus diisi.',
            'Id_Petugas.required' => 'ID Petugas harus diisi.',
            'jumlah_barangmasuk.required' => 'Jumlah barang masuk harus diisi.',
            'jumlah_barangmasuk.integer' => 'Jumlah barang masuk harus berupa angka.',
            'jumlah_barangmasuk.min' => 'Jumlah barang masuk harus minimal 1.',
            'File_SuratJalan.required' => 'File Surat Jalan harus diunggah.',
            'File_SuratJalan.mimes' => 'File Surat Jalan harus dalam format pdf, jpg, jpeg, atau png.',
            'File_SuratJalan.max' => 'File Surat Jalan tidak boleh lebih dari 2MB.',
        ]);


        // Cek jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        if ($request->hasFile('File_SuratJalan')) {
            $file = $request->file('File_SuratJalan');
            $filePath = 'surat-jalan_barangmasuk/' . $file->getClientOriginalName();
            $this->storage->getBucket()->upload(
                fopen($file->getPathname(), 'r'),
                ['name' => $filePath]
            );
            $fileSuratJalanPath = $this->storage->getBucket()->object($filePath)->signedUrl(new \DateTime('+1 hour'));
            $data['File_SuratJalan'] = $fileSuratJalanPath;
        }

        // Initialize the data for the main entry
        $data = [
            'Id_Petugas' => $request->Id_Petugas,
            'No_Surat' => $request->No_Surat,
            'NamaPerusahaan_Pengirim' => $request->NamaPerusahaan_Pengirim,
            'TanggalPengiriman_Barang' => $request->TanggalPengiriman_Barang,
            'Jumlah_BarangMasuk' => $request->jumlah_barangmasuk,
            'File_SuratJalan' => $fileSuratJalanPath,
            'barang' => [],
        ];

        foreach ($request->JumlahBarang_Masuk as $i => $jumlah) {
            $gambarBarangPath = null;
            if ($request->hasFile("Gambar_Barang.$i")) {
                $file = $request->file("Gambar_Barang.$i");
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'gambar_barang/' . $fileName;

                // Upload ke Firebase Storage
                $bucket = $this->storage->getBucket();
                $bucket->upload(
                    fopen($file->getPathname(), 'r'),
                    [
                        'name' => $filePath,
                    ]
                );
                $gambarBarangPath = $filePath;
            }

            $status = isset($request->Status[$i]) ? $request->Status[$i] : 'Pending';
            $JenisBarang = isset($request->Jenis_Barang[$i]) ? $request->Jenis_Barang[$i] : 'Baru';

            // Add the item's data including the specific image path
            $data['barang'][] = [
                'id' => uniqid(),
                'nama_barang' => $request->Nama_Barang[$i],
                'kode_barang' => $request->Kode_Barang[$i],
                'kategori_barang' => $request->Kategori_Barang[$i],
                'inisiasi_stok' => $request->JumlahBarang_Masuk[$i],
                'jumlah_barang' => $request->JumlahBarang_Masuk[$i],
                'jenis_barang' => $JenisBarang,
                'garansi_barang_awal' => $request->Garansi_Barang_Awal[$i],
                'garansi_barang_akhir' => $request->Garansi_Barang_Akhir[$i],
                'tanggal_masuk' => $request->Tanggal_Masuk[$i],
                'Status' => $status,
                'gambar_barang' => $gambarBarangPath,
            ];
        }

        // Save the entire entry to Firebase
        $newItemRef = $this->database->getReference('barang_masuk')->push($data);
        $itemId = $newItemRef->getKey(); // Mendapatkan ID dari Firebase

        // Optionally update the entry with the ID
        $newItemRef->update(['id' => $itemId]);
        // Ambil ID staff gudang dan admin
        $staffId = Auth::user()->id; // Misal mengambil ID pengguna yang sedang login sebagai staff
        $admin = User::where('Id_Role', '1')->first(); // Ambil pengguna yang memiliki role admin
        $adminId = $admin ? $admin->id : null; // Pastikan admin ditemukan, jika tidak null

        // Cek apakah ID admin sudah didefinisikan dengan benar
        if (!$adminId) {
            return redirect()->back()->withErrors('Admin tidak ditemukan.');
        }

        // Setelah menambahkan data barang masuk
        $this->database->getReference('notifications')->push([
            'title' => 'Barang Masuk Diajukan',
            'message' => 'Pengajuan barang masuk telah dibuat.',
            'created_at' => now(),
            'user_status' => [
                'user_' . $staffId => ['status' => 'unread'],  // Status untuk staff gudang
                'admin_' . $adminId => ['status' => 'unread']  // Status untuk admin
            ]
        ]);

        Alert::success('Berhasil', 'Barang Berhasil Ditambahkan.');

        return redirect()->route('barangmasuk.index')->with('success', 'Barang Masuk berhasil ditambahkan.');
    }


    public function update(Request $request, $id)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'Id_Petugas' => 'required',
            'no_surat' => 'required',
            'namaperusahaan_pengirim' => 'required',
            'tanggal_pengirimanbarang' => 'required|date',
            'jumlah_barangmasuk' => 'required|integer|min:1',
            'file_suratjalan' => 'nullable|file|mimes:pdf,jpg,png,jpeg', // file opsional
        ]);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ambil referensi item yang akan diupdate dari Firebase
        $itemRef = $this->database->getReference('barang_masuk/' . $id);
        $currentData = $itemRef->getValue();

        // Jika file surat jalan diupload, lakukan upload
        if ($request->hasFile('file_suratjalan')) {
            $file = $request->file('file_suratjalan');
            $filePath = 'surat-jalan_barangmasuk/' . $file->getClientOriginalName();
            $this->storage->getBucket()->upload(
                fopen($file->getPathname(), 'r'),
                ['name' => $filePath]
            );
            $fileSuratJalanPath = $this->storage->getBucket()->object($filePath)->signedUrl(new \DateTime('+1 hour'));
        } else {
            $fileSuratJalanPath = $currentData['File_SuratJalan']; // gunakan yang lama jika tidak ada file baru
        }

        // Update data barang masuk
        $data = [
            'Id_Petugas' => $request->Id_Petugas,
            'No_Surat' => $request->no_surat,
            'NamaPerusahaan_Pengirim' => $request->namaperusahaan_pengirim,
            'TanggalPengiriman_Barang' => $request->tanggal_pengirimanbarang,
            'Jumlah_BarangMasuk' => $request->jumlah_barangmasuk,
            'File_SuratJalan' => $fileSuratJalanPath,
            'barang' => [],
        ];

        // Mengupdate barang yang ada
        foreach ($request->barang as $i => $barang) {
            $gambarBarangPath = null;
            // Check if a new file is uploaded
            if ($request->hasFile("barang.$i.gambar_barang")) {
                $file = $request->file("barang.$i.gambar_barang");
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'gambar_barang/' . $fileName;

                // Upload to Firebase Storage
                $bucket = $this->storage->getBucket();
                $bucket->upload(
                    fopen($file->getPathname(), 'r'),
                    ['name' => $filePath]
                );

                $gambarBarangPath = $filePath; // Store new image path
            } else {
                // Use existing image if no new image uploaded
                $gambarBarangPath = isset($currentData['barang'][$i]['gambar_barang']) ? $currentData['barang'][$i]['gambar_barang'] : null;
            }

            $JenisBarang = isset($request->Jenis_Barang[$i]) ? $request->Jenis_Barang[$i] : 'Baru';

            // Update data barang dengan gambar dan status
            $data['barang'][] = [
                'id' => $currentData['barang'][$i]['id'] ?? uniqid(), // Gunakan ID yang ada atau buat baru
                'nama_barang' => $barang['nama_barang'],
                'kode_barang' => $barang['kode_barang'],
                'kategori_barang' => $barang['kategori_barang'],
                'inisiasi_stok' => $barang['inisiasi_stok'],
                'jumlah_barang' => $barang['jumlah_barang'],
                'jenis_barang' => $JenisBarang,
                'garansi_barang_awal' => $barang['garansi_barang_awal'],
                'garansi_barang_akhir' => $barang['garansi_barang_akhir'],
                'tanggal_masuk' => $barang['tanggal_masuk'],
                'Status' => $barang['status'],
                'gambar_barang' => $gambarBarangPath,
            ];
        }

        // Update seluruh entri ke Firebase
        $itemRef->update($data);

        // Ambil ID staff gudang dan admin
        $staffId = Auth::user()->id; // Mengambil ID pengguna yang sedang login sebagai staff
        $admin = User::where('Id_Role', '1')->first(); // Ambil pengguna yang memiliki role admin
        $adminId = $admin ? $admin->id : null; // Pastikan admin ditemukan, jika tidak null

        // Cek apakah ID admin sudah didefinisikan dengan benar
        if (!$adminId) {
            return redirect()->back()->withErrors('Admin tidak ditemukan.');
        }

        // Kirim notifikasi setelah mengupdate data barang masuk
        $this->database->getReference('notifications')->push([
            'title' => 'Barang Masuk Diupdate',
            'message' => 'Pengajuan barang masuk telah diperbarui.',
            'created_at' => now(),
            'user_status' => [
                'user_' . $staffId => ['status' => 'unread'],  // Status untuk staff gudang
                'admin_' . $adminId => ['status' => 'unread']  // Status untuk admin
            ]
        ]);

        Alert::success('Berhasil', 'Barang Berhasil Diperbarui.');

        return redirect()->route('barangmasuk.index')->with('success', 'Barang Masuk berhasil diperbarui.');
    }

    public function show($id)
    {
        // Ambil data barang keluar berdasarkan id
        $BarangMasuk = $this->database->getReference('barang_masuk/' . $id)->getValue();

        // Cek apakah barang keluar ditemukan
        if (!$BarangMasuk) {
            return redirect()->route('barangmasuk.index')->with('error', 'Data barang keluar tidak ditemukan.');
        }

        // Kirim data ke view
        return view('barangmasuk.show', [
            'BarangMasuk' => $BarangMasuk,
            'id' => $id,
        ]);
    }

    public function destroy($id)
    {
        // Reference to the item in the database
        $itemRef = $this->database->getReference('barang_masuk/' . $id);

        // Get current data to find associated images
        $currentData = $itemRef->getValue();

        // Check if the item exists
        if ($currentData) {
            // Delete images from Firebase Storage if they exist
            if (isset($currentData['File_SuratJalan'])) {
                $suratJalanPath = $currentData['File_SuratJalan'];
                $this->deleteFileFromStorage($suratJalanPath);
            }

            // Delete barang images
            foreach ($currentData['barang'] as $barang) {
                if (isset($barang['gambar_barang'])) {
                    $gambarBarangPath = $barang['gambar_barang'];
                    $this->deleteFileFromStorage($gambarBarangPath);
                }
            }

            // Delete the item from the database
            $itemRef->remove();

            Alert::success('Berhasil', 'Barang Berhasil Dihapus.');
            return redirect()->route('barangmasuk.index')->with('success', 'Barang Masuk berhasil dihapus.');
        } else {
            return redirect()->route('barangmasuk.index')->withErrors('Barang Masuk tidak ditemukan.');
        }
    }

    /**
     * Function to delete a file from Firebase Storage
     */
    private function deleteFileFromStorage($filePath)
    {
        // Create a reference to the file
        $object = $this->storage->getBucket()->object($filePath);

        // Delete the file if it exists
        if ($object->exists()) {
            $object->delete();
        }
    }


    public function updateStatus(Request $request, $itemId, $barangId)
    {
        // Validasi input status
        $request->validate([
            'Status' => 'required|string|in:Accept,Pending,Reject',
        ]);

        // Path referensi ke barang tertentu
        $path = 'barang_masuk/' . $itemId . '/barang';
        $barangRef = $this->database->getReference($path);

        // Ambil semua data barang untuk item tertentu
        $barangItems = $barangRef->getValue();

        // Cari barang dengan ID yang sesuai dan perbarui status
        foreach ($barangItems as $key => $barang) {
            if ($barang['id'] == $barangId) {
                $barangRef->getChild($key)->update([
                    'Status' => $request->input('Status'),
                ]);
                break;
            }
        }

        return redirect()->route('barangmasuk.index')->with('success', 'Status barang berhasil diperbarui.');
    }


    public function updateStatusAjax(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:barang_masuk,id',
            'status' => 'required|in:Accept,Pending,Reject',
        ]);

        $barangMasuk = BarangMasuk::findOrFail($request->input('id'));
        $barangMasuk->Status = $request->input('status');
        $barangMasuk->save();

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui.']);
    }
}
