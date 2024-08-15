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

        $unreadNotificationsCount = 0;
        foreach ($notifications as $notification) {
            if ($notification['status'] === 'unread') {
                $unreadNotificationsCount++;
            }
        }

        view()->share('unreadNotificationsCount', $unreadNotificationsCount);

        return $next($request);
    }
}
