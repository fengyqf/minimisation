<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<?php echo $bootstrap; ?>
<title>Study Add - <?php echo $site_name;?></title>
</head>
<body>

<div id="container">

	<ol class="breadcrumb">
	  <li><a href="<?php echo site_url("/"); ?>">Home</a></li>
	  <li><a href="<?php echo site_url("study/"); ?>">试验项目</a></li>
	  <li class="active">添加新项目</li>
	</ol>

<?php if(isset($flash) and $flash){ ?>
	<div class="alert alert-warning" role="alert"><?php echo $flash; ?></div>
<?php } ?>

	<ul class="nav nav-tabs">
	  <li role="presentation" class="active"><a href="#">Settings</a></li>
	  <li role="presentation" class="disabled"><a href="#">Profile</a></li>
	  <li role="presentation" class="disabled"><a href="#">Messages</a></li>
	</ul>

      <form name="form1" method="post" action="<?php echo $form_action;?>">
<?php if(isset($flash) and $flash){ ?>
		<div class="flash"><?php echo $flash; ?></div>
<?php } ?>

		<dl>
			<dt><?php echo lang('g_study_name');?></dt>
			<dd><input name="name" type="text" id="name" value="<?php echo $study['name']; ?>"></dd>
			<dt><?php echo lang('g_bias');?></dt>
			<dd><input name="name" type="text" id="name" value="<?php echo $study['bias']; ?>"> 0.5~1</dd>
			<dt><?php echo lang('g_groups');?></dt>
			<dd>
				<ul id="box_groups">
<?php if(count($study['group']) >1) {
		//修改study时，将原有study全部列出，方便用户直接在这里修改，这功能可能是个坑
			foreach($study['group'] as $group_id => $group){
?>
				<li><input name="group[<?php echo $group_id ;?>]" type="text" value="<?php echo $group['name']; ?>"></li>
<?php
			}
	   }
	   //添加study时
?>
				<li><input name="group[]" type="text" value=""> <span id="btn_add">+</span></li>
				<li><input name="group[]" type="text" value=""></li>
				<li><input name="group[]" type="text" value=""></li>
				</ul>
			</dd>
		</dl>




		<div class="box_btn">
				<input type="submit" name="Submit" value="<?php echo lang('submit');?>">
		</div>
      </form>



</div>

</body>
</html>