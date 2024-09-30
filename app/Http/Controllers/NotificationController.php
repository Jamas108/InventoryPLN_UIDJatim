<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class NotificationController extends Controller
{
    protected $database;

    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env("FIREBASE_DATABASE_URL"));

        $this->database = $firebase->createDatabase();
        $this->middleware('auth');
    }

    // Display a listing of the notifications
    public function index()
    {
        $notifications = $this->database->getReference('notifications')->getValue();
        $notifications = $notifications ? array_reverse($notifications) : []; // Urutkan dari yang terbaru

        // Mendapatkan ID dan role pengguna yang sedang login
        $userId = auth()->user()->id;
        $roleId = auth()->user()->Id_Role;
        $roleKey = $roleId == 1 ? 'admin_' . $userId : 'user_' . $userId;

        // Hitung notifikasi yang belum dibaca berdasarkan status dalam `user_status`
        $unreadNotificationsCount = array_reduce($notifications, function ($carry, $notification) use ($roleKey) {
            return $carry + (
                isset($notification['user_status'][$roleKey]['status']) &&
                $notification['user_status'][$roleKey]['status'] === 'unread' ? 1 : 0
            );
        }, 0);

        return view('notifications.index', compact('notifications', 'unreadNotificationsCount'));
    }


    // Mark all notifications as read
    public function markAllAsRead()
    {
        $reference = $this->database->getReference('notifications');
        $notifications = $reference->getValue();

        $userId = auth()->user()->id;
        $roleId = auth()->user()->Id_Role;
        $roleKey = $roleId == 1 ? 'admin_' . $userId : 'user_' . $userId;

        if ($notifications) {
            foreach ($notifications as $id => $notification) {
                if (isset($notification['user_status'][$roleKey]['status']) && $notification['user_status'][$roleKey]['status'] === 'unread') {
                    $reference->getChild($id . '/user_status/' . $roleKey)->update(['status' => 'read']);
                }
            }
        }

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }


    // Mark a specific notification as read
    public function markAsRead($notificationId)
    {
        $userId = auth()->user()->id;
        $roleId = auth()->user()->Id_Role;
        $roleKey = $roleId == 1 ? 'admin_' . $userId : 'user_' . $userId;

        // Update status untuk user yang login
        $reference = $this->database->getReference('notifications/' . $notificationId . '/user_status/' . $roleKey);
        $userStatus = $reference->getValue();

        if ($userStatus && isset($userStatus['status']) && $userStatus['status'] === 'unread') {
            $reference->update(['status' => 'read']);
        }

        return redirect()->back()->with('success', 'Notification marked as read.');
    }


    // Delete a specific notification
    public function destroy($id)
    {
        $reference = $this->database->getReference('notifications/' . $id);
        $reference->remove();

        return redirect()->back()->with('success', 'Notification deleted successfully.');
    }

    // Delete all notifications
    public function destroyAll()
    {
        $reference = $this->database->getReference('notifications');
        $reference->remove();

        return redirect()->route('notifications.index')->with('success', 'All notifications have been deleted.');
    }

    // Bulk mark notifications as read
    public function bulkMarkAsRead(Request $request)
    {
        $notificationIds = explode(',', $request->input('notification_ids'));
        $reference = $this->database->getReference('notifications');

        foreach ($notificationIds as $id) {
            $notification = $reference->getChild($id)->getValue();
            if ($notification && $notification['status'] === 'unread') {
                $reference->getChild($id)->update(['status' => 'read']);
            }
        }

        return redirect()->back()->with('success', 'Selected notifications marked as read.');
    }

    // Bulk delete notifications
    public function bulkDelete(Request $request)
    {
        $notificationIds = explode(',', $request->input('notification_ids'));
        $reference = $this->database->getReference('notifications');

        foreach ($notificationIds as $id) {
            $reference->getChild($id)->remove();
        }

        return redirect()->back()->with('success', 'Selected notifications deleted.');
    }
}
