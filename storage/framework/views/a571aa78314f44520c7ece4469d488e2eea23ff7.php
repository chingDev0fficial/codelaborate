<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?php echo e($name); ?></h1>
    <img src="<?php echo e(asset('storage/' . $profile_picture)); ?>" alt="Profile" style="height: 100px; width:100px;">
    <form action="<?php echo e(route('logout')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn">
            Logout
        </button>
    </form>
</body>
</html><?php /**PATH C:\xampp\htdocs\dashboard\codelaborate\resources\views/home.blade.php ENDPATH**/ ?>