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
		<dl>
			<dt>ID</dt>
			<dd><?php echo $study['id']; ?></dd>
			<dt>name</dt>
			<dd><?php echo $study['name']; ?></dd>
			<dt>Bias probability distribution</dt>
			<dd><?php echo $study['bias']; ?></dd>
			<dt>groups_count</dt>
			<dd><a href="<?php echo $study['groups_link']; ?>" title="view the groups"><?php echo $study['group_count']; ?></a></dd>
			<dt>groups_count</dt>
			<dd><a href="<?php echo $study['groups_link']; ?>" title="view the groups"><?php echo $study['group_count']; ?></a></dd>
			<dt>Allocations</dt>
			<dd><?php echo $study['allocations_link']; ?></dd>
			<dt>actions</dt>
			<dd class="action">
				<a href="<?php echo $study['detail_link']; ?>" title="detail of this study">Detail</a>
				<a href="<?php echo $study['edit_link']; ?>" title="edit this study">Edit</a>
				<a href="<?php echo $study['groups_link']; ?>" title="view the groups"><?php echo lang('g_groups'); ?></a>
				<a href="<?php echo $study['factors_link']; ?>" title="view factors in this study">Factors</a>
				<a href="<?php echo $study['layers_link']; ?>" title="view layers in this study">Layers</a>
				<a href="<?php echo $study['allocations_link']; ?>" title="view allocations in this study">Allocations</a>
				<a href="<?php echo $study['allocation_add_link']; ?>" title="view allocations in this study">Allocation Add</a>
				<a href="<?php echo $study['edit_link']; ?>" title="edit this study">Edit</a>
			</dd>
		</dl>

		<div>
<?php
//根据第一行数据计算列数
?>
		  <table width="100%" border="1" cellspacing="1" cellpadding="4">
            <tr>
              <th>因素</th>
<?php
foreach($factors as $factor){
	//计算表格列数，及跨列长度
?>
              <th colspan="<?php echo count($factor['layers']);?>"><?php echo $factor['factor_name'];?> (<?php echo $factor['factor_id'];?>)</th>
<?php
}
?>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
            </tr>
            <tr>
              <th>水平</th>
<?php
foreach($factors as $factor){
	//计算表格列数，及跨列长度
		foreach($factor['layers'] as $layer){
?>
              <th><?php echo $layer['layer_name'];?> (<?php echo $layer['layer_id'];?>)</th>
<?php
		}
}
?>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
            </tr>
<?php
foreach($groups as $group_id => $group){
?>
            <tr>
              <td align="right"><?php echo $group['group_name'];?></td>
<?php
	foreach($factors as $factor){
		foreach($factor['layers'] as $layer_id=>$layer){
			$cnt=isset($layer['group_cnt'][$group_id]) ? $layer['group_cnt'][$group_id] : '-' ;
?>
              <td><?php echo $cnt;?></td>
<?php
		}
	}
?>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
<?php
}
?>
          </table>
		</div>



    </div>


</div>

</body>
</html>