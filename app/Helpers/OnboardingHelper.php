<?php

namespace App\Helpers;

class OnboardingHelper
{
    /**
     * Vérifier si un utilisateur a déjà vu un tour
     */
    public static function hasSeenTour($userId, $tourId): bool
    {
        // Pour l'instant, on utilise le localStorage côté client
        // Plus tard, on pourra stocker en base de données
        return false;
    }
    
    /**
     * Marquer un tour comme vu
     */
    public static function markTourAsSeen($userId, $tourId): void
    {
        // À implémenter avec la base de données
    }
    
    /**
     * Obtenir les étapes d'un tour
     */
    public static function getTourSteps($tourId): array
    {
        $tours = [
            'welcome' => [
                [
                    'target' => '.main-navigation',
                    'title' => 'Navigation principale',
                    'description' => 'Utilisez ce menu pour naviguer entre les différentes sections de votre espace personnel.',
                    'position' => 'bottom'
                ],
                [
                    'target' => '.search-bar',
                    'title' => 'Recherche rapide',
                    'description' => 'Trouvez rapidement vos produits préférés en utilisant notre barre de recherche.',
                    'position' => 'bottom'
                ],
                [
                    'target' => '.user-menu',
                    'title' => 'Menu utilisateur',
                    'description' => 'Accédez à votre profil, vos commandes et vos paramètres depuis ce menu.',
                    'position' => 'bottom'
                ]
            ],
            'dashboard' => [
                [
                    'target' => '.stats-cards',
                    'title' => 'Vos statistiques',
                    'description' => 'Consultez un aperçu de vos activités et de vos points fidélité.',
                    'position' => 'bottom'
                ],
                [
                    'target' => '.recent-orders',
                    'title' => 'Commandes récentes',
                    'description' => 'Retrouvez ici vos dernières commandes et leur statut.',
                    'position' => 'top'
                ],
                [
                    'target' => '.quick-actions',
                    'title' => 'Actions rapides',
                    'description' => 'Accédez rapidement aux fonctionnalités les plus utilisées.',
                    'position' => 'top'
                ]
            ],
            'products' => [
                [
                    'target' => '.filters',
                    'title' => 'Filtres de recherche',
                    'description' => 'Affinez votre recherche en utilisant les filtres par catégorie, prix, etc.',
                    'position' => 'bottom'
                ],
                [
                    'target' => '.product-grid',
                    'title' => 'Grille de produits',
                    'description' => 'Parcourez nos produits cosmétiques. Cliquez sur un produit pour voir les détails.',
                    'position' => 'top'
                ],
                [
                    'target' => '.wishlist-button',
                    'title' => 'Liste de souhaits',
                    'description' => 'Ajoutez vos produits préférés à votre liste de souhaits pour les retrouver facilement.',
                    'position' => 'left'
                ]
            ],
            'cart' => [
                [
                    'target' => '.cart-items',
                    'title' => 'Votre panier',
                    'description' => 'Vérifiez les produits dans votre panier avant de passer commande.',
                    'position' => 'bottom'
                ],
                [
                    'target' => '.cart-summary',
                    'title' => 'Résumé de commande',
                    'description' => 'Consultez le total de votre commande et les frais de livraison.',
                    'position' => 'top'
                ],
                [
                    'target' => '.checkout-button',
                    'title' => 'Passer commande',
                    'description' => 'Cliquez ici pour finaliser votre commande et choisir votre mode de livraison.',
                    'position' => 'top'
                ]
            ],
            'profile' => [
                [
                    'target' => '.profile-info',
                    'title' => 'Informations personnelles',
                    'description' => 'Gérez vos informations personnelles et vos préférences.',
                    'position' => 'bottom'
                ],
                [
                    'target' => '.addresses',
                    'title' => 'Adresses de livraison',
                    'description' => 'Ajoutez et gérez vos adresses de livraison pour des commandes plus rapides.',
                    'position' => 'top'
                ],
                [
                    'target' => '.security-settings',
                    'title' => 'Sécurité',
                    'description' => 'Modifiez votre mot de passe et gérez la sécurité de votre compte.',
                    'position' => 'top'
                ]
            ]
        ];
        
        return $tours[$tourId] ?? [];
    }
    
    /**
     * Générer le JavaScript pour les étapes d'un tour
     */
    public static function generateTourScript($tourId): string
    {
        $steps = self::getTourSteps($tourId);
        $stepsJson = json_encode($steps, JSON_UNESCAPED_UNICODE);
        
        return "window.tourSteps_{$tourId} = {$stepsJson};";
    }
    
    /**
     * Vérifier si un tour doit être affiché automatiquement
     */
    public static function shouldAutoStart($tourId, $userId = null): bool
    {
        // Tour welcome automatique à la première visite
        if ($tourId === 'welcome') {
            return true;
        }
        
        // Autres tours : manuels via bouton d'aide
        return false;
    }
} 