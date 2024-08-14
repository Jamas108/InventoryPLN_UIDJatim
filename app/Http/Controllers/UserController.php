<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Hash;
use Kreait\Firebase\Auth as FirebaseAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $auth;
    protected $database;

    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env("FIREBASE_DATABASE_URL"));

        $this->auth = $firebase->createAuth();
        $this->database = $firebase->createDatabase();
        $this->middleware('auth');
    }
    public function index()
    {
        $users = User::with(['userRole'])->get();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    public function viewCreateUser()
    {
        return view('user.createuser');
    }


    public function createUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
            'nomorhp' => 'required|string|max:20',
            'password' => 'required|string|min:6',
            'status' => 'required|string'
        ]);

        try {
            // Create user in Firebase Authentication
            $user = $this->auth->createUserWithEmailAndPassword(
                $request->input('email'),
                $request->input('password')
            );

            $uid = $user->uid;

            // Save user data to Firebase Realtime Database
            $this->database->getReference('users/' . $uid)->set([
                'email' => $request->input('email'),
                'name' => $request->input('name'),
                'nomorhp' => $request->input('nomorhp'),
                'status' => $request->input('status'),
                'uid' => $uid
            ]);

            return redirect()->back()->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           // Validasi data
           $request->validate([
            'Nama' => 'required|string|max:255',
            'Jenis_Kelamin' => 'required|string|max:10',
            'No_Telepon' => 'required|string|max:15',
            'Alamat' => 'required|string|max:255',
            'Instansi' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Simpan data pegawai
        User::create([
            'Nama' => $request->Nama,
            'Jenis_Kelamin' => $request->Jenis_Kelamin,
            'No_Telepon' => $request->No_Telepon,
            'Alamat' => $request->Alamat,
            'Instansi' => $request->Instansi,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'Id_Role' => '2',
        ]);

        return redirect()->route('user.index')->with('success', 'Pegawai berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = UserRole::all(); // Ambil semua role untuk dropdown
        return view('user.edit', compact('user', 'roles'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:users_role,id', // Validasi input role
        ]);

        $user = User::findOrFail($id);
        $user->Id_Role = $request->input('role_id');
        $user->save();

        return redirect()->route('user.index', $id)->with('success', 'User role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
