<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//general name
$lang['site_name'] = '最小化随机工具';

$lang['g_study']  = "试验项目";
$lang['g_studies'] = "试验项目";
$lang['g_factor']  = "因素";
$lang['g_factors'] = "因素";
$lang['g_layer']  = "水平";
$lang['g_layers'] = "水平";
$lang['g_allocation']  = "分配";
$lang['g_allocations'] = "分配";
$lang['g_group']  = "组";
$lang['g_groups'] = "组";
$lang['g_home']  = "首页";
$lang['g_center'] = "中心";
$lang['g_centers'] = "中心";

$lang['g_bias'] = "偏倚分配概率";
$lang['bias'] = "偏倚分配概率";
$lang['access_token'] = "Access token";
$lang['separated_by_center'] = "按中心分配";
$lang['text_bias_note'] = "0.5~1；推荐操持默认值";
$lang['default_study_name'] = "新试验项目";

$lang['g_study_name'] = "试验名称";
$lang['study_name'] = "试验名称";
$lang['add_time'] = "添加时间";


$lang['submit'] = "提交";
$lang['edit'] = "修改";
$lang['delete'] = "删除";
$lang['operate']='操作';
$lang['weight']='权重';
$lang['settings'] = "设置";
$lang['details'] = "详情";
$lang['property'] = "属性";
$lang['confirm'] = "确认";
$lang['view'] = "浏览";
$lang['add'] = "添加";
$lang['detail'] = "详细";
$lang['name'] = "名称";
$lang['welcome'] = "欢迎";
$lang['my_studies'] = "我的试验项目";
$lang['username'] = "用户名";
$lang['password'] = "密码";
$lang['login'] = "登录";
$lang['logout'] = "退出";
$lang['token_generate'] = "生成 token";


//study
//$lang['groups_in_%s'] = "Groups in study <strong>%s</strong>";
$lang['add_more_groups'] = "+ 增加";
$lang['edit_factor'] = "修改因素";
$lang['groups_in_%s'] = "<strong>%s</strong>下的组";
$lang['add_new_study'] = "添加新试验项目";
$lang['edit_study'] = "修改设置";
$lang['all_studies'] = "所有试验项目";
$lang['text_study_del_confirm'] = "确定的要删除该试验项目吗？所有录入分配记录将被删除！";

$lang['factors_layers'] = "因素/水平";

$lang['none_layers'] = "没有水平";
$lang['add_more_layers'] = "+ 增加水平";

//allocation
$lang['allocations_count'] = "已分配数";
$lang['current_allocations'] = "已录入分配项";
$lang['allocation_add'] = "新的录入分配项";
$lang['layer_of_every_factor'] = "各因素水平";
$lang['additions'] = "附加字段";
$lang['addition_name'] = "录入分配项名称";
$lang['text_addition_name_notice'] = "可留空，系统自动填充";
$lang['aim_group'] = "分配目标组";
$lang['next_step'] = "下一步";
$lang['allocation_history'] = "分配历史记录";
$lang['unknown_group'] = "未知组";
$lang['input_center_name'] = "填写中心名称";
$lang['center_name_blank'] = "默认中心（名称留空白）";

$lang['mesg_factors_not_enough']='因素不足，至少要求两个因素';
$lang['mesg_factors_only_one']='当前只有一个因素，可以做分配，分配效果等同于简单随机化分配';
$lang['mesg_layers_not_enough_in_%s']='<strong>%s</strong>下的水平数不足';
$lang['text_allocation_add_factor_count_error_notice']='请给每个因素选择相应的水平数据';
$lang['text_allocation_add_factor_to_layer_error_notice']='请给每个因素选择正确的水平数据';
$lang['text_input_center_name'] = "手工填写中心名称时，新中心名、或已存在的中心名皆可。 已存在的中心名将被自动归类";
$lang['text_center_blank_error_notice'] = "本项目是按中心分配项目，请选择中心，或在文本框手工输入中心名称";

$lang['text_study_group_notice']='请在下面录入所有的分组，每个文本框填写一个分组；空白文本框将被忽略。<br>如需删除原有分组，清空相应文本框并提交即可。';
$lang['allocation_fix_add']='录错了，点此清理并重录';
$lang['confirm_allocate'] = "提交，执行随机化";
$lang['allocation_correct_notice']='该条分配数据已经被清除，请在下面重新录入。';
$lang['allocate_time'] = "分配时间";
$lang['text_empty_factor_allocation_exists_notice'] = "某条分配带有空白的水平，这意味着您录入过该条分配后，删除过某个分层。";

//factor
$lang['factor_name']='因素名';
$lang['new_factor_default_name']='新的因素';
$lang['current_factor_and_layers']='当前因素及水平';
$lang['text_no_layer_notice']='无水平，请点此设置';
$lang['text_factor_delete_confirm_notice']='该因素下所有水平，及相关的所有分配记录将丢失，确定删除吗？';
$lang['add_new_factor'] = "添加新的因素";
$lang['layers_in_%s']='修改<strong>%s</strong>下的水平';
$lang['text_factor_layers_edit_notice']="输入该因素下的所有水平，每文本框输入一个水平；空白文档框将被忽略; 空白文档框将自动忽略。<br>如需删除原有的水平，清空相应文本框并提交即可。";
$lang['numeric_required']='限填数字';
$lang['text_factors_none_notice']='没有因素。您必须添若干个因素，每个因素至少有两个水平。';
$lang['text_factors_page_notice']='如果您已添加过配项目，请不要删除任何因素。否则该因素相关的分配项将丢失，则该因素相关的分配项将丢失，并且新的分配操作也会受残余数据影响变得不准确。当然您可以删除所有分组、因素、水平后再做分配';

