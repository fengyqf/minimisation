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
	  <div class="panel-heading"><?php echo lang('allocation_history');?> <span class="badge"><?php echo $rs_count; ?></span></div>
	  <div class="panel-body">
		<div class="table-responsive">
		  <table class="table table-bordered">
            <tr>
              <th><?php echo lang('g_factors');?></th>
<?php foreach($factors as $factor){ ?>
              <th><?php echo $factor['factor_name'];?></th>
<?php } ?>
              <th><?php echo lang('allocate_time');?></th>
              <th><?php echo lang('aim_group');?></th>
            </tr>
<?php foreach($allocations as $allocation){ ?>
            <tr>
              <td><?php echo $allocation['name'];?></td>
<?php	 foreach($factors as $factor){ ?>
              <td><?php echo $allocation['factors'][$factor['factor_id']];?></td>
<?php 	} ?>
              <td><?php echo $allocation['time'];?></td>
              <td><?php echo $allocation['group_name'];?></td>
            </tr>
<?php } ?>
          </table>
		  <?php echo $pagebar;?>
		</div>
<?php if($empty_factor_allocation_exists){ ?>
		<p><?php echo lang('text_empty_factor_allocation_exists_notice');?></p>
<?php } ?>
	  </div>
	</div>
	<a class="btn btn-default" href="<?php echo $study['allocation_history_link']; ?>" role="button"><span class="glyphicon glyphicon-time" aria-hidden="true"></span><?php echo lang('allocation_history');?></a>
	<a class="btn btn-default" href="<?php echo $study['allocation_add_link']; ?>" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span><?php echo lang('allocation_add');?></a>


</div>

</body>
</html>