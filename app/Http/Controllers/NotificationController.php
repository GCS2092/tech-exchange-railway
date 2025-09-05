<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $unreadNotifications = auth()->user()->unreadNotifications;

        if ($request->ajax()) {
            return response()->json($unreadNotifications);
        }

        $readNotifications = auth()->user()->readNotifications()->limit(10)->get();

        return view('notifications.index', [
            'unreadNotifications' => $unreadNotifications,
            'readNotifications' => $readNotifications,
        ]);
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notification marquée comme lue');
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues');
    }
    public function clearAll()
{
    $user = Auth::user();

    // Supprimer toutes les notifications (non lues et lues)
    $user->notifications()->delete();

    return back()->with('success', 'Toutes les notifications ont été supprimées.');
}
}

