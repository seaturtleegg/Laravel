

<div class="col-md-2 column">
	<h3 class="text-center">个人中心</h3>
	<div class="btn-group btn-group-vertical btn-group-md col-md-12">
	<?php if(Session::has('userRoles')): ?>
		<?php $__currentLoopData = Session::get('userRoles'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userRole): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
			<?php if($userRole->RoleId=="1"): ?>
				<button class="btn btn-block btn-default" type="button" onclick="document.location.href='./workorder'">一键下单</button> 
			<?php endif; ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
				<button class="btn btn-block btn-default" type="button" onclick="document.location.href='./womanagement'">订单管理</button> 
		<?php $__currentLoopData = Session::get('userRoles'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userRole): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
			<?php if($userRole->RoleId=="1"): ?>
				<button class="btn btn-block btn-default" type="button" onclick="document.location.href='./addressmanagement'">地址管理</button> 
			<?php endif; ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
				<button class="btn btn-block btn-default" type="button">账户设置</button>
				<button class="btn btn-block btn-default" type="button">密码管理</button>
	<?php endif; ?>	
	</div>
</div>