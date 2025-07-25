@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Paramètres</h1>
            <p class="mt-2 text-sm text-gray-600">Gérez vos préférences et configurations</p>
        </div>

        <!-- Navigation des paramètres -->
        <div class="bg-white rounded-2xl shadow-xl mb-8">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button class="px-6 py-4 text-sm font-medium text-blue-600 border-b-2 border-blue-600">
                        Général
                    </button>
                    <button class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent">
                        Notifications
                    </button>
                    <button class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent">
                        Sécurité
                    </button>
                    <button class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent">
                        Véhicule
                    </button>
                </nav>
            </div>
        </div>

        <!-- Contenu des paramètres -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Paramètres principaux -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Section Général -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Paramètres généraux</h2>
                    <div class="space-y-6">
                        <!-- Langue -->
                        <div>
                            <label for="language" class="block text-sm font-medium text-gray-700">Langue</label>
                            <select id="language" name="language" class="mt-1 form-select block w-full">
                                <option value="fr">Français</option>
                                <option value="en">English</option>
                                <option value="ar">العربية</option>
                            </select>
                        </div>

                        <!-- Fuseau horaire -->
                        <div>
                            <label for="timezone" class="block text-sm font-medium text-gray-700">Fuseau horaire</label>
                            <select id="timezone" name="timezone" class="mt-1 form-select block w-full">
                                <option value="UTC">UTC (00:00)</option>
                                <option value="Africa/Dakar" selected>Dakar (UTC+00:00)</option>
                            </select>
                        </div>

                        <!-- Format de date -->
                        <div>
                            <label for="date_format" class="block text-sm font-medium text-gray-700">Format de date</label>
                            <select id="date_format" name="date_format" class="mt-1 form-select block w-full">
                                <option value="DD/MM/YYYY">31/12/2023</option>
                                <option value="MM/DD/YYYY">12/31/2023</option>
                                <option value="YYYY-MM-DD">2023-12-31</option>
                            </select>
                        </div>

                        <!-- Devise -->
                        <div>
                            <label for="currency" class="block text-sm font-medium text-gray-700">Devise</label>
                            <select id="currency" name="currency" class="mt-1 form-select block w-full">
                                <option value="XOF">Franc CFA (XOF)</option>
                                <option value="EUR">Euro (EUR)</option>
                                <option value="USD">Dollar US (USD)</option>
                            </select>
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="btn btn-primary w-full">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Section Notifications -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Préférences de notification</h2>
                    <div class="space-y-4">
                        <label class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Notifications par email</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </label>

                        <label class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Notifications push</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </label>

                        <label class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">SMS</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </label>

                        <div class="border-t border-gray-100 pt-4 mt-6">
                            <h3 class="text-sm font-medium text-gray-900 mb-4">Types de notifications</h3>
                            <div class="space-y-4">
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" class="form-checkbox text-blue-600 rounded" checked>
                                    <span class="text-sm text-gray-700">Nouvelles commandes</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" class="form-checkbox text-blue-600 rounded" checked>
                                    <span class="text-sm text-gray-700">Modifications de commandes</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" class="form-checkbox text-blue-600 rounded" checked>
                                    <span class="text-sm text-gray-700">Rappels de livraison</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" class="form-checkbox text-blue-600 rounded">
                                    <span class="text-sm text-gray-700">Promotions et actualités</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Aide et support -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Aide et support</h2>
                    <div class="space-y-4">
                        <a href="#" class="flex items-center space-x-3 text-gray-700 hover:text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm">Centre d'aide</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 text-gray-700 hover:text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm">Contacter le support</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 text-gray-700 hover:text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="text-sm">Documentation</span>
                        </a>
                    </div>
                </div>

                <!-- Version de l'application -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">À propos</h2>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600">Version de l'application</p>
                            <p class="text-sm font-medium text-gray-900">2.0.1</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Dernière mise à jour</p>
                            <p class="text-sm font-medium text-gray-900">15 novembre 2023</p>
                        </div>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700">Notes de version</a>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h2 class="text-xl font-semibold text-red-600 mb-6">Zone de danger</h2>
                    <div class="space-y-4">
                        <button class="btn btn-danger w-full">
                            Désactiver mon compte
                        </button>
                        <p class="text-xs text-gray-500">
                            Cette action est réversible. Votre compte sera désactivé temporairement.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 