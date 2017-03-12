<?php $__env->startSection('content'); ?>

	<div class="container" style="margin-top:3%">
		<div class="row clearfix">
			<div class="col-md-6 column">
				<img alt="140x140" src="v3/default3.jpg" />
			</div>
			<div class="col-md-6 column">
				<form id= "myform" action="workorderindex" method="POST" class="form-horizontal" role="form">
					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					<div class="form-group">
						 <label for="user" class="col-sm-2 control-label">用户名</label>
						<div class="col-sm-10">
							<input type="text" class="input required form-control" name="userName" id="userName"/>
						</div>
					</div>
					<div class="form-group">
						 <label for="password" class="col-sm-2 control-label">密码</label>
						<div class="col-sm-10">
							<input type="password" class="required form-control" name="password" id="password"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox col-md-6">
								 <label><input name="remember" type="checkbox"/>下回自动登录</label>
							</div>
							<div class="col-md-6" style="padding-top: 7px">
								<a href="./resetPassword.php">忘记密码？</a>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-4 col-xs-offset-2 col-xs-4" style="display: inline-block">
							 <button type="submit" class="btn btn-default" name="login">登录</button>
						</div>
						<div class="col-sm-offset-2 col-sm-4 col-xs-offset-2 col-xs-4">
							 <button type="button" class="btn btn-default" onclick="location.href='register'">注册</button> 
						</div>
					</div>
				</form>
				
				<?php if(count($errors)): ?>
					<ul>
						<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
							<li><?php echo e($error); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
					</ul>
				<?php endif; ?>

			</div>
		</div>
	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>