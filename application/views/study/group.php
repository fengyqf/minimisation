<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-ch">
<head>
<meta charset="utf-8">
<title>Study Add</title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url('static'); ?>/style.css" />
</head>
<body>

<div id="container">
    <h1><?php echo sprintf(lang('groups_in_%s'),$study['name']);?></h1>

    <div id="body">
      <form name="form1" method="post" action="<?php echo $form_action;?>">
<?php if(isset($flash) and $flash){ ?>
		<div class="flash"><?php echo $flash; ?></div>
<?php } ?>

		<ul id="box_groups">
<?php foreach($groups as $group){ ?>
		<li><input name="groups[<?php echo $group['id'] ;?>]" type="text" value="<?php echo $group['name']; ?>"></li>
<?php } ?>
		<li><input name="group_new[]" type="text" value=""> <span id="btn_add"><?php echo lang('add_more_groups'); ?></span></li>
		<li><input name="group_new[]" type="text" value=""></li>
		</ul>
<div class="flash">TODO：此功能未测试：删除指定group时，同步删除allocation,allocation2layer数据</div>
		<div class="box_btn">
				<input type="submit" name="Submit" value="<?php echo lang('submit');?>">
				<input type="hidden" name="study_id" value="<?php echo $study['id'];?>">
		</div>
      </form>
    </div>


</div>

</body>
</html>