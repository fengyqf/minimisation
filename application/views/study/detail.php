<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<?php echo $bootstrap; ?>
<title>Detail - <?php echo $study['name']; ?> - <?php echo $site_name;?></title>
</head>
<body>

<div id="container">

	<ol class="breadcrumb">
	  <li><a href="<?php echo site_url("/"); ?>">Home</a></li>
	  <li><a href="<?php echo site_url("study/"); ?>">试验项目</a></li>
	  <li class="active"><?php echo $study['name']; ?></li>
	</ol>

    <h1><?php echo $study['name']; ?></h1>
	<ul class="nav nav-tabs">
	  <li role="presentation" class="active disabled"><a href="#">Details</a></li>
	  <li role="presentation"><a href="<?php echo $links['edit']; ?>">Setting</a></li>
	  <li role="presentation"><a href="<?php echo $links['groups_edit_link']; ?>">Groups</a></li>
	  <li role="presentation"><a href="<?php echo $links['factors']; ?>">Factors</a></li>
	  <li role="presentation"><a href="<?php echo site_url('allocation/?study_id='.$study['id']);?>">Allocations</a></li>
	  <li role="presentation" class="disabled"><a href="#">Balance</a></li>
	</ul>


	<div class="panel panel-default">
	  <div class="panel-heading">Property</div>
	  <div class="panel-body">
		<h3><span class="label label-default">Study Name</span> <?php echo $study['name']; ?></h3>
		<h5><span class="label label-default" title="Bias probability distribution">Bias</span> <?php echo $study['bias']; ?></h3>
		<h5><span class="label label-default">Add Time</span> <?php echo $study['time']; ?></h5>
		<h5><span class="label label-default"><?php echo lang('allocations_count');?></span> <a href="<?php echo site_url('allocation/?study_id='.$study['id']);?>"><?php echo $allocations_count; ?></a></h5>

	  </div>
	</div>

	<div class="panel panel-default">
	  <div class="panel-heading">Groups</div>
	  <div class="panel-body">
		<ol>
<?php foreach($groups as $group){ ?>
			<li><?php echo $group['name']; ?></li>
<?php } ?>
		</ol>
	  </div>
	</div>

	<div class="panel panel-default">
	  <div class="panel-heading">Factors/Layers</div>
	  <div class="panel-body">
		<dl>
<?php foreach($factors as $item){ ?>
			<dt><?php echo $item['factor_name']; ?> (<?php echo $item['weight']; ?>)</dt>
			<dd>
				<ul><?php
	if(isset($item['layers'])){
		foreach($item['layers'] as $it){ ?>
					<li><?php echo $it['layer_name']; ?></li>
<?php 			}
	}else{
?>
					<li><?php echo lang('none_layers');?></li>
<?php		} ?>
				</ul>
			</dd>
<?php }
if(1==2){
?>
			<dt><a href="<?php echo $links['factor_add'];?>" title="<?php echo lang('add_new_factor');?>">+</a></dt>
			<dd></dd>
<?php
}
?>
		</dl>
	  </div>
	</div>



<?php
if(1==2){
?>
		<dl>
			<dt>ID</dt>
			<dd><?php echo $study['id']; ?></dd>
			<dt>name</dt>
			<dd><?php echo $study['name']; ?></dd>
			<dt>Bias probability distribution</dt>
			<dd><?php echo $study['bias']; ?></dd>
			<dt>group_count</dt>
			<dd><a href="<?php echo $study['groups_link']; ?>" title="view the groups"><?php echo $study['group_count']; ?></a></dd>
			<dt>add time</dt>
			<dd><?php echo $study['time']; ?></dd>
			<dt><?php echo lang('g_groups');?> <a href="<?php echo $links['groups_edit_link']; ?>" title="edit this study"><?php echo lang('edit');?></a></dt>
			<dd>
				<ol>
<?php foreach($groups as $group){ ?>
					<li><?php echo $group['name']; ?></li>
<?php } ?>
				</ol>
			</dd>
			<dt><?php echo lang('g_factors');?></dt>
			<dd>
				<dl>
<?php foreach($factors as $item){ ?>
					<dt><?php echo $item['factor_name']; ?> (<?php echo $item['weight']; ?>)</dt>
					<dd>
						<ul><?php
			if(isset($item['layers'])){
				foreach($item['layers'] as $it){ ?>
							<li><?php echo $it['layer_name']; ?></li>
<?php 			}
			}else{
		?>
							<li><?php echo lang('none_layers');?></li>
<?php		} ?>
						</ul>
					</dd>
<?php } ?>
					<dt><a href="<?php echo $links['factor_add'];?>" title="<?php echo lang('add_new_factor');?>">+</a></dt>
					<dd></dd>
				</dl>
			</dd>
			<dt><?php echo lang('allocations_count');?></dt>
			<dd><a href="<?php echo site_url('allocation/?study_id='.$study['id']);?>"><?php echo $allocations_count; ?></a></dd>
		</dl>
		<dl>
			<dt><hr></dt>
			<dd></dd>
			<dt></dt>
			<dd>
				<a href="<?php echo $links['edit']; ?>" title="edit this study"><?php echo lang('edit');?></a>
				<a href="<?php echo $links['factors']; ?>" title="view factors in this study">Factors</a>
				<a href="<?php echo $links['view']; ?>">所有研究</a>
			</dd>
		</dl>
<?php
}
?>




</div>

</body>
</html>