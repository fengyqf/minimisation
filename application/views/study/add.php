<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<?php echo $bootstrap; ?>
<title><?php echo lang('g_allocations');?> - <?php echo $study['name']; ?> - <?php echo $site_name;?></title>
<script type="text/javascript">
	function randomStrCode(len) {
	    var d,
	        e,
	        b = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
	        c = "";
	        for (d = 0; len > d; d += 1){
	            e = Math.random() * b.length, e = Math.floor(e), c += b.charAt(e);
	        }
	        return c.toLocaleUpperCase();
	}

	$(document).ready(function(){
		$('#token_generate').click(function(){
			var nstr=randomStrCode(80);
			$("#access_token").val(nstr);
			return false;
		});
		$('#token_help').click(function(){
			$('#token_note').toggle();
			return false;
		});
	})

</script>
</head>
<body>

<div id="container">

	<ol class="breadcrumb">
	  <li><a href="<?php echo site_url("/"); ?>"><?php echo lang('g_home');?></a></li>
	  <li><a href="<?php echo site_url("study/"); ?>"><?php echo lang('g_studies');?></a></li>
<?php if($study['study_id']==0){ ?>
	  <li class="active"><?php echo lang('add_new_study');?></li>
<?php }else{ ?>
	  <li><a href="<?php echo $links['detail_link']; ?>"><?php echo $study['name'];?></a></li>
	  <li class="active"><?php echo lang('edit_study');?></li>
<?php } ?>
	</ol>

<?php if(isset($flash) and $flash){ ?>
	<div class="alert alert-warning" role="alert"><?php echo $flash; ?></div>
<?php } ?>

    <h1><?php echo $study['name']; ?></h1>
<?php
if($study['study_id']==0){
	//	add
?>
	<ul class="nav nav-tabs">
	  <li role="presentation" class="disabled"><a href="<?php echo $links['detail_link']; ?>"><?php echo lang('details');?></a></li>
	  <li role="presentation" class="active"><a href="<?php echo $links['edit']; ?>"><?php echo lang('settings');?></a></li>
	  <li role="presentation" class="disabled"><a href="<?php echo $links['groups_edit_link']; ?>"><?php echo lang('g_groups');?></a></li>
	  <li role="presentation" class="disabled"><a href="<?php echo $links['factors']; ?>"><?php echo lang('g_factors');?></a></li>
	  <li role="presentation" class="disabled"><a href="<?php echo site_url('allocation/?study_id='.$study['id']);?>"><?php echo lang('g_allocations');?></a></li>
	</ul>
<?php
}else{
	//	edit
?>
	<ul class="nav nav-tabs">
	  <li role="presentation"><a href="<?php echo $links['detail_link']; ?>"><?php echo lang('details');?></a></li>
	  <li role="presentation" class="active disabled"><a href="<?php echo $links['edit']; ?>"><?php echo lang('settings');?></a></li>
	  <li role="presentation"><a href="<?php echo $links['groups_edit_link']; ?>"><?php echo lang('g_groups');?></a></li>
	  <li role="presentation"><a href="<?php echo $links['factors']; ?>"><?php echo lang('g_factors');?></a></li>
	  <li role="presentation"><a href="<?php echo site_url('allocation/?study_id='.$study['id']);?>"><?php echo lang('g_allocations');?></a></li>
	</ul>
<?php
}
?>
	<div class="panel panel-default">
	  <div class="panel-heading"><?php echo lang('settings');?></div>
	  <div class="panel-body">
      <form name="form1" method="post" action="<?php echo $form_action;?>">
<?php if(isset($flash) and $flash){ ?>
		<div class="flash"><?php echo $flash; ?></div>
<?php } ?>

		<dl>
			<dt><?php echo lang('g_study_name');?></dt>
			<dd><input type="text" name="name" id="name" value="<?php echo $study['name']; ?>"></dd>
			<dt><?php echo lang('g_bias');?></dt>
			<dd><input type="text" name="bias" id="bias" value="<?php echo $study['bias']; ?>"><?php echo lang('text_bias_note');?></dd>
			<dt><?php echo lang('access_token');?></dt>
			<dd><textarea name="access_token" id="access_token" cols="40" rows="4"><?php echo $study['access_token']; ?></textarea><a href="#" id="token_generate" style="margin: 0 0 0 20px;"><?php echo lang('token_generate'); ?></a>&nbsp;<a href="#" id="token_help">?</a>
				<div id="token_note" style="display: none;">
					<pre>Allocation API via HTTP:
curl -i -d 'center_input={center_code}&factors%5B{factor_id}%5D={layer_id}&study_id=<?php echo $study['study_id'];?>&name=&token=<?php echo $study['access_token']; ?>' -A "{user-agent}" <?php echo site_url('/allocation/add_do');?>?view=json</pre>
				</div>
			</dd>
			<dt></dt>
			<dd><label><input type="checkbox" name="separated_by_center" id="separated_by_center" value="1" <?php if( $study['separated_by_center']){ ?> checked="checked" <?php } ?>><?php echo lang('separated_by_center');?></label></dd>
<?php if(1==2){ ?>
			<dt><?php echo lang('g_groups');?></dt>
			<dd>
				<ul id="box_groups">
<?php if(count($study['groups']) >1) {
		//修改study时，将原有groups全部列出，方便用户直接在这里修改，这功能可能是个坑
			foreach($study['group'] as $group_id => $group){
?>
				<li><input name="group[<?php echo $group_id ;?>]" type="text" value="<?php echo $group['name']; ?>"></li>
<?php
			}
	   }
	   //添加study时
?>
				<li><input name="group[]" type="text" value=""> <span id="btn_add">+</span></li>
				<li><input name="group[]" type="text" value=""></li>
				<li><input name="group[]" type="text" value=""></li>
				</ul>
			</dd>
<?php } ?>
		</dl>



		<div class="box_btn">
<?php if(isset($in_add_guide) && $in_add_guide==1){ ?>
			<button type="submit" class="btn btn-default"><?php echo lang('next_step');?></button>
		        <input name="in_add_guide" type="hidden" id="in_add_guide" value="1">
<?php }else{ ?>
			<button type="submit" class="btn btn-default"><?php echo lang('submit');?></button>
<?php } ?>
		        <input name="id" type="hidden" id="id" value="<?php echo $study['id'];?>">
		</div>
      </form>
	  </div>
	</div>


</div>

</body>
</html>