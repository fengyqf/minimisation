<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//general name
$lang['site_name'] = 'Minimisation';

$lang['g_study']  = "Study";
$lang['g_studies'] = "Studies";
$lang['g_factor']  = "Factor";
$lang['g_factors'] = "Factors";
$lang['g_layer']  = "Layer";
$lang['g_layers'] = "Layers";
$lang['g_allocation']  = "Allocation";
$lang['g_allocations'] = "Allocations";
$lang['g_group']  = "Group";
$lang['g_groups'] = "Groups";
$lang['g_home']  = "Home Page";

$lang['g_bias'] = "Assignment probabilities";
$lang['bias'] = "Assignment probabilities";
$lang['text_bias_note'] = "keep it, if you have no idea";
$lang['default_study_name'] = "New Study";

$lang['g_study_name'] = "Study Name";
$lang['study_name'] = "Study Name";
$lang['add_time'] = "Add Time";


$lang['submit'] = "Submit";
$lang['edit'] = "Edit";
$lang['delete'] = "Delete";
$lang['operate']='Operate';
$lang['weight']='Weight';
$lang['settings'] = "Settings";
$lang['details'] = "Details";
$lang['property'] = "Property";
$lang['confirm'] = "Confirm";
$lang['view'] = "View";
$lang['add'] = "Add";
$lang['detail'] = "Detail";
$lang['name'] = "Name";
$lang['welcome'] = "Welcome";
$lang['my_studies'] = "My Studies";


//study
//$lang['groups_in_%s'] = "Groups in study <strong>%s</strong>";
$lang['add_more_groups'] = "+ Add More";
$lang['edit_factor'] = "Edit Factor";
$lang['groups_in_%s'] = "Groups in <strong>%s</strong>";
$lang['add_new_study'] = "Add New Study";
$lang['edit_study'] = "Edit Study";
$lang['all_studies'] = "All Studies";
$lang['text_study_del_confirm'] = "Delete this study? all the allocations will LOST!";

$lang['factors_layers'] = "Factors/Layers";

$lang['none_layers'] = "none layers";
$lang['add_more_layers'] = "+ Add More";

//allocation
$lang['allocations_count'] = "Allocations Count";
$lang['current_allocations'] = "Current Allocations";
$lang['allocation_add'] = "Add New Allocation";
$lang['layer_of_every_factor'] = "Layer of Every Factor";
$lang['additions'] = "Additions";
$lang['addition_name'] = "Name";
$lang['text_addition_name_notice'] = "blank allowed, auto fill.";
$lang['aim_group'] = "Aim Group";
$lang['next_step'] = "Next";
$lang['allocation_history'] = "Allocation History";
$lang['unknown_group'] = "unknown";

$lang['mesg_factors_not_enough']='Factors not enough, 2 at least';
$lang['mesg_factors_only_one']='Only ONE factor, Minimisation degenerate to simple random';
$lang['mesg_layers_not_enough_in_%s']='Layers not enough in <strong>%s</strong>';
$lang['text_allocation_add_factor_count_error_notice']='All the factors MUST have a Layer.';
$lang['text_allocation_add_factor_to_layer_error_notice']='Each factor must has a right layer';

$lang['text_study_group_notice']='input all the groups below, each in one box; blank box will be ignored.<br>to delete a group, just delete it and submit.';
$lang['allocation_fix_add']='Mistaken? Correct It';
$lang['confirm_allocate'] = "Do Allocate";
$lang['allocation_correct_notice']='this Allocation was cleared, input and allocate again please.';
$lang['allocate_time'] = "Allocate Time";
$lang['text_empty_factor_allocation_exists_notice'] = "Allocation with an empty layer, means that you deleted a factor yet. ";

//factor
$lang['factor_name']='Factor Name';
$lang['new_factor_default_name']='New Factor';
$lang['current_factor_and_layers']='Current Factors and Layers';
$lang['text_no_layer_notice']='None, check Edit to set';
$lang['text_factor_delete_confirm_notice']='Layers in this Factor and the Allocations will LOST, Are You Sure Delete It?';
$lang['add_new_factor'] = "Add New Factor";
$lang['layers_in_%s']='Edit Layers in <strong>%s</strong>';
$lang['text_factor_layers_edit_notice']="input all the Layers in this factor below, each in one box; blank box will be ignored.<br>to delete a layer, just delete it and submit.";
$lang['numeric_required']='numeric required';
$lang['text_factors_none_notice']='None factor added, You must add severial factors; And you must add at least 2 layers for each factor';
$lang['text_factors_page_notice']='If you have allocated items, do NOT delete any factor, or the new allocation will be not presise!';
