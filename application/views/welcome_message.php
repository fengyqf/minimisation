<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome to CodeIgniter</title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url('static'); ?>/style.css" />
</head>
<body>

<div id="container">
    <h1>Welcome to Minimisation!</h1>

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