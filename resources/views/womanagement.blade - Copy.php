@extends('layouts.master')

@section('content')



<div class="container">
	<div class="row clearfix">
		
		@include('layouts.selfCenter')
		<div class="col-md-10 column" style="margin-top: 3%">
			<div class="container">
				<div class="col-md-12 column">
				<h3>我的订单</h3>
					<form id="myform" name="form" method="post" class="form-horizontal" role="form" action="searchWO">
						<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
						<div class="form-group col-md-7">
							<p for="text" class="col-md-2 control-label">选择条件</p>
								<div class="col-md-4">
									<select class="form-control" name="filter" id="filter"> 
									<option value="0"></option>
									<option value="1">订单号</option>
									<option value="2">收件人</option>
									<option value="3">收件城市</option>
									</select> 
								</div>
								<div class="col-md-6">
									<input type="text" class=" form-control" id="filter1" name="filter1" />
								</div>
						</div>
						<div class="form-group col-md-5">
							<p for="text" class="col-md-6 control-label">订单状态</p>
							<div class="col-md-6">
									<select class="form-control" name="status" id="status"> 
									<option value="0"></option>
									<@foreach ($woStatus as $status)
									{{$status->Name}}
									<option value="{{$status->Id}}" data-id="{{$status->Id}}">{{$status->Name}}</option> 
									@endforeach
									</select> 
							</div>
						</div>
						<div class="form-group col-md-7">
							<p for="text" class="col-sm-2 control-label">下单时间</p>
								<div class="col-sm-4">
									<input type='date'
											id='startTime'
											name='startTime'
											value='2016-12-15'
											class='toedit'/>
									<!--<input type="text" class=" form-control" id="startTime" name="startTime" />-->
								</div>
								<p class="col-md-1"> - </p>
								<div class="col-sm-4">
									<input type='date'
											id='endTime'
											name='endTime'
											value='<?php echo date('Y-m-d'); ?>'
											class='toedit'/>
								</div>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-default col-md-1" name="search" id="search">搜索</button>
						</div>
					</form>
				</div>
				
				<div class="container">
					<div class="col-md-12 column">
					<form id="myform2" name="form" method="post" class="form-horizontal" role="form" action="editwo">
							<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
								<button type="button" class="btn btn-default col-md-1" onclick="isEditable()">快速编辑</button>
							
							
								<input type="submit" class="btn btn-default col-md-1" name="quickUpdate" id="quickUpdate" value="提交编辑"></button>
							
							
								<button type="submit" class="btn btn-default col-md-1" name="deleteWO" id="deleteWO">删除订单</button>
							
							
								<input type="submit" class="btn btn-default col-md-1" name="mergeWO" id="mergeWO" value="合单"></button>

								
								

								
							
							<table class="table" id ="workOrderInfo">
								<thead>
									<tr>
										<th>
											<input type="checkbox" class="checkboxAll"/>
										</th>
										<th>
											订单号
										</th>
										<th>
											收件人
										</th>
										<th>
											收件城市
										</th>
										<th>
											货物类型
										</th>
										<th>
											重量
										</th>
										<th>
											价格
										</th>
										<th>
											国际单号
										</th>
										<th>
											订单状态
										</th>
										<th>
											更新日期
										</th>
									</tr>
								</thead>
								<tbody>
									
									<?php $count = 0;
										foreach($woInfo as $workOrder){
										?>
										<tr>
											<td>
												<input id="checked<?php echo $count;?>" name="checked<?php echo $count;?>" type="checkbox" class="checkboxList" value="<?php echo $workOrder->Id; ?>"/>
											</td>
											<td>
												<a id="detail<?php echo $count;?>" data-toggle="modal" data-target="#myModal<?php echo $workOrder->Id; ?>">
												<?php echo $workOrder->WONum ?></a>
											</td>
											<td>
												<?php echo $workOrder->ReceiverName//receiver ?>
											</td>
											<td>
												<?php echo $workOrder->CityName//city ?>
											</td>
											<td>
												<?php echo $workOrder->WOCategoryName//wotype ?>
											</td>
											<td>
												<input id="weight<?php echo $count;?>" name="weight<?php echo $count;?>" type="text" value="<?php echo $workOrder->Weight;?>" style="width:40px; border:none" readonly>
											</td>
											<td>
												<?php echo $workOrder->Price//price ?>
											</td>
											<td>
												<input id="trackingNum<?php echo $count;?>" name="trackingNum<?php echo $count;?>" type="text" value="<?php echo $workOrder->Weight;?>" style="width:40px; border:none" readonly>
											</td>
											<td>
					
								
									<select class="form-control" name="status<?php echo $count;?>" id="status<?php echo $count;?>" disabled> 
									<option id="selectedStatus<?php echo $count;?>" selected="seleted<?php echo $count;?>"  value="{{$workOrder->StatusId}}">{{$workOrder->StatusName}}</option>
									<option value="0"></option>
									<@foreach ($woStatus as $status)
									{{$status->Name}}
									<option value="{{$status->Id}}" data-id="{{$status->Id}}">{{$status->Name}}</option> 
									@endforeach
									</select> 
							
											</td>
											<td>
												<?php echo $workOrder->ModifyDate//modifydate ?>
											</td>
										</tr>
										<?php $count++;} ?>
										
									
									
									<?php 
									foreach($mergedWOInfo as $mergedWO){
										?>
										<tr data-toggle="collapse" href="#panel-element<?php echo $mergedWO->Id;?>">
											<td>
												<input id="checked2<?php echo $count;?>" name="checked[]" type="checkbox" class="checkboxList" value="<?php echo $mergedWO->Id; ?>"/>
											</td>
											<td>
												<a>(合单)<?php echo $mergedWO->BatchNumber ?></a>
											</td>
											<td>
												<?php echo $mergedWO->Id//receiver ?>
											</td>
											<td>
												<?php echo $mergedWO->Id//city ?>
											</td>
											<td>
												<?php echo $mergedWO->Id//wotype ?>
											</td>
											<td>
												<input id="weight2<?php echo $count;?>" name="weight2<?php echo $count;?>" type="text" value="<?php echo $mergedWO->Id;?>" style="width:40px; border:none" readonly>
											</td>
											<td>
												<?php echo $mergedWO->Id//price ?>
											</td>
											<td>
												<?php //echo $workOrder[4]//trackingNum ?>
											</td>
											<td>
												<?php echo $mergedWO->Id//status ?>
											</td>
											<td>
												<?php echo $mergedWO->Id//modifydate ?>
											</td>
										</tr>
									<tr class="collapse" id="panel-element<?php echo $mergedWO->Id;?>">
									
									<?php foreach($collection -> get($mergedWO->Id) as $temp) {?>
									
												<td>
													<!--<input id="checked<?php echo $count;?>" name="checked[]" type="checkbox" class="checkboxList" value="<?php echo $temp->Id; ?>"/>-->
												</td>
												<td>
													<a id="detail<?php echo $count;?>" data-toggle="modal" data-target="#myModal<?php echo $count; ?>">
													<?php echo $temp->WONum ?></a>
												</td>
												<td>
													<?php echo $temp->Id//receiver ?>
												</td>
												<td>
													<?php echo $temp->Id//city ?>
												</td>
												<td>
													<?php echo $temp->Id//wotype ?>
												</td>
												<td>
													<input id="weight<?php echo $count;?>" name="weight<?php echo $count;?>" type="text" value="<?php echo $temp->Id;?>" style="width:40px; border:none" readonly>
												</td>
												<td>
													<?php echo $temp->Id//price ?>
												</td>
												<td>
													<?php //echo $workOrder[4]//trackingNum ?>
												</td>
												<td>
													<?php echo $temp->Id//status ?>
												</td>
												<td>
													<?php echo $temp->Id//modifydate ?>
												</td>		
								
								<?php } ?>
								
								
								</tr>
								<?php $count++;} ?>
								
								<input id="WOCount" name="WOCount" type="hidden" value="<?php echo $count;?>">
								</tbody>
							</table>
							</form>
						</div>
					</div>
				
			</div>
		</div>
	</div>
</div>


 <!-- Modal -->
 		<form id="myform" name="form" method="post" class="form-horizontal" role="form" action='editwo'>
 <?php $index = 0; foreach($woInfo as $workOrder) { ?>
  <div class="modal fade col-md-8 col-md-offset-2" style="margin-top:5%" id="myModal<?php echo $workOrder->Id; ?>" role="dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">订单详情</h4>
        </div>
		
        <div class="modal-body col-md-12">

			<div class="col-md-12">
				<button type="button" class="btn btn-default col-md-1" onclick="editWO()">编辑订单</button>
			</div>
			<div class="col-md-8 column">
				<h4><label>国内订单详情</label></h4>
				
							<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
							<div class="form-group">
								 <p for="text" class="col-sm-4 control-label">国内物流运单号<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="wonum<?php echo $index;?>" name="wonum<?php echo $index;?>" disabled />
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">货物类型</p>
								<div class="col-sm-8">
									<select class="form-control" name="woCategory" id="woCategory<?php echo $index;?>" value="{{$workOrder->WOCategoryId}}" disabled> 
									<option id="selectedWOCategory<?php echo $index;?>" selected="seleted"  value="{{$workOrder->WOCategoryId}}">{{$workOrder->WOCategoryName}}</option>
									<option value="0"></option>
									@foreach ($woCategories as $woCategory)
									{{$woCategory->Name}}
									<option value="{{$woCategory->Id}}" data-id="{{$woCategory->Id}}">{{$woCategory->Name}}</option> 
									@endforeach
									</select> 
								</div>
							</div>
							<div class="form-group">
								 <p for="text" class="col-sm-4 control-label">下单日期</p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" value="{{$workOrder->CreateDate}}" disabled />
								</div>
							</div>
							<div class="form-group">
								 <p for="text" class="col-sm-4 control-label">入库时间</p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" value="{{$workOrder->CreateDate}}" disabled />
								</div>
							</div>
							<div class="form-group">
								 <p for="text" class="col-sm-4 control-label">货品重量</p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="weight<?php echo $index;?>" name="weight" value="{{$workOrder->Weight}}" disabled />
								</div>
							</div>

						<h4><label>寄件人信息</label></h4>
	 
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">寄件人姓名<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="senderName<?php echo $index;?>" name="senderName" value="{{$workOrder->SenderName}}" disabled />
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">寄件人电话<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="senderPhone<?php echo $index;?>" name="senderPhone" value="{{$workOrder->SenderPhoneNumber}}" disabled />
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">寄件人地址<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="senderAddress<?php echo $index;?>" name="senderAddress" value="{{$workOrder->SenderAddress}}" disabled />
								</div>
							</div>
						<h4><label>收件人信息</label></h4>

							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">收件人姓名<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="receiverName<?php echo $index;?>" name="receiverName" value="{{$workOrder->ReceiverName}}" disabled />
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">收件人电话<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="receiverPhone<?php echo $index;?>" name="receiverPhone" value="{{$workOrder->ReceiverPhoneNumber}}" disabled />
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">收件人地址<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="receiverAddress<?php echo $index;?>" name="receiverAddress" value="{{$workOrder->ReceiverAddress}}" disabled />
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">State</p>
								<div class="col-sm-8">
									<select class="form-control" name="state" id="state<?php echo $index;?>" disabled > 
									<option id="selectedState<?php echo $index;?>" selected="seleted"  value="{{$workOrder->StateId}}">{{$workOrder->StateId}}</option>
									<option value="0"></option>
									@foreach ($allState as $state)
									{{$state->Name}}
									<option value="{{$state->Id}}" data-id="{{$state->Id}}">{{$state->Name}}</option> 
									@endforeach
									</select> 
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">City</p>
								<div class="col-sm-8">
									<select class="form-control" name="city" id="city<?php echo $index;?>" value="{{$workOrder->CityId}}" disabled >
									<option selected="seleted"  value="{{$workOrder->CityId}}">{{$workOrder->CityId}}</option>
									<option value="0"></option>
									</select> 
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">Zip Code<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="zipCode<?php echo $index;?>" name="zipCode" value="{{$workOrder->ZipCode}}" disabled />
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">收件人邮箱<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="email<?php echo $index;?>" name="email" value="{{$workOrder->ReceiverEmail}}" disabled />
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">邮寄货品描述<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="description<?php echo $index;?>" name="description"value="{{$workOrder->Description}}" disabled />
								</div>
							</div>
							

							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									 <button type="submit" class="btn btn-block btn-default" name="updateWO">更新订单信息</button>
								</div>
							</div>
							
							
							<script type="text/javascript">
								$('#state').on('change', function(e){
									console.log(e);
									
									var stateId = e.target.value;
									
									//ajax
									$.get('ajax-city?stateId=' + stateId, function(data){
										//success data
										$('#city').empty();
										$('#city').append('<option value="0">'+'</option>');
										$.each(data, function(index, subcatObj){
											$('#city').append('<option value="'+subcatObj.Id+'">'+subcatObj.Name+'</option>');
										});
									});
								});
							</script>
							<script type="text/javascript">
								$('#state').on('change', function(e){
									$('#zipCode').val('321422');
									
								});
							</script>
				
			</div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>  
</div>

 <?php $index++;} ?>
 <input id="index" name="index" type="hidden" value="<?php echo $index;?>">
</form>
 @stop