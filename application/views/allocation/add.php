<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<?php echo $bootstrap; ?>
<title><?php echo lang('g_allocations');?> - <?php echo $study['name']; ?> - <?php echo $site_name;?></title>
<script type="text/javascript">
	$(document).ready(function(){
		$("label[for='center_input']").click(function(){
			$("input[name='center']").attr('checked',false)
		});
		$("input[name='center']").click(function(){
			$("input[name='center_input']").val('');
		});
		$('#token_help').click(function(){
			$('#token_note').toggle();
			return false;
		});
		$("#form1").change(function(){
			var url="<?php echo site_url('/allocation/add_do');?>";
			var study_id="<?php echo $study_id;?>";
			var token="<?php echo $study['access_token']; ?>";
			var center_name=$("input[name='center']:checked").attr('title');
			if(center_name==undefined){
				center_name=$("input[name='center_input']").val();
			}
			var str_factor='';
			$("input:radio[name^='factors']:checked").each(function(){
				str_factor+='&'+this.name+'='+this.value;
			})
			str_factor=encodeURI(str_factor);
			var a_name=$("input:text[name='name']").val();
			var curl="curl -i "+url+"?view=json -d 'center_input="+center_name+str_factor+"&study_id="+study_id+"&name="+a_name+"&token="+token+"'";
			$('#token_note').html(curl);
		})

	})
</script>
<style type="text/css">
	#centers_container label{padding: 0 20px 0 0;}
</style>
</head>
<body>

<div id="container">

	<ol class="breadcrumb">
	  <li><a href="<?php echo site_url("/"); ?>"><?php echo lang('g_home');?></a></li>
	  <li><a href="<?php echo site_url("study/"); ?>"><?php echo lang('g_studies');?></a></li>
	  <li><a href="<?php echo $links['detail_link']; ?>"><?php echo $study['name'];?></a></li>
	  <li class="active"><?php echo lang('allocation_add');?></li>
	</ol>


    <h1><?php echo $study['name']; ?></h1>
	<ul class="nav nav-tabs">
	  <li role="presentation"><a href="<?php echo $links['detail_link']; ?>"><?php echo lang('details');?></a></li>
	  <li role="presentation"><a href="<?php echo $links['edit']; ?>"><?php echo lang('settings');?></a></li>
	  <li role="presentation"><a href="<?php echo $links['groups_edit_link']; ?>"><?php echo lang('g_groups');?></a></li>
	  <li role="presentation"><a href="<?php echo $links['factors']; ?>"><?php echo lang('g_factors');?></a></li>
	  <li role="presentation" class="active"><a href="<?php echo site_url('allocation/?study_id='.$study['id']);?>"><?php echo lang('g_allocations');?></a></li>
	</ul>

	<div class="panel panel-default">
	  <div class="panel-heading"><?php echo lang('allocation_add');?></div>
	  <div class="panel-body">

      <form class="form-horizontal" name="form1" id="form1" method="post" action="<?php echo $form_action;?>">
<?php if(isset($flash) and $flash){ ?>
	<div class="alert alert-warning" role="alert"><?php echo $flash; ?></div>
<?php } ?>

<?php if(1==2){?>
	<fieldset>
		<legend><?php echo lang('layer_of_every_factor');?></legend>
<?php foreach($factors as $factor_id => $factor){ ?>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label"><?php echo $factor['factor_name']; ?></label>
			<div class="col-sm-10">
				<select name="factors[<?php echo $factor_id; ?>]" id="factors_<?php echo $factor_id; ?>">
	<?php foreach($factor['layers'] as $layer){ ?>
					<option value="<?php echo $layer['layer_id'];?>"><?php echo $layer['layer_name'];?></option>
	<?php } ?>
				</select>
			</div>
		</div>
<?php } ?>
	</fieldset>
<?php } ?>
<?php if($study['separated_by_center']==1) { ?>
	<fieldset>
		<legend><?php echo lang('g_centers');?></legend>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label"></label>
			<div class="col-sm-10" id="centers_container">
	<?php foreach($centers as $center_id => $center) { ?>
			    <label for="center_<?php echo $center['center_id']; ?>">
			    <input type="radio" name="center" id="center_<?php echo $center['center_id']; ?>" value="<?php echo $center['center_id'];?>" title="<?php echo $center['center_name'];?>">
			    <?php echo $center['center_name'];?></label>
	<?php 	} ?>
			    <label for="center_input">
			    <input type="text" name="center_input" id="center_input" value=""><?php echo lang('input_center_name');?>
			    </label>
			</div>
		</div>
		<div class="alert alert-info" role="alert"><?php echo lang('text_input_center_name');?></div>
	</fieldset>
<?php } ?>

	<fieldset>
		<legend><?php echo lang('layer_of_every_factor');?></legend>
<?php foreach($factors as $factor_id => $factor){ ?>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label"><?php echo $factor['factor_name']; ?></label>
			<div class="col-sm-10">
	<?php foreach($factor['layers'] as $layer){ ?>
			    <label for="factors_<?php echo $layer['layer_id']; ?>" style="margin:0 10px 0 0;">
			    <input type="radio" name="factors[<?php echo $factor_id; ?>]" id="factors_<?php echo $layer['layer_id']; ?>" value="<?php echo $layer['layer_id'];?>" title="<?php echo $layer['layer_name'];?>">
			    <?php echo $layer['layer_name'];?></label>
	<?php } ?>
			</div>
		</div>
<?php } ?>
	</fieldset>

	<fieldset>
		<legend><?php echo lang('additions');?></legend>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang('addition_name');?></label>
			<div class="col-sm-10">
				<input type="hidden" name="study_id" value="<?php echo $study_id;?>">
				<input name="name" type="text" id="name"> 
				<p class="help-block"><?php echo lang('text_addition_name_notice');?></p>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend><?php echo lang('confirm');?></legend>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default"><?php echo lang('confirm_allocate');?></button>
				&nbsp;<a href="#" id="token_help"><sub>api</sub></a>
			</div>
		</div>
	</fieldset>
<?php if(1==2){ ?>
		<fieldset>
			<legend><?php echo lang('layer_of_every_factor');?></legend>
			<dl>
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
			</dl>
		</fieldset>

		<div class="box_btn">
				<input type="submit" name="Submit" value="<?php echo lang('confirm_allocate');?>">
		</div>
<?php } ?>
		<div id="token_note" style="display: none;">
			<pre>Allocation API via HTTP:
</pre>
		</div>

      </form>


	  </div>

	</div>


    
</div>

</body>
</html>