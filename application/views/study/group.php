<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<?php echo $bootstrap; ?>
<title>Groups - <?php echo $study['name']; ?> - <?php echo $site_name;?></title>
<script language="javascript">
	$(document).ready(function(){
		var it='<li>'+ $('#box_groups > li:last').html() +'</li>';
		$('#btn_add_group').click(function(){
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
	  <li class="active"><?php echo lang('g_groups');?></li>
	</ol>

    <h1><?php echo $study['name']; ?></h1>
	<ul class="nav nav-tabs">
	  <li role="presentation"><a href="<?php echo $links['detail_link']; ?>">Details</a></li>
	  <li role="presentation"><a href="<?php echo $links['edit']; ?>">Setting</a></li>
	  <li role="presentation" class="active"><a href="<?php echo $links['groups_edit_link']; ?>">Groups</a></li>
	  <li role="presentation"><a href="<?php echo $links['factors']; ?>">Factors</a></li>
	  <li role="presentation"><a href="<?php echo site_url('allocation/?study_id='.$study['id']);?>">Allocations</a></li>
	  <li role="presentation" class="disabled"><a href="#">Balance</a></li>
	</ul>


      <form name="form1" method="post" action="<?php echo $form_action;?>">
<?php if(isset($flash) and $flash){ ?>
		<div class="flash"><?php echo $flash; ?></div>
<?php } ?>
		<div class="well well-sm"><?php echo lang('text_study_group_notice');?></div>
		<ul id="box_groups">
<?php foreach($groups as $group){ ?>
		<li><input name="groups[<?php echo $group['id'] ;?>]" type="text" value="<?php echo $group['name']; ?>"></li>
<?php } ?>
		<li><input name="group_new[]" type="text" value=""> <button class="btn btn-xs" id="btn_add_group" type="button"><?php echo lang('add_more_groups'); ?></button></li>
		<li><input name="group_new[]" type="text" value=""></li>
		</ul>

		<div class="box_btn">
			<button type="submit" class="btn btn-default"><?php echo lang('submit');?></button>
				<input type="hidden" name="study_id" value="<?php echo $study['id'];?>">
		</div>
      </form>




</div>

</body>
</html>