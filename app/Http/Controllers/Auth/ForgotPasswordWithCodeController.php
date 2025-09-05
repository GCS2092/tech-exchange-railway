<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordResetCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ForgotPasswordWithCodeController extends Controller
{
    // 1️⃣ Formulaire email
    public function showRequestForm()
    {
        return view('auth.passwords.request-code');
    }

    // 2️⃣ Envoi code OTP
    public function sendCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        // Nettoyer les anciens codes pour cet email
        PasswordResetCode::where('email', $user->email)->delete();

        $code = random_int(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        PasswordResetCode::create([
            'email' => $user->email,
            'code' => $code,
            'expires_at' => $expiresAt,
        ]);

        // Envoi du code par mail (utiliser une mailable dédiée)
        Mail::to($user->email)->send(new \App\Mail\PasswordResetCodeMail($code));

        // Stocke l'email en session pour la suite du flow
        session(['password_reset_email' => $user->email]);

        return redirect()->route('password.verify.code.form')->with('success', 'Un code a été envoyé à votre adresse email.');
    }


    // 3️⃣ Formulaire de saisie du code
    public function showVerifyForm()
    {
        return view('auth.passwords.verify-code');
    }

    // 4️⃣ Vérification du code OTP
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
        ]);

        $record = PasswordResetCode::where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$record) {
            return back()->withErrors(['code' => 'Code invalide ou expiré']);
        }

        if (now()->greaterThan($record->expires_at)) {
            $record->delete();
            return back()->withErrors(['code' => 'Le code a expiré.']);
        }

        // Supprime le code utilisé
        $record->delete();

        // Redirige vers reset-password avec token temporaire dans la session
        session()->flash('password_reset_email', $request->email);
        return redirect()->route('password.reset.form');
    }

    // 5️⃣ Réinitialisation du mot de passe
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Utilisateur introuvable.']);
        }

        $user->password = Hash::make($request->password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        // Optionnel : supprimer tous les codes restants pour cet email
        PasswordResetCode::where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez vous connecter.');
    }
}
