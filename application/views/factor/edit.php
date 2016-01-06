<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-ch">
<head>
<meta charset="utf-8">
<title>Study Add</title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url('static'); ?>/style.css" />
</head>
<body>

<div id="container">
    <h1>Study Add</h1>
	<div class="bread"><?php echo $study['name'];?> &raquo; Factors</div>
    <div id="body">
<?php if(isset($flash) and $flash){ ?>
		<div class="flash"><?php echo $flash; ?></div>
<?php } ?>


		<fieldset>
			<legend><?php echo lang('edit_factor');?></legend>
	  <form name="form1" method="post" action="<?php echo $form_action;?>">
			<dl>
				<dt>Factor Name</dt>
				<dd><input name="name" type="text" value="<?php echo $factor['factor_name'];?>"></dd>
				<dt>Weight</dt>
				<dd><input name="weight" type="text" value="<?php echo $factor['weight'];?>">(number)</dd>
				<dt></dt>
				<dd>
					<input type="submit" name="Submit" value="<?php echo lang('submit');?>">
					<input name="id" type="hidden" value="<?php echo $factor['factor_id'];?>">
				</dd>
			
			</dl>
		 	</form>
		</fieldset>


    </div>


</div>

</body>
</html>