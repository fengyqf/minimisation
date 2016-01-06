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
    <h1>Studys Detail of </h1>

    <div id="body">
		<ul class="grid">
		<li class="grid_item">
		<dl>
			<dt>ID</dt>
			<dd><?php echo $item['id']; ?></dd>
			<dt>name</dt>
			<dd><?php echo $item['name']; ?></dd>
			<dt>Bias probability distribution</dt>
			<dd><?php echo $item['bias']; ?></dd>
			<dt>group_count</dt>
			<dd><a href="<?php echo $item['groups_link']; ?>" title="view the groups"><?php echo $item['group_count']; ?></a></dd>
			<dt>add time</dt>
			<dd><?php echo $item['time']; ?></dd>
			<dt><?php echo lang('g_groups');?> <a href="<?php echo $links['groups_edit_link']; ?>" title="edit this study"><?php echo lang('edit');?></a></dt>
			<dd>
				<ol>
<?php foreach($groups as $group){ ?>
					<li><?php echo $group['name']; ?></li>
<?php } ?>
				</ol>
			</dd>
			<dt><?php echo lang('g_factors');?></dt>
			<dd>
				<dl>
<?php foreach($factors as $item){ ?>
					<dt><?php echo $item['factor_name']; ?> (<?php echo $item['weight']; ?>)</dt>
					<dd>
						<ul><?php 
			foreach($item['layers'] as $it){ ?>
							<li><?php echo $it['layer_name']; ?></li>
<?php 		}		?>
						</ul>
					</dd>
<?php } ?>
					<dt><a href="<?php echo $links['factor_add'];?>" title="<?php echo lang('add_new_factor');?>">+</a></dt>
					<dd></dd>
				</dl>
			</dd>
		</dl>
		</li>
		<li>
		<dl>
			<dt><hr></dt>
			<dd></dd>
			<dt></dt>
			<dd>
				<a href="<?php echo $links['edit']; ?>" title="edit this study"><?php echo lang('edit');?></a>
				<a href="<?php echo $links['factors']; ?>" title="view factors in this study">Factors</a>
				<a href="<?php echo $links['view']; ?>">所有研究</a>
			</dd>
		</dl>
		</li>
		</ul>




    </div>


</div>

</body>
</html>