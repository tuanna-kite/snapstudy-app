<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <!-- Material-UI Icons CSS via CDN -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Include Alpine.js via CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php echo $__env->yieldPushContent('scripts_top'); ?>
</head>

<body>
    <?php echo $__env->yieldContent('content'); ?>

    
    <?php echo $__env->yieldPushContent('scripts_bottom'); ?>
</body>

</html>
<?php /**PATH /Users/lequanganh/workspace/php-space/snapstudy-app/resources/views/web_v2/layouts/index.blade.php ENDPATH**/ ?>