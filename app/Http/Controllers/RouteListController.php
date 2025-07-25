<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class RouteListController extends Controller
{
    public function show()
    {
        // Récupérer toutes les routes
        $routes = Route::getRoutes();
        
        // Retourner la vue avec les routes
        return view('route-list', compact('routes'));
    }
}
