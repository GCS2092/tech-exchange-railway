<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{
    public function index()
    {
        // Récupérer les produits en vedette
        $featuredProducts = Product::where('is_featured', true)
            ->take(8)
            ->get();

        // Récupérer toutes les catégories avec le nombre de produits
        $categories = Cache::remember('home.categories', 3600, function () {
            return Category::withCount('products')
                ->orderBy('name')
                ->get()
                ->map(function ($category) {
                    // Ajouter des icônes et couleurs basées sur le nom de la catégorie
                    $category->icon = $this->getCategoryIcon($category->name);
                    $category->color = $this->getCategoryColor($category->name);
                    return $category;
                });
        });

        return view('welcome', compact('featuredProducts', 'categories'));
    }

    /**
     * Retourne l'icône SVG correspondant à une catégorie
     */
    private function getCategoryIcon($categoryName)
    {
        $categoryName = strtolower($categoryName);
        
        $icons = [
            'smartphones' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a1 1 0 001-1V4a1 1 0 00-1-1H8a1 1 0 00-1 1v16a1 1 0 001 1z"></path>',
            'ordinateurs' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>',
            'ordinateurs portables' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>',
            'ordinateurs de bureau' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>',
            'gaming' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.01M15 10h1.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
            'consoles de jeu' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.01M15 10h1.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
            'audio' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>',
            'écouteurs' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>',
            'tablettes' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>',
            'accessoires' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>',
            'montres connectées' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
            'appareils photo' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>',
            'photo/vidéo' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>',
        ];

        // Retourner l'icône correspondante ou une icône par défaut
        return $icons[$categoryName] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>';
    }

    /**
     * Retourne la couleur correspondant à une catégorie
     */
    private function getCategoryColor($categoryName)
    {
        $categoryName = strtolower($categoryName);
        
        $colors = [
            'smartphones' => 'from-cyan-500 to-blue-600',
            'ordinateurs' => 'from-blue-500 to-indigo-600',
            'ordinateurs portables' => 'from-blue-500 to-indigo-600',
            'ordinateurs de bureau' => 'from-indigo-500 to-purple-600',
            'gaming' => 'from-purple-500 to-pink-600',
            'consoles de jeu' => 'from-purple-500 to-pink-600',
            'audio' => 'from-green-500 to-emerald-600',
            'écouteurs' => 'from-green-500 to-teal-600',
            'tablettes' => 'from-yellow-500 to-orange-600',
            'accessoires' => 'from-red-500 to-pink-600',
            'montres connectées' => 'from-rose-500 to-red-600',
            'appareils photo' => 'from-violet-500 to-purple-600',
            'photo/vidéo' => 'from-violet-500 to-purple-600',
        ];

        return $colors[$categoryName] ?? 'from-gray-500 to-gray-600';
    }

    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255'
        ]);

        // Ici vous pouvez ajouter la logique pour sauvegarder l'email
        // Par exemple, créer une table newsletter_subscribers
        
        return redirect()->back()->with('success', 'Merci pour votre inscription à notre newsletter !');
    }
} 