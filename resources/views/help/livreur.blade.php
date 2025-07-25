@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                🚚 Guide du livreur
            </h1>
            <p class="text-xl text-gray-600">
                Gestion efficace des livraisons
            </p>
        </div>

        <!-- Navigation rapide -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <a href="#commandes" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-center">
                    <div class="text-3xl mb-3">📋</div>
                    <h3 class="text-lg font-semibold text-gray-900">Commandes</h3>
                    <p class="text-gray-600 text-sm">Voir vos livraisons</p>
                </div>
            </a>
            
            <a href="#livraison" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-center">
                    <div class="text-3xl mb-3">🚚</div>
                    <h3 class="text-lg font-semibold text-gray-900">Livraison</h3>
                    <p class="text-gray-600 text-sm">Marquer comme livré</p>
                </div>
            </a>
            
            <a href="#navigation" class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-center">
                    <div class="text-3xl mb-3">🗺️</div>
                    <h3 class="text-lg font-semibold text-gray-900">Navigation</h3>
                    <p class="text-gray-600 text-sm">Itinéraires</p>
                </div>
            </a>
        </div>

        <!-- Contenu principal -->
        <div class="space-y-12">
            <!-- Section Commandes -->
            <section id="commandes" class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-3xl mr-3">📋</span>
                    Consulter vos commandes
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Liste des livraisons</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">•</span>
                                <strong>En attente :</strong> Commandes prêtes à être livrées
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">•</span>
                                <strong>En cours :</strong> Livraisons en route
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">•</span>
                                <strong>Terminées :</strong> Livraisons effectuées
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Informations affichées</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">📍</span>
                                Adresse de livraison complète
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">📞</span>
                                Numéro de téléphone client
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">📦</span>
                                Détails des produits commandés
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">⏰</span>
                                Date et heure de commande
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Section Livraison -->
            <section id="livraison" class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-3xl mr-3">🚚</span>
                    Effectuer une livraison
                </h2>
                
                <div class="space-y-8">
                    <div class="border-l-4 border-green-500 pl-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Étape 1 : Préparation</h3>
                        <p class="text-gray-600 mb-4">
                            Vérifiez que vous avez bien tous les produits de la commande avant de partir. Assurez-vous que les produits sont en bon état.
                        </p>
                        <div class="bg-green-50 rounded-lg p-4">
                            <p class="text-green-800 text-sm">
                                💡 <strong>Vérification :</strong> Contrôlez la liste des articles dans l'application.
                            </p>
                        </div>
                    </div>
                    
                    <div class="border-l-4 border-blue-500 pl-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Étape 2 : Livraison</h3>
                        <p class="text-gray-600 mb-4">
                            Livrez la commande à l'adresse indiquée. Remettez les produits au client et récupérez sa signature si nécessaire.
                        </p>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <p class="text-blue-800 text-sm">
                                💡 <strong>Contact :</strong> Appelez le client si vous ne le trouvez pas à l'adresse.
                            </p>
                        </div>
                    </div>
                    
                    <div class="border-l-4 border-purple-500 pl-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Étape 3 : Confirmation</h3>
                        <p class="text-gray-600 mb-4">
                            Une fois la livraison effectuée, cliquez sur "Marquer comme livré" dans l'application. Cela met à jour le statut de la commande.
                        </p>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <p class="text-purple-800 text-sm">
                                💡 <strong>Important :</strong> Cette action envoie automatiquement une notification au client.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Navigation -->
            <section id="navigation" class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-3xl mr-3">🗺️</span>
                    Navigation et itinéraires
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Planification des tournées</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">🗺️</span>
                                <strong>Voir l'itinéraire :</strong> Cliquez sur "Voir l'itinéraire" pour chaque commande
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">📱</span>
                                <strong>GPS intégré :</strong> L'application utilise votre GPS pour la navigation
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">⏰</span>
                                <strong>Optimisation :</strong> Les itinéraires sont optimisés pour gagner du temps
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Conseils de navigation</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">💡</span>
                                Planifiez vos livraisons par zone géographique
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">💡</span>
                                Privilégiez les livraisons urgentes en premier
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">💡</span>
                                Vérifiez les horaires de livraison préférés des clients
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Section Gestion des problèmes -->
            <section class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-3xl mr-3">⚠️</span>
                    Gestion des problèmes
                </h2>
                
                <div class="space-y-6">
                    <div class="border border-yellow-200 rounded-lg p-6 bg-yellow-50">
                        <h3 class="text-lg font-semibold text-yellow-900 mb-2">Client absent</h3>
                        <p class="text-yellow-800">
                            Si le client n'est pas présent, appelez-le. En cas d'absence prolongée, contactez le support pour organiser une nouvelle livraison.
                        </p>
                    </div>
                    
                    <div class="border border-red-200 rounded-lg p-6 bg-red-50">
                        <h3 class="text-lg font-semibold text-red-900 mb-2">Produit endommagé</h3>
                        <p class="text-red-800">
                            Si un produit est endommagé lors du transport, ne le livrez pas. Contactez immédiatement le support pour organiser un remplacement.
                        </p>
                    </div>
                    
                    <div class="border border-blue-200 rounded-lg p-6 bg-blue-50">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">Adresse incorrecte</h3>
                        <p class="text-blue-800">
                            En cas d'adresse incorrecte, contactez le client pour confirmer l'adresse exacte. Si impossible, retournez au dépôt.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section Statistiques -->
            <section class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-3xl mr-3">📊</span>
                    Vos performances
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-6 bg-green-50 rounded-xl">
                        <div class="text-3xl mb-2">✅</div>
                        <h3 class="font-semibold text-gray-900">Livraisons réussies</h3>
                        <p class="text-gray-600 text-sm">Suivi de vos performances</p>
                    </div>
                    
                    <div class="text-center p-6 bg-blue-50 rounded-xl">
                        <div class="text-3xl mb-2">⏱️</div>
                        <h3 class="font-semibold text-gray-900">Temps moyen</h3>
                        <p class="text-gray-600 text-sm">Efficacité de livraison</p>
                    </div>
                    
                    <div class="text-center p-6 bg-purple-50 rounded-xl">
                        <div class="text-3xl mb-2">⭐</div>
                        <h3 class="font-semibold text-gray-900">Satisfaction client</h3>
                        <p class="text-gray-600 text-sm">Évaluations reçues</p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Bouton retour -->
        <div class="text-center mt-12">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-300 transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour au dashboard
            </a>
        </div>
    </div>
</div>
<x-onboarding-button tourId="help-livreur" position="fixed" />
@endsection 