<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link href="./public/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery.js"></script>
	<script src="./public/js/bootstrap.min.js"></script>
	<title>Document</title>
	<?php echo $__env->yieldContent('header'); ?>
</head>
	
<body>

  
<div class="container" style="padding-top: 15px">
	<div class="row clearfix">
		<div class="col-md-3 column">
			<img alt="140x140" src="./images/default.jpg" class="img-rounded" width="100%;" height="50px"/>
		</div>
		<div class="col-md-6 column">
			<ul class="breadcrumb" style="font-size: 19px">
				<li class="active">
					 <a href="#">业务介绍</a>
				</li>
				<li>
					 <a href="#">邮寄流程</a>
				</li>
				<li>
					 <a href="#">邮费报价</a>
				</li>
				<li>
					 <a href="#">优惠信息</a>
				</li>
				<li>
					 <a href="#">联系我们</a>
				</li>
			</ul>
		</div>
		<div class="col-md-3 column">
			 <button type="button" class="btn btn-lg btn-block btn-warning" onClick="document.location.href='./login.php'">登录/注册</button>
		</div>
	</div>
</div>

	<?php echo $__env->yieldContent('content'); ?>
	
	<?php echo $__env->yieldContent('footer'); ?>
</body>
</html>