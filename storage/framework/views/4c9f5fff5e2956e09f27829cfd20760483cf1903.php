<html>
<head>
	
</head>

<body>

<div style="border:1px dashed #333333; width:300px; margin:0 auto; padding:10px;">
    
	<form name="import" method="post" enctype="multipart/form-data" action='uploadWO'>
		<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    	<input type="file" name="file" /><br />
        <input type="submit" name="submit" value="Submit" />
    </form>
</div>
   

</body>
</html>