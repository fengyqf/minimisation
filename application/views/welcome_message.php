<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<?php echo $bootstrap; ?>
<title><?php echo $site_name;?></title>
</head>
<body>

<div id="container">

	<ol class="breadcrumb">
	  <li><a href="<?php echo site_url("/"); ?>"><?php echo lang('g_home');?></a></li>
	  <li class="active"><?php echo lang('welcome');?></li>
	</ol>

    <div id="body">
    <ul>
<?php if($user_id>0){ ?>
    <li><a href="<?php echo site_url("/study/"); ?>"><?php echo lang('my_studies');?></a></li>
    <li><a href="<?php echo site_url("/welcome/logout"); ?>"><?php echo lang('logout');?></a>
<?php }else{ ?>
    <li><a href="<?php echo site_url("/welcome/login"); ?>"><?php echo lang('login');?></a>
<?php } ?>
    </ul>
    </div>

    <div>
		<li><a href="?lang=english">English</a></li>
		<li><a href="?lang=zh_cn">简体中文</a></li>
	</div>
</div>

</body>
</html>