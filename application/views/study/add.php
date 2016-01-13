<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<?php echo $bootstrap; ?>
<title>Study Add/Edit - <?php echo $study['name']; ?> - <?php echo $site_name;?></title>
</head>
<body>

<div id="container">

	<ol class="breadcrumb">
	  <li><a href="<?php echo site_url("/"); ?>">Home</a></li>
	  <li><a href="<?php echo site_url("study/"); ?>">试验项目</a></li>
<?php if($study['study_id']==0){ ?>
	  <li class="active">添加新项目</li>
<?php }else{ ?>
	  <li><a href="<?php echo $links['detail_link']; ?>"><?php echo $study['name'];?></a></li>
	  <li class="active">修改设置</li>
<?php } ?>
	</ol>

<?php if(isset($flash) and $flash){ ?>
	<div class="alert alert-warning" role="alert"><?php echo $flash; ?></div>
<?php } ?>

    <h1><?php echo $study['name']; ?></h1>
<?php
if($study['study_id']==0){
	//	add
?>
	<ul class="nav nav-tabs">
	  <li role="presentation" class="active"><a href="<?php echo $links['edit']; ?>">Setting</a></li>
	  <li role="presentation"><a href="<?php echo $links['groups_edit_link']; ?>">Groups</a></li>
	  <li role="presentation"><a href="<?php echo $links['factors']; ?>">Factors</a></li>
	  <li role="presentation"><a href="<?php echo site_url('allocation/?study_id='.$study['id']);?>">Allocations</a></li>
	  <li role="presentation" class="disabled"><a href="#">Balance</a></li>
	</ul>
<?php
}else{
	//	edit
?>
	<ul class="nav nav-tabs">
	  <li role="presentation"><a href="<?php echo $links['detail_link']; ?>">Details</a></li>
	  <li role="presentation" class="active disabled"><a href="<?php echo $links['edit']; ?>">Setting</a></li>
	  <li role="presentation"><a href="<?php echo $links['groups_edit_link']; ?>">Groups</a></li>
	  <li role="presentation"><a href="<?php echo $links['factors']; ?>">Factors</a></li>
	  <li role="presentation"><a href="<?php echo site_url('allocation/?study_id='.$study['id']);?>">Allocations</a></li>
	  <li role="presentation" class="disabled"><a href="#">Balance</a></li>
	</ul>
<?php
}
?>
	<div class="panel panel-default">
	  <div class="panel-heading"><?php echo lang('settings');?></div>
      <form name="form1" method="post" action="<?php echo $form_action;?>">
<?php if(isset($flash) and $flash){ ?>
		<div class="flash"><?php echo $flash; ?></div>
<?php } ?>

		<dl>
			<dt><?php echo lang('g_study_name');?></dt>
			<dd><input type="text" name="name" id="name" value="<?php echo $study['name']; ?>"></dd>
			<dt><?php echo lang('g_bias');?></dt>
			<dd><input type="text" name="bias" id="bias" value="<?php echo $study['bias']; ?>"> 0.5~1</dd>
<?php if(1==2){ ?>
			<dt><?php echo lang('g_groups');?></dt>
			<dd>
				<ul id="box_groups">
<?php if(count($study['groups']) >1) {
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
<?php } ?>
		</dl>




		<div class="box_btn">
				<input type="submit" name="Submit" value="<?php echo lang('submit');?>">
		        <input name="id" type="hidden" id="id" value="<?php echo $study['id'];?>">
		</div>
      </form>
	</div>


</div>

</body>
</html>