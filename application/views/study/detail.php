<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<?php echo $bootstrap; ?>
<title><?php echo lang('details');?> - <?php echo $study['name']; ?> - <?php echo $site_name;?></title>
</head>
<body>

<div id="container">

	<ol class="breadcrumb">
	  <li><a href="<?php echo site_url("/"); ?>"><?php echo lang('g_home');?></a></li>
	  <li><a href="<?php echo site_url("study/"); ?>"><?php echo lang('g_study');?></a></li>
	  <li class="active"><?php echo $study['name']; ?></li>
	</ol>

    <h1><?php echo $study['name']; ?></h1>
	<ul class="nav nav-tabs">
	  <li role="presentation" class="active disabled"><a href="<?php echo $links['detail_link']; ?>"><?php echo lang('details');?></a></li>
	  <li role="presentation"><a href="<?php echo $links['edit']; ?>"><?php echo lang('settings');?></a></li>
	  <li role="presentation"><a href="<?php echo $links['groups_edit_link']; ?>"><?php echo lang('g_groups');?></a></li>
	  <li role="presentation"><a href="<?php echo $links['factors']; ?>"><?php echo lang('g_factors');?></a></li>
	  <li role="presentation"><a href="<?php echo site_url('allocation/?study_id='.$study['id']);?>"><?php echo lang('g_allocations');?></a></li>
	</ul>


	<div class="panel panel-default">
	  <div class="panel-heading"><?php echo lang('property');?></div>
	  <div class="panel-body">
		<h3><span class="label label-default"><?php echo lang('g_study_name');?></span> <?php echo $study['name']; ?></h3>
		<h5><span class="label label-default" title="<?php echo lang('g_bias');?>"><?php echo lang('bias');?></span> <?php echo $study['bias']; ?></h3>
		<h5><span class="label label-default"><?php echo lang('add_time');?></span> <?php echo $study['time']; ?></h5>
		<h5><span class="label label-default"><?php echo lang('allocations_count');?></span> <a href="<?php echo site_url('allocation/?study_id='.$study['id']);?>"><?php echo $allocations_count; ?></a></h5>

	  </div>
	</div>

	<div class="panel panel-default">
	  <div class="panel-heading"><?php echo lang('g_groups');?></div>
	  <div class="panel-body">
		<ol>
<?php foreach($groups as $group){ ?>
			<li><?php echo $group['name']; ?></li>
<?php } ?>
		</ol>
	  </div>
	</div>

	<div class="panel panel-default">
	  <div class="panel-heading"><?php echo lang('factors_layers');?></div>
	  <div class="panel-body">
<?php foreach($factors as $item){ ?>
			<div class="form-group">
				<div class="col-sm-2 control-label"><?php echo $item['factor_name']; ?> (<?php echo $item['weight']; ?>)</div>
				<div class="col-sm-10">
<?php
			if(isset($item['layers'])){
				foreach($item['layers'] as $it){ ?>
					<span class="label label-default"><?php echo $it['layer_name']; ?></span>
<?php 			}
			}else{
?>
					<span class="label label-default"><?php echo lang('none_layers');?></span>
<?php		} ?>
				</div>
			</div>
<?php } ?>

<?php if(1==2){ ?>
			<div class="form-group">
				<div class="col-sm-2 control-label"><?php echo $item['factor_name']; ?> (<?php echo $item['weight']; ?>)</div>
				<div class="col-sm-10">
					<a href="<?php echo $links['factor_add'];?>" title="<?php echo lang('add_new_factor');?>">+</a>
				</div>
			</div>
<?php } ?>
	  </div>
	</div>




</div>

</body>
</html>