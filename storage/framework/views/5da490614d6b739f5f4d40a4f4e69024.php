<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['tourId', 'position' => 'fixed', 'class' => '']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['tourId', 'position' => 'fixed', 'class' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<button 
    onclick="startTour('<?php echo e($tourId); ?>')" 
    class="onboarding-button <?php echo e($position === 'fixed' ? 'fixed bottom-4 right-4' : ''); ?> z-30 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-4 py-2 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 <?php echo e($class); ?>"
    title="Relancer le tutoriel"
>
    <div class="flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="text-sm font-medium">Aide</span>
    </div>
</button>

<style>
.onboarding-button {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.7);
    }
    50% {
        box-shadow: 0 0 0 10px rgba(99, 102, 241, 0);
    }
}

.onboarding-button:hover {
    animation: none;
}
</style>

<script>
window.startTour = function(tourId) {
    // Vérifie si une modale existe déjà
    if (document.getElementById('onboarding-modal-choice')) {
        document.getElementById('onboarding-modal-choice').classList.remove('hidden');
        return;
    }
    // Crée la modale de choix
    const modal = document.createElement('div');
    modal.id = 'onboarding-modal-choice';
    modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/40';
    modal.innerHTML = `
        <div class='bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 relative animate-fade-in'>
            <button id='close-onboarding-choice' class='absolute top-3 right-3 text-gray-400 hover:text-pink-500 text-xl focus:outline-none'>&times;</button>
            <h3 class='text-xl font-bold mb-4 text-pink-600'>Voulez-vous suivre le tutoriel interactif ?</h3>
            <div class='flex justify-center gap-4 mt-6'>
                <button id='onboarding-yes' class='px-6 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-xl font-semibold hover:from-pink-600 hover:to-purple-700 transition-all duration-300'>Oui</button>
                <button id='onboarding-no' class='px-6 py-2 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition-all duration-300'>Non</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
    // Fermeture
    document.getElementById('close-onboarding-choice').onclick = closeModal;
    document.getElementById('onboarding-no').onclick = closeModal;
    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
    // Lancer le tour si Oui
    document.getElementById('onboarding-yes').onclick = function() {
        closeModal();
        if (typeof window["startOnboardingTour"] === "function") {
            window["startOnboardingTour"](tourId);
        } else if (typeof window["startTour_" + tourId] === "function") {
            window["startTour_" + tourId]();
        } else if (window.tourSteps_ && typeof window.showOnboardingTour === 'function') {
            window.showOnboardingTour(tourId, window.tourSteps_);
        } else if (window.tourSteps_ && window.TourLibrary) {
            window.TourLibrary.start(window.tourSteps_);
        } else {
            alert('Le tutoriel n\'est pas disponible sur cette page.');
        }
    };
}
</script> <?php /**PATH C:\Projets\mon-site-cosmetique\mon-site-cosmetique\resources\views/components/onboarding-button.blade.php ENDPATH**/ ?>