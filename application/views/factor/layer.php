<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<?php echo $bootstrap; ?>
<title><?php echo lang('g_layers');?> - <?php echo $study['name']; ?> - <?php echo $site_name;?></title>
<script language="javascript">
	$(document).ready(function(){
		var it='<li>'+ $('#box_groups > li:last').html() +'</li>';
		$('#btn_add').click(function(){
			$('#box_groups').append(it);
		});
	});
</script>
</head>
<body>

<div id="container">

	<ol class="breadcrumb">
	  <li><a href="<?php echo site_url("/"); ?>">Home</a></li>
	  <li><a href="<?php echo site_url("study/"); ?>">试验项目</a></li>
	  <li><a href="<?php echo $links['detail_link']; ?>"><?php echo $study['name'];?></a></li>
	  <li class="active"><?php echo lang('g_factor');?>: <?php echo $factor['name'];?></li>
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

	<div class="panel panel-default">
	  <div class="panel-heading"><?php echo sprintf(lang('layers_in_%s'),$factor['name']);?></div>
	  <div class="panel-body">
      <form name="form1" method="post" action="<?php echo $form_action;?>">
<?php if(isset($flash) and $flash){ ?>
		<div class="flash"><?php echo $flash; ?></div>
<?php } ?>
		 <div class="well well-sm"><?php echo lang('text_factor_layers_edit_notice');?></div>
		<ul id="box_groups">
<?php foreach($layers as $layer){ ?>
			<li><input name="layers[<?php echo $layer['layer_id'] ;?>]" type="text" value="<?php echo $layer['layer_name']; ?>"></li>
<?php } ?>
			<li><input name="layer_new[]" type="text" value=""> <button class="btn btn-xs" id="btn_add" type="button"><?php echo lang('add_more_layers'); ?></button></li>
			<li><input name="layer_new[]" type="text" value=""></li>
		</ul>
		<div class="box_btn">
			<button type="submit" class="btn btn-default"><?php echo lang('submit');?></button>
			<input type="hidden" name="factor_id" value="<?php echo $factor_id;?>">
		</div>
      </form>
	  </div>
	</div>


</div>

</body>
</html>