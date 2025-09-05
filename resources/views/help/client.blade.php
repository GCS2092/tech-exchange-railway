@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 to-purple-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">
                🛍️ Guide d'utilisation - Espace Client
            </h1>
            <p class="text-xl text-gray-600">
                Découvrez comment utiliser notre plateforme de cosmétiques
            </p>
        </div>

        <!-- Navigation rapide -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <a href="#navigation" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-center">
                    <div class="text-xl mb-3">🧭</div>
                    <h3 class="text-lg font-semibold text-gray-900">Navigation</h3>
                    <p class="text-gray-600 text-sm">Apprenez à naviguer dans l'application</p>
                </div>
            </a>
            
            <a href="#achats" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-center">
                    <div class="text-xl mb-3">🛒</div>
                    <h3 class="text-lg font-semibold text-gray-900">Achats</h3>
                    <p class="text-gray-600 text-sm">Comment acheter vos produits</p>
                </div>
            </a>
            
            <a href="#profil" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-center">
                    <div class="text-xl mb-3">👤</div>
                    <h3 class="text-lg font-semibold text-gray-900">Profil</h3>
                    <p class="text-gray-600 text-sm">Gérez votre compte</p>
                </div>
            </a>
        </div>

        <!-- Contenu principal -->
        <div class="space-y-12">
            <!-- Section Navigation -->
            <section id="navigation" class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-xl mr-3">🧭</span>
                    Navigation dans l'application
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Menu principal</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <span class="text-purple-500 mr-2">•</span>
                                <strong>Dashboard :</strong> Votre tableau de bord personnel
                            </li>
                            <li class="flex items-start">
                                <span class="text-purple-500 mr-2">•</span>
                                <strong>Nos Produits :</strong> Catalogue complet des cosmétiques
                            </li>
                            <li class="flex items-start">
                                <span class="text-purple-500 mr-2">•</span>
                                <strong>Mes Commandes :</strong> Historique et suivi de vos commandes
                            </li>
                            <li class="flex items-start">
                                <span class="text-purple-500 mr-2">•</span>
                                <strong>Codes promo :</strong> Promotions et réductions disponibles
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Fonctions rapides</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <span class="text-pink-500 mr-2">🛒</span>
                                <strong>Panier :</strong> Accès direct depuis l'icône en haut à droite
                            </li>
                            <li class="flex items-start">
                                <span class="text-pink-500 mr-2">🔔</span>
                                <strong>Notifications :</strong> Restez informé des nouveautés
                            </li>
                            <li class="flex items-start">
                                <span class="text-pink-500 mr-2">👤</span>
                                <strong>Profil :</strong> Menu déroulant pour accéder à vos paramètres
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Section Achats -->
            <section id="achats" class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-xl mr-3">🛒</span>
                    Comment acheter vos produits
                </h2>
                
                <div class="space-y-8">
                    <div class="border-l-4 border-purple-500 pl-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Étape 1 : Parcourir le catalogue</h3>
                        <p class="text-gray-600 mb-4">
                            Naviguez dans notre catalogue de produits cosmétiques. Utilisez les filtres pour affiner votre recherche par catégorie, prix ou disponibilité.
                        </p>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <p class="text-purple-800 text-sm">
                                💡 <strong>Astuce :</strong> Cliquez sur un produit pour voir ses détails et photos.
                            </p>
                        </div>
                    </div>
                    
                    <div class="border-l-4 border-pink-500 pl-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Étape 2 : Ajouter au panier</h3>
                        <p class="text-gray-600 mb-4">
                            Une fois votre produit sélectionné, choisissez la quantité et cliquez sur "Ajouter au panier". Vous pouvez continuer vos achats ou passer à la commande.
                        </p>
                        <div class="bg-pink-50 rounded-lg p-4">
                            <p class="text-pink-800 text-sm">
                                💡 <strong>Astuce :</strong> Le nombre d'articles dans votre panier s'affiche en temps réel.
                            </p>
                        </div>
                    </div>
                    
                    <div class="border-l-4 border-green-500 pl-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Étape 3 : Finaliser la commande</h3>
                        <p class="text-gray-600 mb-4">
                            Dans votre panier, vérifiez vos articles, appliquez un code promo si vous en avez un, puis cliquez sur "Passer commande" pour finaliser votre achat.
                        </p>
                        <div class="bg-green-50 rounded-lg p-4">
                            <p class="text-green-800 text-sm">
                                💡 <strong>Astuce :</strong> Vous recevrez une confirmation par email avec le numéro de suivi.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Profil -->
            <section id="profil" class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-xl mr-3">👤</span>
                    Gérer votre profil
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Informations personnelles</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <span class="text-purple-500 mr-2">•</span>
                                Modifiez votre nom et email
                            </li>
                            <li class="flex items-start">
                                <span class="text-purple-500 mr-2">•</span>
                                Changez votre mot de passe
                            </li>
                            <li class="flex items-start">
                                <span class="text-purple-500 mr-2">•</span>
                                Ajoutez une photo de profil
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Fonctionnalités</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <span class="text-pink-500 mr-2">🎁</span>
                                <strong>Programme de fidélité :</strong> Cumulez des points
                            </li>
                            <li class="flex items-start">
                                <span class="text-pink-500 mr-2">📋</span>
                                <strong>Historique :</strong> Consultez vos commandes
                            </li>
                            <li class="flex items-start">
                                <span class="text-pink-500 mr-2">🔔</span>
                                <strong>Notifications :</strong> Gérez vos alertes
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Section FAQ -->
            <section class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-xl mr-3">❓</span>
                    Questions fréquentes
                </h2>
                
                <div class="space-y-6">
                    <div class="border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Comment suivre ma commande ?</h3>
                        <p class="text-gray-600">
                            Allez dans "Mes Commandes" et cliquez sur votre commande. Vous verrez le statut en temps réel.
                        </p>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Comment utiliser un code promo ?</h3>
                        <p class="text-gray-600">
                            Dans votre panier, saisissez le code dans le champ "Code promo" et cliquez sur "Appliquer".
                        </p>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Comment contacter le support ?</h3>
                        <p class="text-gray-600">
                            Utilisez le formulaire de contact ou envoyez un email à support@monsitecosmetique.com
                        </p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Bouton retour -->
        <div class="text-center mt-12">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-300 transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour au dashboard
            </a>
        </div>
    </div>
</div>
<x-onboarding-button tourId="help-client" position="fixed" />
@endsection 