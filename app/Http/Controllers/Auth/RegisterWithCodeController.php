<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegisterCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class RegisterWithCodeController extends Controller
{
    public function showForm()
    {
        return view('auth.register-multi-step');
    }

    public function handleStep(Request $request)
    {
        $step = Session::get('register_step');
        $response = null;
    
        if (is_null($step)) {
            $response = $this->handleStep1($request);
        } elseif ($step == 2) {
            $response = $this->handleStep2($request);
        } elseif ($step == 3) {
            $response = $this->handleStep3($request);
        } else {
            $response = redirect()->route('register');
        }
    
        return $response;
    }
    

    private function handleStep1(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email',
        ]);

        $code = random_int(100000, 999999);

        Session::put('register_name', $request->name);
        Session::put('register_email', $request->email);
        Session::put('register_code', $code);
        Session::put('register_step', 2);

        Mail::to($request->email)->send(new RegisterCodeMail($code));

        return back()->with('success', 'Un code vous a été envoyé par mail.');
    }

    private function handleStep2(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        if ((int)$request->code !== (int)Session::get('register_code')) {
            return back()->withErrors(['code' => 'Code invalide.']);
        }

        Session::put('register_step', 3);

        return back()->with('success', 'Code vérifié. Définissez un mot de passe.');
    }

    private function handleStep3(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        ]);

        $user = User::create([
            'name' => Session::get('register_name'),
            'email' => Session::get('register_email'),
            'password' => Hash::make($request->password),
        ]);

        auth()->login($user);
        Session::forget(['register_name', 'register_email', 'register_code', 'register_step']);

        return redirect()->route('dashboard')->with('success', 'Inscription réussie.');
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email'
        ]);
    
         
        $code = random_int(100000, 999999);
    
        Session::put('register_name', $request->name);
        Session::put('register_email', $request->email);
        Session::put('register_code', $code);
        Session::put('register_step', 2);
    
        Mail::to($request->email)->send(new RegisterCodeMail($code));
    
        return redirect()->route('register.verify')->with('status', 'Code envoyé par email.');

    }
    

    public function showVerifyForm()
    {
        $email = Session::get('register_email');
        return view('auth.verify-code', compact('email'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        if ((int)$request->code !== (int)Session::get('register_code')) {
            return back()->withErrors(['code' => 'Code incorrect.']);
        }

        Session::put('register_step', 3);

        return redirect()->route('register.set.password');
    }

    public function showSetPasswordForm()
    {
        if (Session::get('register_step') !== 3) {
            return redirect()->route('register')->withErrors(['code' => 'Accès non autorisé.']);
        }

        return view('auth.set-password');
    }

    public function setPassword(Request $request)
{
    $request->validate([
        'username' => 'required|alpha_dash|min:3|max:30|unique:users,username', // ✅ Correction ici
        'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $photoPath = null;
    if ($request->hasFile('profile_photo')) {
        $photoPath = $request->file('profile_photo')->store('profiles', 'public');
    }

    $user = User::create([
        'name' => Session::get('register_name'),          // ✅ récupéré depuis session
        'username' => $request->username,                 // ✅ champ distinct maintenant
        'email' => Session::get('register_email'),
        'password' => Hash::make($request->password),
        'profile_photo' => $photoPath,
        'role' => 'user',
    ]);

    auth()->login($user);
    Session::forget(['register_name', 'register_email', 'register_code', 'register_step']);

    return redirect()->route('dashboard')->with('success', 'Votre compte a été créé.');
}

    
    public function resendCode()
    {
        $name = Session::get('register_name');
        $email = Session::get('register_email');

        if (!$email || !$name) {
            return redirect()->route('register')->withErrors(['code' => 'Informations manquantes. Veuillez recommencer.']);
        }

        $code = random_int(100000, 999999);
        Session::put('register_code', $code);
        Session::put('register_step', 2);

        Mail::to($email)->send(new RegisterCodeMail($code));

        return back()->with('success', 'Un nouveau code vous a été envoyé.');
    }
}