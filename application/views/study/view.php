<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<!--[if lt IE 9]>
<script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<title>Welcome to CodeIgniter</title>
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

<div id="container">

	<ol class="breadcrumb">
	  <li><a href="<?php echo site_url("/"); ?>">Home</a></li>
	  <li><a href="<?php echo site_url("study/"); ?>">试验项目</a></li>
	  <li class="active">全部项目</li>
	</ol>

	<div class="row">
	<h1>
	<a class="navbar-brand" href="<?php echo site_url("study/"); ?>">所有试验项目</a>
	<a class="btn btn-default" href="<?php echo $links['add']; ?>" role="button">添加新的研究</a>
	</h1>
	</div>

	<div class="table-responsive">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th>ID</th>
			  <th>name</th>
			  <th title="Bias probability distribution">Bias</th>
			  <th>groups_count</th>
			  <th>Allocations</th>
			  <th>Settings</th>
			</tr>
		  </thead>
		  <tbody>
<?php foreach($studys as $item){ ?>
			<tr>
			  <td><?php echo $item['id']; ?></td>
			  <td><a href="<?php echo $item['detail_link']; ?>" title="detail of this study"><?php echo $item['name']; ?></a></td>
			  <td><?php echo $item['bias']; ?></td>
			  <td><a href="<?php echo $item['groups_link']; ?>" title="view the groups"><?php echo $item['group_count']; ?></a></td>
			  <td>
				<a href="<?php echo $item['allocations_link']; ?>" title="allocations view">view</a>
				<a href="<?php echo $item['allocation_add_link']; ?>" title="add a new allocation">Add</a>
			  </td>
			  <td>
				<a href="<?php echo $item['detail_link']; ?>" title="detail of this study">Detail</a>
				<a href="<?php echo $item['edit_link']; ?>" title="edit this study">Edit</a>
				<a href="<?php echo $item['groups_link']; ?>" title="view the groups"><?php echo lang('g_groups'); ?></a>
				<a href="<?php echo $item['factors_link']; ?>" title="view factors in this study">Factors</a>
				<a href="<?php echo $item['layers_link']; ?>" title="view layers in this study">Layers</a>
				<a href="<?php echo $item['edit_link']; ?>" title="edit this study">Edit</a>
			  </td>
			</tr>
<?php } ?>
		  </tbody>
		  </tbody>
		</table>
	</div>



</div>

</body>
</html>