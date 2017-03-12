<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
	<link href="http://localhost/blog/public/css/bootstrap.min.css" rel="stylesheet">
	
	<script src="https://code.jquery.com/jquery.js"></script>
	<script src="http://localhost/blog/public/js/bootstrap.min.js"></script>
	<style type="text/css">
		label.error{color:#ea5200; margin-left:4px; padding:0px 20px; background:url(images/unchecked.gif) no-repeat 2px 0 }
		html,body{
			height:100%
		}
		body {
			background-image:	url(http://localhost/blog/public/images/首8.png),
								url(http://localhost/blog/public/images/首9.png),
								url(http://localhost/blog/public/images/首10.png);
			background-repeat:	no-repeat,
								no-repeat,
								no-repeat;
			background-position:	right,
									bottom,
									center;
			background-size: 50%, 100%, 100% 100%;
		}
		
		
	</style>
	<script type="text/javascript" src="http://localhost/blog/public/js/jquery.js"></script> 
	<script type="text/javascript" src="http://localhost/blog/public/js/jquery.validate.js"></script> 
	<script type="text/javascript" src="http://localhost/blog/public/js/validate-ex.js"></script>
	<script type="text/javascript" src="http://localhost/blog/public/js/jquery.validate.messages_cn.js"></script>
	<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
	<script type="text/javascript">
$(function(){	   
	var validate = $("#myform").validate({
		rules:{
			userName:{
				maxlength:16,
				minlength:8,
				userName:true/*,
				remote: { 
                   url: "chk_user.php", 
                   type: "post", 
                   data: { user: function() { return encodeURIComponent($("#user").val());}}  
               } */
			},
			password:{
				maxlength:16,
				minlength:8
			},
			repass:{
				maxlength:16,
				minlength:8,
				equalTo:"#password"
			},
			sex:"required",
			email:{email:true},
			tel:{isTel:true},
			phone:{isMobile:true},
			url:{url:true},
			birthday:"dateISO",
			years:{
				digits:true,
				range:[1,40]
			},
			idcard:"isIdCardNo",
			zipcode:"isZipCode",
			photo:{
				accept:"gif|jpg|png"
			},
			serverIP:"ip",
			captcha:{
				remote:"process.php"
			}
		},
		messages:{
			user:{
				remote:"该用户名已存在，请换个其他的用户名！"
			},
			repass:{
				equalTo:"两次密码输入不一致！"
			},
			sex:"请选择性别！",
			birthday:{
				dateISO:"日期格式不对!"
			},
			years:{
				number:"工作年限必须为数字！"
			},
			address:"请选择地区",
			photo:{
				accept:"头像图片格式不对！"
			},
			captcha:{
				remote:"验证码错误！"
			},
			low:" "
		},
		errorPlacement: function(error, element) {
			if ( element.is(":radio") )
				error.appendTo ( element.parent() );
			else if ( element.is(":checkbox") )
				error.appendTo ( element.parent() );
			else if ( element.is("input[name=captcha]") )
				error.appendTo ( element.parent() );
			else
				error.insertAfter(element);
		},
	    success: function(label) {
		   label.html("&nbsp;").addClass("right");
	    }			  
	});	
	
	$("input:reset").click(function(){
		validate.resetForm();
	});
});
</script>
	<script type="text/javascript">
	function toggle_visibility(id1,id2) {
       var e1 = document.getElementById(id1);
	   var e2 = document.getElementById(id2);
       if(e2.style.display == 'block')
          e2.style.display = 'none';
	  if(e1.style.display != 'block')
          e1.style.display = 'block';
	}
	
	function toggle_tabvisibility(id) {
       var e1 = document.getElementById(id);
	  if(e1.style.display != 'block')
          e1.style.display = 'block';
	}
	</script>

	
	<script type="text/javascript">
function AjaxFunction()
{
var httpxml;
try
  {
  // Firefox, Opera 8.0+, Safari
  httpxml=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
		  try
   			 		{
   				 httpxml=new ActiveXObject("Msxml2.XMLHTTP");
    				}
  			catch (e)
    				{
    			try
      		{
      		httpxml=new ActiveXObject("Microsoft.XMLHTTP");
     		 }
    			catch (e)
      		{
      		alert("Your browser does not support AJAX!");
      		return false;
      		}
    		}
  }
function stateck() 
    {
    if(httpxml.readyState==4)
      {
var myarray = JSON.parse(httpxml.responseText);

// Before adding new we must remove previously loaded elements
for(j=document.myform.city.options.length-1;j>=0;j--)
{
document.myform.city.remove(j);
}

for (i=0;i<myarray.data.length;i++)
{
var optn = document.createElement("OPTION");
optn.text = myarray.data[i].city;
optn.value = myarray.data[i].city;
document.myform.city.options.add(optn);

} 

      }
    }
	var url="workOrder.php";
var cat_id=document.getElementById('state').value;
url=url+"?stateId="+cat_id;
httpxml.onreadystatechange=stateck;
//alert(url);
httpxml.open("GET",url,true);
httpxml.send(null);
  }
</script>

	<!-- checkbox check all -->
	<script type="text/javascript">
	$(document).ready(function(){
		var chk = false;
		$('.checkboxAll').click(function(){
			chk = !chk;
			$('.checkboxList').prop('checked',chk);
		});
	});
	</script>	
	
		<script type="text/javascript">
							function isEditable() {
								var count = 0;
								var length = document.getElementById("WOCount").value;
								for (;count < length; count++) { 
									if (document.getElementById("checked"+count).checked){
										document.getElementById('selectedStatus'+count).style.display= "none";
										$("#trackingNum"+count).prop('readonly', false);
										$("#weight"+count).prop('readonly', false);
										$("#status"+count).prop('disabled', false);
									}
								}
							}
	</script>
	
	<script type="text/javascript">
							function editWO() {
								var count = 0;
								var length = document.getElementById("index").value;
								for (;count < length; count++) { 
									document.getElementById('selectedState'+count).style.display= "none";
									document.getElementById('selectedWOCategory'+count).style.display= "none";
									$("#wonum"+count).prop('disabled', false);
									$("#woCategory"+count).prop('disabled', false);
									$("#weight"+count).prop('disabled', false);
									$("#senderName"+count).prop('disabled', false);
									$("#senderPhone"+count).prop('disabled', false);
									$("#senderAddress"+count).prop('disabled', false);
									$("#receiverName"+count).prop('disabled', false);
									$("#receiverPhone"+count).prop('disabled', false);
									$("#receiverAddress"+count).prop('disabled', false);
									$("#state"+count).prop('disabled', false);
									$("#city"+count).prop('disabled', false);
									$("#zipCode"+count).prop('disabled', false);
									$("#email+count"+count).prop('disabled', false);
									$("#description"+count).prop('disabled', false);
								}
							}
	</script>
	<?php echo $__env->yieldContent('header'); ?>
</head>
	
<body style="height:100%" width="100%">

  
<div class="container" style="padding-top: 2%">

<img src="http://localhost/blog/public/images/首1.png" background-size="cover" width="100%;" height="20%">
		<div class="col-md-9 column">
		
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
			</img>
		</div>
		
		
		<?php if(Session::has('userId')): ?>
			<div class="col-md-3 column">
				 <a onClick="document.location.href='./login'"><?php echo e(Session::get('userName')); ?></a>
			</div>
			
		<?php else: ?>
			<div class="col-md-3 column">
		<!--<button type="button" style="background: url(http://localhost/blog/public/images/首2.png); background-repeat:no-repeat; background-size: 100% 100%" class="btn btn-lg btn-block" onClick="document.location.href='./login'"></button>-->
				 <button type="button" class="btn btn-lg btn-block" style="background: url(http://localhost/blog/public/images/首2.png); background-repeat:no-repeat; background-size:100% 100%;" onClick="document.location.href='./login'"><br></button>
			</div>
		<?php endif; ?>
		

</div>

	<?php echo $__env->yieldContent('content'); ?>
	
	<?php echo $__env->yieldContent('footer'); ?>
</body>
</html>