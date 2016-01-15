<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<?php echo $bootstrap; ?>
<title><?php echo lang('g_layers');?> - <?php echo $study['name']; ?> - <?php echo $site_name;?></title>
</head>
<body>

<div id="container">

	<ol class="breadcrumb">
	  <li><a href="<?php echo site_url("/"); ?>"><?php echo lang('g_home');?></a></li>
	  <li><a href="<?php echo site_url("study/"); ?>"><?php echo lang('g_study');?></a></li>
	  <li><a href="<?php echo $links['detail_link']; ?>"><?php echo $study['name'];?></a></li>
	  <li class="active"><?php echo lang('g_factors');?></li>
	</ol>

    <h1><?php echo $study['name']; ?></h1>
	<ul class="nav nav-tabs">
	  <li role="presentation"><a href="<?php echo $links['detail_link']; ?>"><?php echo lang('details');?></a></li>
	  <li role="presentation"><a href="<?php echo $links['edit']; ?>"><?php echo lang('settings');?></a></li>
	  <li role="presentation"><a href="<?php echo $links['groups_edit_link']; ?>"><?php echo lang('g_groups');?></a></li>
	  <li role="presentation" class="active"><a href="<?php echo $links['factors']; ?>"><?php echo lang('g_factors');?></a></li>
	  <li role="presentation"><a href="<?php echo site_url('allocation/?study_id='.$study['id']);?>"><?php echo lang('g_allocations');?></a></li>
	</ul>

	<div class="panel panel-default">
	  <div class="panel-heading"><?php echo lang('edit_factor');?></div>
	  <div class="panel-body">
	  	<form name="form1" method="post" action="<?php echo $form_action;?>">
			<dl>
				<dt><?php echo lang('factor_name');?></dt>
				<dd><input name="name" type="text" value="<?php echo $factor['factor_name'];?>"></dd>
				<dt><?php echo lang('weight');?></dt>
				<dd><input name="weight" type="text" value="<?php echo $factor['weight'];?>">(number)</dd>
				<dt></dt>
				<dd>
					<input type="submit" name="Submit" value="<?php echo lang('submit');?>">
					<input name="id" type="hidden" value="<?php echo $factor['factor_id'];?>">
				</dd>
			</dl>
	  	</form>
	  </div>
	</div>


    <div id="body">
<?php if(isset($flash) and $flash){ ?>
		<div class="flash"><?php echo $flash; ?></div>
<?php } ?>


    </div>


</div>

</body>
</html>