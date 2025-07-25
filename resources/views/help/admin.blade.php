@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                ⚙️ Guide d'administration
            </h1>
            <p class="text-xl text-gray-600">
                Gestion complète de la plateforme cosmétique
            </p>
        </div>

        <!-- Navigation rapide -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <a href="#produits" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-center">
                    <div class="text-3xl mb-3">📦</div>
                    <h3 class="text-lg font-semibold text-gray-900">Produits</h3>
                    <p class="text-gray-600 text-sm">Gérer le catalogue</p>
                </div>
            </a>
            
            <a href="#commandes" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-center">
                    <div class="text-3xl mb-3">📋</div>
                    <h3 class="text-lg font-semibold text-gray-900">Commandes</h3>
                    <p class="text-gray-600 text-sm">Suivre les ventes</p>
                </div>
            </a>
            
            <a href="#utilisateurs" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-center">
                    <div class="text-3xl mb-3">👥</div>
                    <h3 class="text-lg font-semibold text-gray-900">Utilisateurs</h3>
                    <p class="text-gray-600 text-sm">Gérer les comptes</p>
                </div>
            </a>
            
            <a href="#promotions" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-center">
                    <div class="text-3xl mb-3">🎁</div>
                    <h3 class="text-lg font-semibold text-gray-900">Promotions</h3>
                    <p class="text-gray-600 text-sm">Codes promo</p>
                </div>
            </a>
        </div>

        <!-- Contenu principal -->
        <div class="space-y-12">
            <!-- Section Produits -->
            <section id="produits" class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-3xl mr-3">📦</span>
                    Gestion des produits
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Ajouter un produit</h3>
                        <ol class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 mt-0.5">1</span>
                                Cliquez sur "Ajouter produit" dans le menu
                            </li>
                            <li class="flex items-start">
                                <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 mt-0.5">2</span>
                                Remplissez tous les champs obligatoires
                            </li>
                            <li class="flex items-start">
                                <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 mt-0.5">3</span>
                                Ajoutez des images du produit
                            </li>
                            <li class="flex items-start">
                                <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 mt-0.5">4</span>
                                Sauvegardez le produit
                            </li>
                        </ol>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Gérer le stock</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                <strong>Mise à jour automatique :</strong> Le stock se met à jour lors des commandes
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                <strong>Alertes :</strong> Notifications quand le stock est faible
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                <strong>Désactivation :</strong> Produits automatiquement masqués si stock = 0
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Section Commandes -->
            <section id="commandes" class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-3xl mr-3">📋</span>
                    Gestion des commandes
                </h2>
                
                <div class="space-y-8">
                    <div class="border-l-4 border-green-500 pl-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Suivi des commandes</h3>
                        <p class="text-gray-600 mb-4">
                            Consultez toutes les commandes en cours et terminées. Vous pouvez voir les détails, modifier le statut et gérer les livraisons.
                        </p>
                        <div class="bg-green-50 rounded-lg p-4">
                            <p class="text-green-800 text-sm">
                                💡 <strong>Statuts :</strong> En attente → Payée → Expédiée → Livrée
                            </p>
                        </div>
                    </div>
                    
                    <div class="border-l-4 border-orange-500 pl-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Gestion des retours</h3>
                        <p class="text-gray-600 mb-4">
                            Traitez les demandes de retour et remboursement. Vous pouvez valider ou refuser selon la politique de l'entreprise.
                        </p>
                        <div class="bg-orange-50 rounded-lg p-4">
                            <p class="text-orange-800 text-sm">
                                💡 <strong>Rappel :</strong> Vérifiez toujours l'état du produit retourné.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Utilisateurs -->
            <section id="utilisateurs" class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-3xl mr-3">👥</span>
                    Gestion des utilisateurs
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Rôles et permissions</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">👤</span>
                                <strong>Client :</strong> Accès aux achats et profil
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">🚚</span>
                                <strong>Livreur :</strong> Gestion des livraisons
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">⚙️</span>
                                <strong>Admin :</strong> Accès complet à l'administration
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Actions possibles</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">✓</span>
                                Modifier les informations utilisateur
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">✓</span>
                                Changer le rôle d'un utilisateur
                            </li>
                            <li class="flex items-start">
                                <span class="text-red-500 mr-2">⚠</span>
                                Suspendre un compte (si nécessaire)
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Section Promotions -->
            <section id="promotions" class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-3xl mr-3">🎁</span>
                    Gestion des promotions
                </h2>
                
                <div class="space-y-8">
                    <div class="border-l-4 border-purple-500 pl-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Créer un code promo</h3>
                        <ol class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <span class="bg-purple-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 mt-0.5">1</span>
                                Accédez à la section "Codes promo"
                            </li>
                            <li class="flex items-start">
                                <span class="bg-purple-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 mt-0.5">2</span>
                                Choisissez le type (pourcentage ou montant fixe)
                            </li>
                            <li class="flex items-start">
                                <span class="bg-purple-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 mt-0.5">3</span>
                                Définissez la date d'expiration
                            </li>
                            <li class="flex items-start">
                                <span class="bg-purple-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3 mt-0.5">4</span>
                                Générez ou saisissez le code
                            </li>
                        </ol>
                    </div>
                    
                    <div class="bg-purple-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-purple-900 mb-3">Types de promotions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-semibold text-purple-800">Pourcentage</h4>
                                <p class="text-purple-700 text-sm">Ex: 20% de réduction sur tout le panier</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-purple-800">Montant fixe</h4>
                                <p class="text-purple-700 text-sm">Ex: 10€ de réduction à partir de 50€</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Statistiques -->
            <section class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-3xl mr-3">📊</span>
                    Statistiques et rapports
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-6 bg-blue-50 rounded-xl">
                        <div class="text-3xl mb-2">💰</div>
                        <h3 class="font-semibold text-gray-900">Ventes</h3>
                        <p class="text-gray-600 text-sm">Suivi des revenus</p>
                    </div>
                    
                    <div class="text-center p-6 bg-green-50 rounded-xl">
                        <div class="text-3xl mb-2">📦</div>
                        <h3 class="font-semibold text-gray-900">Produits</h3>
                        <p class="text-gray-600 text-sm">Stock et popularité</p>
                    </div>
                    
                    <div class="text-center p-6 bg-purple-50 rounded-xl">
                        <div class="text-3xl mb-2">👥</div>
                        <h3 class="font-semibold text-gray-900">Clients</h3>
                        <p class="text-gray-600 text-sm">Fidélisation</p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Bouton retour -->
        <div class="text-center mt-12">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour au dashboard
            </a>
        </div>
    </div>
</div>
<x-onboarding-button tourId="help-admin" position="fixed" />
@endsection 