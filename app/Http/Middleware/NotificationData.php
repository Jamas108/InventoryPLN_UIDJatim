<?php

namespace App\Http\Middleware;

use Closure;
use Kreait\Firebase\Factory;

class NotificationData
{
    protected $database;

    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env("FIREBASE_DATABASE_URL"));

        $this->database = $firebase->createDatabase();
    }

    public function handle($request, Closure $next)
    {
        $notifications = $this->database->getReference('notifications')->getValue();
        $notifications = $notifications ? array_reverse($notifications) : [];

        // Cek apakah pengguna terautentikasi
        $user = auth()->user();

        if ($user) {
            // Mendapatkan ID pengguna dan role pengguna yang sedang login
            $userId = $user->id;
            $roleId = $user->Id_Role;
            $roleKey = $roleId == 1 ? 'admin_' . $userId : 'user_' . $userId;

            $unreadNotificationsCount = 0;
            foreach ($notifications as $notification) {
                if (isset($notification['user_status'][$roleKey]['status']) && 
                    $notification['user_status'][$roleKey]['status'] === 'unread') {
                    $unreadNotificationsCount++;
                }
            }

            view()->share('unreadNotificationsCount', $unreadNotificationsCount);
        } else {
            // Jika pengguna tidak terautentikasi, set jumlah notifikasi tidak terbaca menjadi 0
            view()->share('unreadNotificationsCount', 0);
        }

        return $next($request);
    }
}

