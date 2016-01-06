<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-ch">
<head>
<meta charset="utf-8">
<title>Studys View</title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url('static'); ?>/style.css" />
</head>
<body>

<div id="container">
    <h1>Studys View</h1>

    <div id="body">
		<ul class="grid">
<?php foreach($studys as $item){ ?>
		<li class="grid_item">
		<dl>
			<dt>ID</dt>
			<dd><?php echo $item['id']; ?></dd>
			<dt>name</dt>
			<dd><?php echo $item['name']; ?></dd>
			<dt>Bias probability distribution</dt>
			<dd><?php echo $item['bias']; ?></dd>
			<dt>groups_count</dt>
			<dd><a href="<?php echo $item['groups_link']; ?>" title="view the groups"><?php echo $item['group_count']; ?></a></dd>
			<dt>add time</dt>
			<dd><?php echo $item['time']; ?></dd>
			<dt>actions</dt>
			<dd class="action">
				<a href="<?php echo $item['detail_link']; ?>" title="detail of this study">Detail</a>
				<a href="<?php echo $item['edit_link']; ?>" title="edit this study">Edit</a>
				<a href="<?php echo $item['factors_link']; ?>" title="view factors in this study">Factors</a>
				<a href="<?php echo $item['layers_link']; ?>" title="view layers in this study">Layers</a>
				<a href="<?php echo $item['allocations_link']; ?>" title="view allocations in this study">Allocations</a>
				<a href="<?php echo $item['edit_link']; ?>" title="edit this study">Edit</a>
			</dd>
		</dl>
		</li>
<?php } ?>
		<li>
		<dl>
			<dt><hr></dt>
			<dd></dd>
			<dt></dt>
			<dd><a href="<?php echo $links['add']; ?>">添加新的研究</a></dd>
		</dl>
		</li>
		</ul>




    </div>


</div>

</body>
</html>