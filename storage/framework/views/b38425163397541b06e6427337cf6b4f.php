<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-white flex items-center justify-center py-12">
    <div class="max-w-md w-full space-y-8">
        
        <!-- Header - Style Nike -->
        <div class="text-center">
            <div class="w-20 h-20 bg-black rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-user text-white text-xl"></i>
            </div>
            <h2 class="nike-heading mb-4">CONNEXION</h2>
            <p class="nike-text text-gray-600">Accédez à votre espace personnel</p>
                        </div>

        <!-- Formulaire de connexion -->
        <div class="card-nike">
                    <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6">
                        <?php echo csrf_field(); ?>

                <!-- Email -->
                <div>
                    <label for="email" class="label-nike mb-2">Adresse email</label>
                    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                           class="input-nike <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="votre@email.com">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="label-nike mb-2">Mot de passe</label>
                    <input id="password" type="password" name="password" required
                           class="input-nike <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="Votre mot de passe">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                <!-- Options -->
                        <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" 
                               class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black">
                        <label for="remember_me" class="ml-2 text-sm text-gray-700">
                            Se souvenir de moi
                            </label>
                    </div>

                    <?php if(Route::has('password.request')): ?>
                        <a href="<?php echo e(route('password.request')); ?>" class="text-sm text-gray-600 hover:text-black transition-colors">
                                    Mot de passe oublié ?
                                </a>
                            <?php endif; ?>
                        </div>

                <!-- Bouton de connexion -->
                <div>
                    <button type="submit" class="btn-nike w-full">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        SE CONNECTER
                        </button>
                </div>

                <!-- Séparateur -->
                <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Ou</span>
                            </div>
                        </div>

                <!-- Connexion avec Google -->
                <div>
                    <a href="<?php echo e(route('google.login')); ?>" class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fab fa-google mr-3 text-red-500"></i>
                        Continuer avec Google
                    </a>
                </div>
                
                <!-- Lien d'inscription -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                            Pas encore de compte ?
                        <a href="<?php echo e(route('register')); ?>" class="font-medium text-black hover:text-gray-700 transition-colors">
                            Créer un compte
                            </a>
                        </p>
                </div>
            </form>
            </div>
        
        <!-- Informations supplémentaires -->
        <div class="text-center">
            <p class="text-xs text-gray-500">
                En vous connectant, vous acceptez nos 
                <a href="#" class="text-black hover:text-gray-700 transition-colors">conditions d'utilisation</a>
                et notre 
                <a href="#" class="text-black hover:text-gray-700 transition-colors">politique de confidentialité</a>
            </p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Projets\mon-site-cosmetique\mon-site-cosmetique\resources\views/auth/login.blade.php ENDPATH**/ ?>