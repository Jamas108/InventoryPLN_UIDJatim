<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display a listing of the notifications
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->get();
        return view('notifications.index', compact('notifications'));
    }

    public function markAllAsRead()
    {
        Notification::where('status', 'unread')->update(['status' => 'read']);
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        if ($notification && $notification->status == 'unread') {
            $notification->status = 'read';
            $notification->save();
        }
        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    // Delete a notification
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted successfully.');
    }

    public function destroyAll()
    {
        Notification::truncate(); // Menghapus semua data notifikasi
        return redirect()->route('notifications.index')->with('success', 'All notifications have been deleted.');
    }

    public function bulkMarkAsRead(Request $request)
    {
        $notificationIds = explode(',', $request->input('notification_ids'));
        Notification::whereIn('id', $notificationIds)->update(['status' => 'read']);

        return redirect()->back()->with('success', 'Selected notifications marked as read.');
    }

    public function bulkDelete(Request $request)
    {
        $notificationIds = explode(',', $request->input('notification_ids'));
        Notification::whereIn('id', $notificationIds)->delete();

        return redirect()->back()->with('success', 'Selected notifications deleted.');
    }
}
