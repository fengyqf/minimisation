<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-ch">
<head>
<meta charset="utf-8">
<title>Add a patient</title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url('static'); ?>/style.css" />
</head>
<body>

<div id="container">
    <h1>Welcome to Minimisation!</h1>

    <div id="body">
      <form name="form1" method="post" action="<?php echo $form_action;?>">
	  <dl>
		<dt>姓名</dt>
        <dd><input name="name" type="text" id="name"> 
        可留空，系统自动填充</dd>
		<dt>study_id{hidden lable}</dt>
        <dd>
        <input type="text" name="study_id" value="<?php echo $study_id;?>">
        </dd>
<?php foreach($factors as $factor_id => $factor){ ?>
		<dt><?php echo $factor['factor_name']; ?></dt>
        <dd>
		<select name="factors[<?php echo $factor_id; ?>]">
	<?php foreach($factor['layers'] as $layer){ ?>
		  <option value="<?php echo $layer['layer_id'];?>"><?php echo $layer['layer_name'];?></option>
	<?php } ?>
	    </select>
		</dd>
<?php } ?>
		<dt>&nbsp;</dt>
        <dd>
        <input type="submit" name="Submit" value="提交">
        </dd>
		</dl>
      </form>
    

    
</div>

</body>
</html>