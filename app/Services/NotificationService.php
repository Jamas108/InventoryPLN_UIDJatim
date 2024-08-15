<?php

namespace App\Services;

use Kreait\Firebase\Database;

class NotificationService
{
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAllNotifications()
    {
        $notifications = $this->database->getReference('notifications')->getValue();
        return $notifications ? array_reverse($notifications) : [];
    }

    public function markAllAsRead()
    {
        $reference = $this->database->getReference('notifications');
        $notifications = $reference->getValue();

        if ($notifications) {
            foreach ($notifications as $id => $notification) {
                if ($notification['status'] === 'unread') {
                    $reference->getChild($id)->update(['status' => 'read']);
                }
            }
        }
    }

    // Tambahkan metode lain sesuai kebutuhan
}
