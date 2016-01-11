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
	  <li><a href="#">Library</a></li>
	  <li class="active">Data</li>
	</ol>

    <div id="body">
    <ul>
    <li><a href="<?php echo site_url("/study/"); ?>">我的研究课题</a></li>
    <li><a href="<?php echo site_url("/factor/"); ?>">因素</a></li>
    <li><a href="<?php echo site_url("/layer/"); ?>">水平</a></li>
    <li><a href="<?php echo site_url("/allocation/"); ?>">Allocations</a></li>
    <li><a href="<?php echo site_url("/allocation/add"); ?>">Allocation Add</a></li>
    </ul>
    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>