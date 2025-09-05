@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-2xl overflow-hidden">
        <!-- En-tête avec dégradé -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    Mes Notifications
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-3 py-2 rounded-lg hover:bg-gray-600 transition duration-300 flex items-center shadow-md text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Retour
                    </a>
                    <span class="ml-3 bg-white/20 text-white text-xs rounded-full px-2 py-1">
                        {{ count($unreadNotifications) + count($readNotifications) }} total
                    </span>
                </h2>
                
                <div class="flex space-x-2">
                    @if(count($unreadNotifications) > 0)
                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors text-sm font-medium flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Tout marquer comme lu
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Navigation par onglets -->
        <div class="bg-white border-b border-gray-200">
            <nav class="flex" aria-label="Tabs">
                <button id="tab-unread" class="px-6 py-4 text-sm font-medium border-b-2 border-blue-500 text-blue-600 bg-blue-50 flex items-center transition-all duration-200 flex-1 justify-center md:justify-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Non lues 
                    @if(count($unreadNotifications) > 0)
                        <span class="ml-2 bg-blue-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ count($unreadNotifications) }}</span>
                    @endif
                </button>
                <button id="tab-read" class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 border-b-2 border-transparent flex items-center transition-all duration-200 flex-1 justify-center md:justify-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Lues 
                    @if(count($readNotifications) > 0)
                        <span class="ml-2 bg-gray-200 text-gray-600 text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ count($readNotifications) }}</span>
                    @endif
                </button>
            </nav>
        </div>

        <!-- Conteneur de la vue séparée -->
        <div class="md:flex">
            <!-- Section des notifications non lues -->
            <div id="unread-content" class="md:w-1/2 md:border-r border-gray-200 max-h-96 md:max-h-[calc(100vh-320px)] overflow-y-auto">
                @if(count($unreadNotifications) > 0)
                    @foreach($unreadNotifications as $notification)
                        <div class="p-4 bg-blue-50 hover:bg-blue-100 transition-colors group border-b border-blue-100">
                            <div class="flex justify-between items-start">
                                <div class="flex-grow pr-4">
                                    <div class="flex items-start mb-1">
                                        <span class="h-2 w-2 bg-blue-500 rounded-full mr-2 animate-pulse mt-2 flex-shrink-0"></span>
                                        <strong class="text-blue-800 text-base">{{ $notification->data['message'] }}</strong>
                                    </div>
                                    <div class="ml-4">
                                        <small class="text-gray-500 flex items-center mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </small>
                                        
                                        @if(isset($notification->data['order_id']))
                                            <a href="{{ route('orders.index') }}" class="inline-block mt-2 px-3 py-1 bg-blue-500 text-white text-xs rounded-lg hover:bg-blue-600 transition-colors flex items-center w-max">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                                Commande #{{ $notification->data['order_id'] }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                
                                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="ml-auto">
                                    @csrf
                                    <button type="submit" class="text-green-500 hover:text-green-600 transition-colors bg-white/50 hover:bg-white/80 p-2 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-12 text-gray-500">
                        <div class="bg-blue-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <p class="text-lg font-semibold">Aucune notification non lue</p>
                        <p class="text-gray-400 mt-1">Vous avez traité toutes vos notifications</p>
                    </div>
                @endif
            </div>

            <!-- Section des notifications lues -->
            <div id="read-content" class="md:w-1/2 hidden md:block max-h-96 md:max-h-[calc(100vh-320px)] overflow-y-auto">
                @if(count($readNotifications) > 0)
                    @foreach($readNotifications as $notification)
                        <div class="p-4 hover:bg-gray-50 transition-colors group border-b border-gray-100">
                            <div class="flex justify-between items-start opacity-75 hover:opacity-100">
                                <div class="flex-grow pr-4">
                                    <div class="flex items-start mb-1">
                                        <span class="h-2 w-2 bg-gray-300 rounded-full mr-2 mt-2 flex-shrink-0"></span>
                                        <div class="text-gray-700 text-base">{{ $notification->data['message'] }}</div>
                                    </div>
                                    <div class="ml-4">
                                        <small class="text-gray-500 flex items-center mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $notification->created_at->diffForHumans() }}
                                            <span class="ml-1 bg-gray-100 text-gray-500 text-xs rounded-full px-2">lue</span>
                                        </small>
                                        
                                        @if(isset($notification->data['order_id']))
                                            <a href="{{ route('orders.index') }}" class="inline-block mt-2 px-3 py-1 bg-gray-200 text-gray-700 text-xs rounded-lg hover:bg-gray-300 transition-colors flex items-center w-max">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                                Commande #{{ $notification->data['order_id'] }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-12 text-gray-500">
                        <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <p class="text-lg font-semibold">Aucune notification lue</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- État vide pour la vue mobile lorsque les deux sections sont vides -->
        @if(count($unreadNotifications) == 0 && count($readNotifications) == 0)
            <div class="text-center py-16 text-gray-500 md:hidden">
                <div class="bg-blue-50 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <p class="text-xl font-semibold">Vous n'avez pas de notifications</p>
                <p class="text-gray-400 mt-2">Vos notifications récentes apparaîtront ici</p>
            </div>
        @endif

        <!-- Pied de page avec options de nettoyage -->
        <div class="border-t border-gray-200 p-4 bg-gray-50 text-center">
            @if(count($unreadNotifications) > 0 || count($readNotifications) > 0)
                <form action="{{ route('notifications.clear') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer toutes vos notifications ? Cette action est irréversible.')">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors text-sm flex items-center mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Vider toutes les notifications
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-3 py-2 rounded-lg hover:bg-gray-600 transition duration-300 flex items-center shadow-md text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Retour
                    </a>
                </form>
            @else
                <a href="{{ route('home') }}" class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-lg transition-colors text-sm flex items-center mx-auto w-max">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Retour à l'accueil
                </a>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationItems = document.querySelectorAll('.group');
        const tabUnread = document.getElementById('tab-unread');
        const tabRead = document.getElementById('tab-read');
        const unreadContent = document.getElementById('unread-content');
        const readContent = document.getElementById('read-content');
        
        // Effets de survol
        notificationItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.classList.add('shadow-sm');
            });
            
            item.addEventListener('mouseleave', function() {
                this.classList.remove('shadow-sm');
            });
        });
        
        // Bascule d'onglets pour la vue mobile
        tabUnread.addEventListener('click', function() {
            // Style d'onglet actif
            tabUnread.classList.add('border-blue-500', 'text-blue-600', 'bg-blue-50');
            tabUnread.classList.remove('text-gray-500', 'border-transparent');
            tabRead.classList.remove('border-blue-500', 'text-blue-600', 'bg-blue-50');
            tabRead.classList.add('text-gray-500', 'border-transparent');
            
            // Afficher/masquer le contenu
            unreadContent.classList.remove('hidden');
            if (window.innerWidth < 768) { // Masquer uniquement sur mobile
                readContent.classList.add('hidden');
            }
        });
        
        tabRead.addEventListener('click', function() {
            // Style d'onglet actif
            tabRead.classList.add('border-blue-500', 'text-blue-600', 'bg-blue-50');
            tabRead.classList.remove('text-gray-500', 'border-transparent');
            tabUnread.classList.remove('border-blue-500', 'text-blue-600', 'bg-blue-50');
            tabUnread.classList.add('text-gray-500', 'border-transparent');
            
            // Afficher/masquer le contenu
            readContent.classList.remove('hidden');
            if (window.innerWidth < 768) { // Masquer uniquement sur mobile
                unreadContent.classList.add('hidden');
            }
        });
        
        // Comportement adaptatif
        function handleResponsiveLayout() {
            if (window.innerWidth >= 768) {
                // Sur bureau, toujours afficher les deux sections
                unreadContent.classList.remove('hidden');
                readContent.classList.remove('hidden');
            } else {
                // Sur mobile, afficher uniquement le contenu de l'onglet actif
                if (tabUnread.classList.contains('text-blue-600')) {
                    unreadContent.classList.remove('hidden');
                    readContent.classList.add('hidden');
                } else {
                    readContent.classList.remove('hidden');
                    unreadContent.classList.add('hidden');
                }
            }
        }
        
        // Appliquer le comportement adaptatif au chargement
        handleResponsiveLayout();
        
        // Surveiller les changements de taille d'écran
        window.addEventListener('resize', handleResponsiveLayout);
        
        // Animation des nouvelles notifications
        const pulseElements = document.querySelectorAll('.animate-pulse');
        pulseElements.forEach(el => {
            setTimeout(() => {
                el.classList.add('scale-110');
                setTimeout(() => el.classList.remove('scale-110'), 300);
            }, Math.random() * 3000);
        });
    });
</script>
@endpush