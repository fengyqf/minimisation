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
    <form class="form-horizontal" name="form1" method="post" action="<?php echo site_url("welcome/auth"); ?>">
        <ul>
        <li><?php echo lang('username');?><input type="text" name="name" /></li>
        <li><?php echo lang('password');?><input type="password" name="pass" /></li>
        <li><input type="submit" name="submit" value="<?php echo lang('login');?>" /></li>
        </ul>
    </form>
    </div>

</div>

</body>
</html>