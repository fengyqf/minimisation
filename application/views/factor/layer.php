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
    <h1><?php echo sprintf(lang('groups_in_%s'),'');?></h1>

    <div id="body">
      <form name="form1" method="post" action="<?php echo $form_action;?>">
<?php if(isset($flash) and $flash){ ?>
		<div class="flash"><?php echo $flash; ?></div>
<?php } ?>

		<ul id="box_groups">
<?php foreach($layers as $layer){ ?>
		<li><input name="layers[<?php echo $layer['layer_id'] ;?>]" type="text" value="<?php echo $layer['layer_name']; ?>"></li>
<?php } ?>
		<li><input name="layer_new[]" type="text" value=""> <span id="btn_add"><?php echo lang('add_more_layers'); ?></span></li>
		<li><input name="layer_new[]" type="text" value=""></li>
		</ul>
<div class="flash">TODO：此功能未测试：删除指定group时，同步删除allocation,allocation2layer数据</div>
		<div class="box_btn">
				<input type="submit" name="Submit" value="<?php echo lang('submit');?>">
				<input type="hidden" name="factor_id" value="<?php echo $factor_id;?>">
		</div>
      </form>
    </div>


</div>

</body>
</html>