@extends('layouts.master')

@section('content')

<div id = '1grad1'> 
<div class="container" style="margin-top:3%">
	<div class="row clearfix">
		<div class="col-md-4 column">
			<form action="index.php?act=go" method="post" class="form-horizontal" role="form">
				<div class="form-group">
					 <label for="wo" class="col-sm-12">订单查询</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="wo" />
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-12 col-xs-12" style="display: inline-block">
						 <button type="submit" class="btn btn-default btn-block" name="login">查询</button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-8 column">
			<div class="carousel slide" id="carousel-8836">
				<ol class="carousel-indicators">
					<li class="active" data-slide-to="0" data-target="#carousel-8836">
					</li>
					<li data-slide-to="1" data-target="#carousel-8836">
					</li>
					<li data-slide-to="2" data-target="#carousel-8836">
					</li>
				</ol>
				<div class="carousel-inner">
					<div class="item active">
						<img alt="" src="./public/images/default.jpg" />
						<div class="carousel-caption">
							<h4>
								标题1
							</h4>
							<p>
								内容1
							</p>
						</div>
					</div>
					<div class="item">
						<img alt="" src="./public/images/default1.jpg" />
						<div class="carousel-caption">
							<h4>
								标题2
							</h4>
							<p>
								内容2
							</p>
						</div>
					</div>
					<div class="item">
						<img alt="" src="./public/images/default2.jpg" />
						<div class="carousel-caption">
							<h4>
								标题3
							</h4>
							<p>
								内容3
							</p>
						</div>
					</div>
				</div> <a class="left carousel-control" href="#carousel-8836" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#carousel-8836" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
			</div>
		</div>
	</div>
	<!--<div class="row clearfix" style="margin-top: 5%">
		<div class="col-md-12 column">
			<p class="text-center breadcrumb">
				 <strong>站点咨询</strong><br>
			</p>
		</div>
	</div>-->
</div>
</div>
@stop