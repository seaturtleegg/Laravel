<?php $__env->startSection('content'); ?>

<div class="container">
	<div class="row clearfix">
	<?php echo $__env->make('layouts.selfCenter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

		<div class="col-md-10 column" style="margin-top: 3%">
			<div class="tabbable" id="tabs-onekeyorder"> <!-- style="display: none;"-->
				<button type="button" class="btn btn-default" onclick="toggle_visibility('panel-singleorder','panel-multipleorder');">单个下单</button>
				<button type="button" class="btn btn-default" onclick="toggle_visibility('panel-multipleorder','panel-singleorder');">批量下单</button>
			
			
				<div class="container" id="panel-singleorder" style="display:none;">
					<div class="col-md-8 column" style="margin-top:2%">
						<h4><label>中美快递中国国内物流信息</label></h4>
						<form id="myform" name="form" method="post" class="form-horizontal" role="form" action='createwo'>
							<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
							<div class="form-group">
								 <p for="text" class="col-sm-4 control-label">国内物流运单号<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="wonum" name="wonum" />
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">货物类型</p>
								<div class="col-sm-8">
									<select class="form-control" name="woCategory" id="woCategory"> 
									<option value="0"></option>
									<?php $__currentLoopData = $woCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $woCategory): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
									<?php echo e($woCategory->Name); ?>

									<option value="<?php echo e($woCategory->Id); ?>" data-id="<?php echo e($woCategory->Id); ?>"><?php echo e($woCategory->Name); ?></option> 
									<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
									</select> 
								</div>
							</div>

						<h4><label>中美快递国际物流信息</label>
						<!-- Trigger the modal with a button -->
						<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="margin-left:5%">选择已有联系人</button></h4>

	 
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">寄件人姓名<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="senderName" name="senderName"/>
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">寄件人电话<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="senderPhone" name="senderPhone"/>
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">寄件人地址<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="senderAddress" name="senderAddress"/>
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">Receiver Name<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="receiverName" name="receiverName"/>
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">Receiver Phone Number<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="receiverPhone" name="receiverPhone"/>
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">Receiver Address<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="receiverAddress" name="receiverAddress" value=""/>
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">State</p>
								<div class="col-sm-8" id = "state">
									<select class="form-control" name="state" id="state"> 
									<option value="0"></option>
									<?php $__currentLoopData = $allState; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
									<?php echo e($state->Name); ?>

									<option value="<?php echo e($state->Id); ?>" data-id="<?php echo e($state->Id); ?>"><?php echo e($state->Name); ?></option> 
									<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
									</select> 
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">City</p>
								<div class="col-sm-8">
									<select class="form-control" name="city" id="city">
									<option value="0"></option>
									</select> 
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">Zip Code<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="zipCode" name="zipCode" value=""/>
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">Receiver Email<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="email" name="email"/>
								</div>
							</div>
							<div class="form-group">
								<p for="text" class="col-sm-4 control-label">邮寄货品描述<font color="red">*</font></p>
								<div class="col-sm-8">
									<input type="text" class="required form-control" id="description" name="description"/>
								</div>
							</div>
							

							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<div class="checkbox">
										 <label><input name='saveReceiver' type="checkbox" />勾选保存当前地址到地址薄</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									 <button type="submit" class="btn btn-block btn-default" name="submit">确认并提交订单</button>
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
							
						</form>
					</div>
				</div>
				
				<div class="container" id="panel-multipleorder" style="display:none;">
					<div class="col-md-12 column"  style="margin-top:2%">
						 <button type="button" class="btn btn-default" onclick="document.location.href='uploadwo'">上传订单</button>
						 <button type="button" class="btn btn-default">修改订单</button>
						 <button type="button" class="btn btn-default" onclick="toggle_visibility('panel-singleorder','panel-multipleorder');">添加订单</button>
						 <button type="button" class="btn btn-default">删除订单</button>
						<table class="table table-bordered table-hover table-condensed" style="margin-top: 5%">
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
												<input id="checked<?php echo $count;?>" name="checked<?php echo $count;?>" type="checkbox" class="checkboxList"/>
											</td>
											<td>
												<?php echo $workOrder[1]//wonum ?>
											</td>
											<td>
												<?php echo $workOrder[2]//receiver ?>
											</td>
											<td>
												<?php echo $workOrder[3]//city ?>
											</td>
											<td>
												<?php echo $workOrder[8]//wotype ?>
											</td>
											<td>
												<input id="weight<?php echo $count;?>" name="weight<?php echo $count;?>" type="text" value="<?php echo $workOrder[4];?>" style="width:40px; border:none" readonly>
											</td>
											<td>
												<?php //echo $workOrder[4]//trackingNum ?>
											</td>
											<td>
												<?php echo $workOrder[6]//status ?>
											</td>
											<td>
												<?php echo $workOrder[7]//modifydate ?>
											</td>
										</tr>
									<?php $count++;} ?>
									<input id="WOCount" name="WOCount" type="hidden" value="<?php echo $count;?>">
								</tbody>
						</table>
			</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade col-md-8 col-md-offset-2" style="margin-top:5%" id="myModal" role="dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">选择联系人</h4>
        </div>
        <div class="modal-body">
			<div class="container">
				<div class="col-md-12 column">
					<table class="table table-condensed table-hover table-bordered" onclick="myFun(event)">
						<thead>
							<tr>
								<th>
									姓名
								</th>
								<th>
									地址
								</th>
								<th>
									电话
								</th>
								<th>
									邮箱
								</th>
								<th>
									地区
								</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($receivers as $receiver){
						?>
							<tr>
								<td>
								<?php echo e($receiver->Name); ?>

								</td>
								<td>
									<?php echo e($receiver->Address); ?>

								</td>
								<td>
									<?php echo e($receiver->PhoneNumber); ?>

								</td>
								<td>
									<?php echo e($receiver->Email); ?>

								</td>
								<td>
									<?php echo e($receiver->Name); ?>

								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>  
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>