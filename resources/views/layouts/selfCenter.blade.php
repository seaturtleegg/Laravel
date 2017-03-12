

<div class="col-md-2 column">
	<h3 class="text-center">个人中心</h3>
	<div class="btn-group btn-group-vertical btn-group-md col-md-12">
	@if (Session::has('userRoles'))
		@foreach(Session::get('userRoles') as $userRole)
			@if($userRole->RoleId=="1")
				<button class="btn btn-block btn-default" type="button" onclick="document.location.href='./workorder'">一键下单</button> 
			@endif
		@endforeach
				<button class="btn btn-block btn-default" type="button" onclick="document.location.href='./womanagement'">订单管理</button> 
		@foreach(Session::get('userRoles') as $userRole)
			@if($userRole->RoleId=="1")
				<button class="btn btn-block btn-default" type="button" onclick="document.location.href='./addressmanagement'">地址管理</button> 
			@endif
		@endforeach
				<button class="btn btn-block btn-default" type="button">账户设置</button>
				<button class="btn btn-block btn-default" type="button">密码管理</button>
	@endif	
	</div>
</div>