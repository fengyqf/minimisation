<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<?php echo $bootstrap; ?>
<title><?php echo lang('g_factors');?> - <?php echo $study['name']; ?> - <?php echo $site_name;?></title>
</head>
<body>

<div id="container">

	<ol class="breadcrumb">
	  <li><a href="<?php echo site_url("/"); ?>">Home</a></li>
	  <li><a href="<?php echo site_url("study/"); ?>">试验项目</a></li>
	  <li><a href="<?php echo $links['detail_link']; ?>"><?php echo $study['name'];?></a></li>
	  <li class="active"><?php echo lang('g_factors');?></li>
	</ol>

    <h1><?php echo $study['name']; ?></h1>
	<ul class="nav nav-tabs">
	  <li role="presentation"><a href="<?php echo $links['detail_link']; ?>">Details</a></li>
	  <li role="presentation"><a href="<?php echo $links['edit']; ?>">Setting</a></li>
	  <li role="presentation"><a href="<?php echo $links['groups_edit_link']; ?>">Groups</a></li>
	  <li role="presentation" class="active"><a href="<?php echo $links['factors']; ?>">Factors</a></li>
	  <li role="presentation"><a href="<?php echo site_url('allocation/?study_id='.$study['id']);?>">Allocations</a></li>
	  <li role="presentation" class="disabled"><a href="#">Balance</a></li>
	</ul>

<?php if(isset($flash) and $flash){ ?>
		<div class="alert alert-warning" role="alert"><?php echo $flash; ?></div>
<?php } ?>

<?php if(count($factors)>0){ ?>
	<div class="panel panel-default">
	  <div class="panel-heading"><?php echo lang('current_factor_and_layers');?></div>
	  <div class="panel-body">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th><?php echo lang('factor_name');?></th>
			  <th><?php echo lang('weight');?></th>
			  <th><?php echo lang('operate');?></th>
			  <th><?php echo lang('g_layers');?></th>
			</tr>
		  </thead>
		  <tbody>
<?php foreach($factors as $item){ ?>
			<tr>
			  <td><?php echo $item['factor_name']; ?></td>
			  <td><?php echo $item['weight'];?></td>
			  <td nowrap="nowrap">
				<a href="<?php echo $item['edit_link'];?>"><?php echo lang('edit');?></a>
				<a href="<?php echo $item['del_link'];?>" onClick="return confirm('<?php echo lang('text_factor_delete_confirm_notice');?>')"><?php echo lang('delete');?></a>
			  </td>
			  <td>
<?php		if(count($item['layers']) == 0 ){ ?>
				<span class="label label-warning"><?php echo lang('text_no_layer_notice'); ?></span>
<?php		}else{
				foreach($item['layers'] as $layer) { ?>
				  <span class="label label-default"><?php echo $layer['layer_name'];?></span>
<?php		}
		}
?>
				<a href="<?php echo $item['layers_link'];?>"><?php echo lang('edit');?></a>
			  </td>
			</tr>
<?php } ?>
		  </tbody>
		</table>
	  </div>
	</div>
<?php } ?>
	<div class="panel panel-default">
	  <div class="panel-heading"><?php echo lang('add_new_factor');?></div>
		 <form name="form1" method="post" action="<?php echo $form_add_action;?>">
			<dl>
				<dt>Factor Name</dt>
				<dd><input name="name" type="text" value=""></dd>
				<dt>Weight</dt>
				<dd><input name="weight" type="text" value="">(numeric)</dd>
				<dt></dt>
				<dd><input type="submit" name="Submit" value="<?php echo lang('submit');?>">
				<input name="study_id" type="hidden" value="<?php echo $study['id'];?>"></dd>
			</dl>
		</form>
	</div>



</div>

</body>
</html>