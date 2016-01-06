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

		<ul id="box_groups">
<?php foreach($factors as $item){ ?>
		<li>
			<strong><?php echo $item['factor_name']; ?></strong>  [weight:<?php echo $item['weight'];?>]
			<a href="<?php echo $item['layers_link'];?>"><?php echo lang('g_layers');?></a>
			<a href="<?php echo $item['edit_link'];?>"><?php echo lang('edit');?></a>
			<a href="<?php echo $item['del_link'];?>"><?php echo lang('delete');?></a>
		</li>
<?php } ?>
		</ul>


	  
		<fieldset>
			<legend><?php echo lang('add_new_factor');?></legend>
			 <form name="form1" method="post" action="<?php echo $form_add_action;?>">
			<dl>
				<dt>Factor Name</dt>
				<dd><input name="name" type="text" value=""></dd>
				<dt>Weight</dt>
				<dd><input name="weight" type="text" value="">(number)</dd>
				<dt></dt>
				<dd><input type="submit" name="Submit" value="<?php echo lang('submit');?>">
				<input name="study_id" type="hidden" value="<?php echo $study['id'];?>"></dd>
			
			</dl>
		 	</form>
		</fieldset>

    </div>


</div>

</body>
</html>