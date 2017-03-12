@extends('layouts.master')

@section('content')

<div class="container" style="margin-top:3%">
	<div class="row clearfix">
		<div class="col-md-6 column">
				<form id= "myform" action="userregister" method="post" class="form-horizontal" role="form">
					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					<div class="form-group">
						 <label for="username" class="col-sm-2 control-label">用户名</label>
						<div class="col-sm-10">
							<input type="text" class="required form-control" name="userName" id="userName" />
						</div>
					</div>
					<div class="form-group">
						 <label for="email" class="col-sm-2 control-label">邮箱</label>
						<div class="col-sm-10">
							<input type="text" class="required form-control" name="email" id="email" />
						</div>
					</div>
					<div class="form-group">
						 <label for="pwd" class="col-sm-2 control-label">密码</label>
						<div class="col-sm-10">
							<input type="password" class="required form-control" name="password" id="password"/>
						</div>
					</div>
					<div class="form-group">
						 <label for="pwd" class="col-sm-2 control-label">确认密码</label>
						<div class="col-sm-10">
							<input type="password" class="required form-control" name="repass" id="repass"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox col-md-6">
								 <label><input name="contract" type="checkbox" />同意“<a href="#">用户协议</a>”</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-3 col-sm-offset-2 col-sm-8 col-xs-offset-2 col-xs-8" style="display: inline-block">
							 <button type="submit" class="btn btn-block btn-default" name="submit">注册</button>
						</div>
					</div>
				</form>
		</div>
		<div class="col-md-6 column">
			<div class="col-sm-offset-2 col-sm-8 col-xs-offset-2 col-xs-8"   style="margin-top:25%">
				<button type="button" class="btn btn-block btn-default" onclick="location.href='login'">登录</button> 
			</div>
		</div>
	</div>
</div>

@stop