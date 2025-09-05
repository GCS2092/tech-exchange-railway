<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactAdminController extends Controller
{
    public function show(Request $request)
    {
        $user = User::findOrFail($request->query('user'));
        return view('contact-admin', compact('user'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|min:10',
        ]);
        $user = User::findOrFail($request->user_id);
        $admin = User::role('admin')->first();
        Mail::raw("Demande de déblocage du compte utilisateur :\n\n" . $request->message . "\n\nUtilisateur : " . $user->email, function ($m) use ($admin) {
            $m->to($admin->email)->subject('Demande de déblocage de compte');
        });
        return redirect()->route('login')->with('status', 'Votre demande a été envoyée à l\'administrateur.');
    }
}
