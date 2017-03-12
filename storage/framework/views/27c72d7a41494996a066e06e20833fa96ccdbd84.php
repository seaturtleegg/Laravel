<?php $__env->startSection('content'); ?>


<div class="container">
	<div class="row clearfix">
	<?php echo $__env->make('layouts.selfCenter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


<?php if(Session::has('userId')): ?>
	<?php echo e(Session::get('userId')); ?>

<?php endif; ?>

	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>