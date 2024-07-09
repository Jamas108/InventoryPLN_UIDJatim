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

    // Mark a notification as read
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->status = 'read';  // Ensure this line sets the notification status to 'read'
        $notification->save();

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    // Delete a notification
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted successfully.');
    }
}
