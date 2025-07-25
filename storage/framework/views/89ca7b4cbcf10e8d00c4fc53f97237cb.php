

<?php $__env->startSection('content'); ?>
<div class="bg-gray-100 min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Colonne de gauche: Carte de profil principal -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden md:w-1/2 profile-info">
                <!-- Header avec titre -->
                <div class="bg-gray-800 text-white p-4 flex items-center justify-between">
                    <h1 class="text-xl font-medium">Profil Utilisateur</h1>
                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="px-3 py-1 border border-gray-400 rounded-md text-sm">Déconnexion</button>
                    </form>
                </div>

                <div class="flex flex-col">
                    <!-- Panneau avec avatar -->
                    <div class="w-full bg-gray-50 p-8 border-b border-gray-200">
                        <div class="flex flex-col items-center">
                            <div class="h-40 w-40 rounded-full bg-gray-300 border-4 border-white shadow-lg overflow-hidden mb-4">
                                <img src="<?php echo e(asset('images/default-avatar.png')); ?>" alt="Avatar" class="h-full w-full object-cover">
                            </div>
                            <h2 class="text-3xl font-bold text-gray-800 mt-2"><?php echo e(Auth::user()->name); ?></h2>
                        </div>
                    </div>

                    <!-- Panneau avec formulaire -->
                    <div class="w-full p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Modifier le Profil</h2>

                        <!-- Message de statut -->
                        <?php if(session('success')): ?>
                            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php elseif(session('error')): ?>
                            <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg">
                                <?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('profile.update')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>

                            <div class="space-y-6">
                                <!-- Champ pour le nom -->
                                <div class="relative">
                                    <label for="name" class="text-gray-600 text-sm">Nom</label>
                                    <input type="text" name="name" id="name" class="w-full bg-gray-100 rounded-lg px-4 py-2" value="<?php echo e(Auth::user()->name); ?>" required>
                                </div>

                                <!-- Champ pour l'email -->
                                <div class="relative">
                                    <label for="email" class="text-gray-600 text-sm">Email</label>
                                    <input type="email" name="email" id="email" class="w-full bg-gray-100 rounded-lg px-4 py-2" value="<?php echo e(Auth::user()->email); ?>" readonly>
                                </div>

                                <!-- Section mot de passe -->
                                <button type="button" id="togglePasswordFields" class="w-full bg-gray-200 text-gray-800 py-2 px-4 rounded-lg font-semibold">
                                    Changer le mot de passe
                                </button>

                                <div id="passwordFields" class="hidden space-y-4">
                                    <!-- Champ pour le mot de passe actuel -->
                                    <div class="relative">
                                        <label for="current_password" class="text-gray-600 text-sm">Mot de passe actuel</label>
                                        <input type="password" name="current_password" id="current_password" class="w-full bg-gray-100 rounded-lg px-4 py-2">
                                    </div>

                                    <!-- Champ pour le nouveau mot de passe -->
                                    <div class="relative">
                                        <label for="new_password" class="text-gray-600 text-sm">Nouveau mot de passe</label>
                                        <input type="password" name="new_password" id="new_password" class="w-full bg-gray-100 rounded-lg px-4 py-2">
                                    </div>

                                    <!-- Champ pour confirmer le mot de passe -->
                                    <div class="relative">
                                        <label for="new_password_confirmation" class="text-gray-600 text-sm">Confirmer le mot de passe</label>
                                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="w-full bg-gray-100 rounded-lg px-4 py-2">
                                    </div>
                                </div>

                                <!-- Boutons de soumission -->
                                <div class="flex space-x-4 mt-6">
                                    <button type="submit" class="bg-gray-800 text-white py-2 px-5 rounded-lg font-medium hover:bg-gray-700 transition">
                                        Enregistrer
                                    </button>
                                    <button type="reset" class="bg-white text-gray-800 py-2 px-5 rounded-lg font-medium border border-gray-300 hover:bg-gray-50 transition">
                                        Réinitialiser
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Colonne de droite: Section Notifications -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden md:w-1/2 recent-orders">
                <div class="bg-gray-800 text-white p-4">
                    <h1 class="text-xl font-medium">Mes Notifications</h1>
                </div>
                <div class="p-6">
                    <?php if(Auth::user()->notifications->count() > 0): ?>
                        <div class="flex justify-end mb-4">
                            <form action="<?php echo e(route('notifications.markAllAsRead')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 transition-colors">
                                    Marquer toutes comme lues
                                </button>
                            </form>
                        </div>

                        <div class="max-h-[650px] overflow-y-auto pr-2">
                            <ul class="space-y-4">
                                <?php $__currentLoopData = Auth::user()->notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="bg-gray-50 border-l-4 border-indigo-600 p-4 rounded-lg shadow">
                                        <p class="text-gray-800"><?php echo e($notification->data['message']); ?></p>
                                        <small class="text-gray-500 block mt-1">Reçue <?php echo e($notification->created_at->diffForHumans()); ?></small>
                                        <?php if($notification->read_at === null): ?>
                                            <form action="<?php echo e(route('notifications.markAsRead', $notification->id)); ?>" method="POST" class="mt-2">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="text-sm text-indigo-600 hover:underline">Marquer comme lue</button>
                                            </form>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-600">Aucune notification pour le moment.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Fonction pour afficher/masquer les champs du mot de passe
    document.getElementById('togglePasswordFields').addEventListener('click', function() {
        document.getElementById('passwordFields').classList.toggle('hidden');
    });
</script>
<?php if (isset($component)) { $__componentOriginal8d5f9f712ad68735ee0009ff5065f869 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8d5f9f712ad68735ee0009ff5065f869 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.onboarding-button','data' => ['tourId' => 'user-dashboard','position' => 'fixed']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('onboarding-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tourId' => 'user-dashboard','position' => 'fixed']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8d5f9f712ad68735ee0009ff5065f869)): ?>
<?php $attributes = $__attributesOriginal8d5f9f712ad68735ee0009ff5065f869; ?>
<?php unset($__attributesOriginal8d5f9f712ad68735ee0009ff5065f869); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8d5f9f712ad68735ee0009ff5065f869)): ?>
<?php $component = $__componentOriginal8d5f9f712ad68735ee0009ff5065f869; ?>
<?php unset($__componentOriginal8d5f9f712ad68735ee0009ff5065f869); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
window.tourSteps_ = [
  {
    id: 'step-1',
    title: 'Bienvenue sur votre espace',
    text: 'Retrouvez ici toutes vos <b>informations personnelles</b> et l'accès à vos commandes.',
    attachTo: { element: 'h1, .dashboard-title', on: 'bottom' },
    buttons: [ { text: 'Suivant', action: function() { tour.next(); } } ]
  },
  {
    id: 'step-2',
    title: 'Mes commandes',
    text: 'Consultez l'historique de vos <b>commandes</b> et suivez leur statut ici.',
    attachTo: { element: 'a[href*=commandes], .orders-link', on: 'bottom' },
    buttons: [ { text: 'Terminer', action: function() { tour.complete(); } } ]
  }
];
window.showOnboardingTour = function(tourId, steps) {
  const tour = window.createCustomTour(steps);
  window.tour = tour;
  tour.start();
};
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Projets\mon-site-cosmetique\mon-site-cosmetique\resources\views/user/dashboard.blade.php ENDPATH**/ ?>