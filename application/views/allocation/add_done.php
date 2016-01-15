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
	  <li><a href="<?php echo site_url("study/"); ?>"><?php echo lang('g_study');?></a></li>
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

		<fieldset>
			<legend><?php echo lang('layer_of_every_factor');?></legend>
<?php foreach($factors as $factor){ ?>
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo $factor['factor_name']; ?></label>
				<div class="col-sm-10"><p class="form-control-static"><?php echo $factor['layer_name']; ?></p></div>
			</div>
<?php } ?>
			<div class="form-group">
				<label class="col-sm-2 control-label">&nbsp;</label>
				<div class="col-sm-10">
					<a class="btn btn-default" role="button" href="<?php echo $link['correct']; ?>">
						<span class="glyphicon glyphicon-repeat" aria-hidden="true"></span><?php echo lang('allocation_fix_add');?>
					</a>
				</div>
			</div>
		</fieldset>


		<fieldset>
			<legend><?php echo lang('aim_group');?></legend>
			<div class="form-group">
				<label class="col-sm-2 control-label">&nbsp;</label>
				<div class="col-sm-10"><?php echo $aim_group['group_name'];?></div>
			</div>
		</fieldset>

<?php if(1==2){ ?>
		<h1>TODO</h1>
		<fieldset>
			<legend>分配后各组标准差</legend>
			<dl>{这一块暂不做了，有需要再补}</dl>
		</fieldset>
<?php } ?>

		<fieldset>
			<legend><?php echo $aim_group['next_step'];?></legend>
			<div class="form-group">
				<label class="col-sm-2 control-label">&nbsp;</label>
				<div class="col-sm-10">
					<a class="btn btn-default" role="button" href="<?php echo $link['add_new']; ?>">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span><?php echo lang('allocation_add');?>
					</a>
					<a class="btn btn-default" role="button" href="<?php echo $link['correct']; ?>"><?php echo lang('allocation_fix_add');?></a>
					<a class="btn btn-default" role="button" href="<?php echo $link['view']; ?>"><?php echo lang('view');?></a>
				</div>
			</div>
		</fieldset>

	  </div>




    
</div>

</body>
</html>