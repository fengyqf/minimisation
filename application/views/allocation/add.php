<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<?php echo $bootstrap; ?>
<title><?php echo lang('g_allocations');?> - <?php echo $study['name']; ?> - <?php echo $site_name;?></title>
</head>
<body>

<div id="container">

	<ol class="breadcrumb">
	  <li><a href="<?php echo site_url("/"); ?>"><?php echo lang('g_home');?></a></li>
	  <li><a href="<?php echo site_url("study/"); ?>"><?php echo lang('g_studies');?></a></li>
	  <li><a href="<?php echo $links['detail_link']; ?>"><?php echo $study['name'];?></a></li>
	  <li class="active"><?php echo lang('allocation_add');?></li>
	</ol>


    <h1><?php echo $study['name']; ?></h1>
	<ul class="nav nav-tabs">
	  <li role="presentation"><a href="<?php echo $links['detail_link']; ?>"><?php echo lang('details');?></a></li>
	  <li role="presentation"><a href="<?php echo $links['edit']; ?>"><?php echo lang('settings');?></a></li>
	  <li role="presentation"><a href="<?php echo $links['groups_edit_link']; ?>"><?php echo lang('g_groups');?></a></li>
	  <li role="presentation"><a href="<?php echo $links['factors']; ?>"><?php echo lang('g_factors');?></a></li>
	  <li role="presentation" class="active"><a href="<?php echo site_url('allocation/?study_id='.$study['id']);?>"><?php echo lang('g_allocations');?></a></li>
	</ul>

	<div class="panel panel-default">
	  <div class="panel-heading"><?php echo lang('allocation_add');?></div>
	  <div class="panel-body">

      <form class="form-horizontal" name="form1" method="post" action="<?php echo $form_action;?>">
<?php if(isset($flash) and $flash){ ?>
	<div class="alert alert-warning" role="alert"><?php echo $flash; ?></div>
<?php } ?>



	<fieldset>
		<legend><?php echo lang('layer_of_every_factor');?></legend>
<?php foreach($factors as $factor_id => $factor){ ?>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label"><?php echo $factor['factor_name']; ?></label>
			<div class="col-sm-10">
				<select name="factors[<?php echo $factor_id; ?>]" id="factors_<?php echo $factor_id; ?>">
	<?php foreach($factor['layers'] as $layer){ ?>
					<option value="<?php echo $layer['layer_id'];?>"><?php echo $layer['layer_name'];?></option>
	<?php } ?>
				</select>
			</div>
		</div>
<?php } ?>
	</fieldset>

	<fieldset>
		<legend><?php echo lang('additions');?></legend>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang('addition_name');?></label>
			<div class="col-sm-10">
				<input type="hidden" name="study_id" value="<?php echo $study_id;?>">
				<input name="name" type="text" id="name"> 
				<p class="help-block"><?php echo lang('text_addition_name_notice');?></p>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend><?php echo lang('confirm');?></legend>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default"><?php echo lang('confirm_allocate');?></button>
			</div>
		</div>
	</fieldset>
<?php if(1==2){ ?>
		<fieldset>
			<legend><?php echo lang('layer_of_every_factor');?></legend>
			<dl>
<?php foreach($factors as $factor_id => $factor){ ?>
				<dt><?php echo $factor['factor_name']; ?></dt>
				<dd>
				<select name="factors[<?php echo $factor_id; ?>]">
	<?php foreach($factor['layers'] as $layer){ ?>
					<option value="<?php echo $layer['layer_id'];?>"><?php echo $layer['layer_name'];?></option>
	<?php } ?>
				</select>
				</dd>
<?php } ?>
			</dl>
		</fieldset>

		<div class="box_btn">
				<input type="submit" name="Submit" value="<?php echo lang('confirm_allocate');?>">
		</div>
<?php } ?>

      </form>


	  </div>

	</div>


    
</div>

</body>
</html>