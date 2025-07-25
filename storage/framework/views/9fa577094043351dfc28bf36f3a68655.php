<?php $__env->startComponent('mail::message'); ?>
# Code de réinitialisation

Bonjour,

Voici votre code de réinitialisation de mot de passe :

<?php $__env->startComponent('mail::panel'); ?>
# <?php echo e($code); ?>

<?php echo $__env->renderComponent(); ?>

Ce code est valable 5 minutes.

Si vous n'êtes pas à l'origine de cette demande, ignorez cet email.

Merci,<br>L'équipe <?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Projets\mon-site-cosmetique\mon-site-cosmetique\resources\views/emails/password/reset_code.blade.php ENDPATH**/ ?>