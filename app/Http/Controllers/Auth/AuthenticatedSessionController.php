<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{ 
    public function create(): View
    {
        return view('auth.login');
    }
    

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('goodbye');
    }
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
    
        // Mise à jour de la dernière connexion
        auth()->user()->update(['last_login_at' => now()]);
    
        // Redirection en fonction du rôle
        if (auth()->user()->hasRole('admin')) {
            return redirect()->intended(route('admin.dashboard'));
        } elseif (auth()->user()->hasRole('vendeur')) {
            return redirect()->intended(route('vendeur.dashboard'));
        } elseif (auth()->user()->hasRole('livreur')) {
            return redirect()->intended(route('livreurs.orders.index'));
        } else {
            return redirect()->intended(route('dashboard'));
        }
    }
    


}
