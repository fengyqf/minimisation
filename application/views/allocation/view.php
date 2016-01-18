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
	  <li class="active"><?php echo lang('g_allocations');?></li>
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
	  <div class="panel-heading"><?php echo lang('current_allocations');?></div>
	  <div class="panel-body">
<?php if(1==2){ ?>
		<dl>
			<dt>ID</dt>
			<dd><?php echo $study['id']; ?></dd>
			<dt>name</dt>
			<dd><?php echo $study['name']; ?></dd>
			<dt>Bias probability distribution</dt>
			<dd><?php echo $study['bias']; ?></dd>
			<dt>groups_count</dt>
			<dd><a href="<?php echo $study['groups_link']; ?>" title="view the groups"><?php echo $study['group_count']; ?></a></dd>
			<dt>groups_count</dt>
			<dd><a href="<?php echo $study['groups_link']; ?>" title="view the groups"><?php echo $study['group_count']; ?></a></dd>
			<dt>Allocations</dt>
			<dd><?php echo $study['allocations_link']; ?></dd>
			<dt>actions</dt>
			<dd class="action">
				<a href="<?php echo $study['detail_link']; ?>" title="detail of this study">Detail</a>
				<a href="<?php echo $study['edit_link']; ?>" title="edit this study">Edit</a>
				<a href="<?php echo $study['groups_link']; ?>" title="view the groups"><?php echo lang('g_groups'); ?></a>
				<a href="<?php echo $study['factors_link']; ?>" title="view factors in this study">Factors</a>
				<a href="<?php echo $study['layers_link']; ?>" title="view layers in this study">Layers</a>
				<a href="<?php echo $study['allocations_link']; ?>" title="view allocations in this study">Allocations</a>
				<a href="<?php echo $study['allocation_add_link']; ?>" title="view allocations in this study">Allocation Add</a>
				<a href="<?php echo $study['edit_link']; ?>" title="edit this study">Edit</a>
			</dd>
		</dl>

<?php } ?>
		<div class="table-responsive">
		  <table class="table table-bordered">
            <tr>
              <th><?php echo lang('g_factors');?></th>
<?php
foreach($factors as $factor){
	//计算表格列数，及跨列长度
?>
              <th colspan="<?php echo count($factor['layers']);?>"><?php echo $factor['factor_name'];?></th>
<?php
}
?>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
            </tr>
            <tr>
              <th><?php echo lang('g_layers');?></th>
<?php
foreach($factors as $factor){
	//计算表格列数，及跨列长度
		foreach($factor['layers'] as $layer){
?>
              <th><?php echo $layer['layer_name'];?></th>
<?php
		}
}
?>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
            </tr>
<?php
foreach($groups as $group_id => $group){
?>
            <tr>
              <td align="right"><?php echo $group['group_name'];?></td>
<?php
	foreach($factors as $factor){
		foreach($factor['layers'] as $layer_id=>$layer){
			$cnt=isset($layer['group_cnt'][$group_id]) ? $layer['group_cnt'][$group_id] : '-' ;
?>
              <td><?php echo $cnt;?></td>
<?php
		}
	}
?>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
<?php
}
?>
          </table>
		</div>
		<a class="btn btn-default" href="<?php echo $study['allocation_add_link']; ?>" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span><?php echo lang('allocation_add');?></a>
	  </div>
	</div>


</div>

</body>
</html>