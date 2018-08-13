<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<?php echo $bootstrap; ?>
<title><?php echo lang('all_studies'); ?> - <?php echo $site_name;?></title>
</head>
<body>

<div id="container">

	<ol class="breadcrumb">
	  <li><a href="<?php echo site_url("/"); ?>"><?php echo lang('g_home');?></a></li>
	  <li><a href="<?php echo site_url("study/"); ?>"><?php echo lang('g_studies');?></a></li>
	  <li class="active"><?php echo lang('all_studies'); ?></li>
	</ol>

	<div class="row">
	<h1>
	<a class="navbar-brand" href="<?php echo site_url("study/"); ?>"><?php echo lang('all_studies');?></a>
	<a class="btn btn-default" href="<?php echo $links['add']; ?>" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span><?php echo lang('add_new_study');?></a>
	</h1>
	</div>

	<div class="table-responsive">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th><?php echo lang('name');?></th>
			  <th><?php echo lang('separated_by_center');?></th>
			  <th title="<?php echo lang('g_bias');?>"><?php echo lang('bias');?></th>
			  <th><?php echo lang('add_time');?></th>
			  <th><?php echo lang('g_allocations');?></th>
			  <th><?php echo lang('operate');?></th>
			</tr>
		  </thead>
		  <tbody>
<?php foreach($studies as $item){ ?>
			<tr>
			  <td><a href="<?php echo $item['detail_link']; ?>"><?php echo $item['name']; ?></a></td>
			  <td><?php echo $item['separated_by_center']; ?></td>
			  <td><?php echo $item['bias']; ?></td>
			  <td><?php echo $item['time']; ?></td>
			  <td>
				<a href="<?php echo $item['allocations_link']; ?>" role="button" class="btn btn-default btn-sm"><?php echo lang('view'); ?></a>
				<a href="<?php echo $item['allocation_add_link']; ?>" role="button" class="btn btn-default btn-sm"><?php echo lang('add'); ?></a>
			  </td>
			  <td>
				<a href="<?php echo $item['detail_link']; ?>" role="button" class="btn btn-default btn-sm" title="detail of this study"><?php echo lang('detail'); ?></a>
				<a href="<?php echo $item['edit_link']; ?>" role="button" class="btn btn-default btn-sm" title="edit this study"><?php echo lang('edit'); ?></a>
				<a href="<?php echo $item['del_link']; ?>" role="button" class="btn btn-default btn-sm" onClick="return confirm('<?php echo lang('text_study_del_confirm');?>')" title="delete this study"><?php echo lang('delete'); ?></a>
				<a href="<?php echo $item['groups_link']; ?>" role="button" class="btn btn-default btn-sm" title="view the groups"><?php echo lang('g_groups'); ?></a>
				<a href="<?php echo $item['factors_link']; ?>" role="button" class="btn btn-default btn-sm" title="view factors in this study"><?php echo lang('g_factors'); ?></a>
			  </td>
			</tr>
<?php } ?>
		  </tbody>
		</table>
	</div>



</div>

</body>
</html>