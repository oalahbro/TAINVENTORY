<?php $__currentLoopData = $post; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<h2><?php echo e($p['nama']); ?></h2>
<p><?php echo e($p['deskripsi']); ?></p>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /home/eclipse/Documents/PROJ/demo/application/views/blade/index.blade.php ENDPATH**/ ?>