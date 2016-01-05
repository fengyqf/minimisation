<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-ch">
<head>
<meta charset="utf-8">
<title>Allocation Report</title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url('static'); ?>/style.css" />
</head>
<body>

<div id="container">
    <h1>Allocation Add</h1>

    <div id="body">
		<fieldset>
			<legend>新添加项目的各因素水平</legend>
			<dl>
<?php foreach($factors as $factor){ ?>
				<dt><?php echo $factor['factor_name']; ?></dt>
				<dd><?php echo $factor['layer_name']; ?></dd>
<?php } ?>
				<dt><hr></dt>
				<dd></dd>
				<dt></dt>
				<dd><a href="<?php echo $link['correct']; ?>">如果以上内容录入有误，点此清理并重录</a></dd>
			</dl>
		</fieldset>


		<fieldset>
			<legend>分配目标组</legend>
			<dl><?php echo $aim_group['group_name'];?></dl>
		</fieldset>


		<fieldset>
			<legend>分配后各组标准差</legend>
			<dl>{这一块暂不做了，有需要再补}</dl>
		</fieldset>


		<fieldset>
			<legend>下一步</legend>
			<ul>
				<li><a href="<?php echo $link['add_new']; ?>">New Allocation Add</a></li>
				<li><a href="<?php echo $link['correct']; ?>">Correct This Allocation</a></li>
				<li><a href="<?php echo $link['view']; ?>">View</a></li>
			</ul>
		</fieldset>
		
    </div>

    
</div>

</body>
</html>