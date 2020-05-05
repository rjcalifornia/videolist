<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$video = get_entity($vars['guid']);
$vars['entity'] = $video;

$action_buttons = '';
$delete_link = '';


if ($vars['guid']) {
	// add a delete button if editing
	$delete_url = "action/videolist/delete?guid={$vars['guid']}";
	$delete_link = elgg_view('output/url', array(
		'href' => $delete_url,
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button elgg-button-delete float-alt',
		'confirm' => true,
	));
}






if($vars['simple'] == 1)
{
    $video_label = elgg_echo('videolist:original:title');
$video_input = elgg_view('input/text', array(
	'name' => 'title',
	'id' => 'videolist_title',
	'value' => $vars['title']
));

$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('save'),
       // 'id' => 'share',
      //  'hidden' => 'true',
	'name' => 'save',
));
}
else
{
$video_label = elgg_echo('videolist:title');
$video_input = elgg_view('input/text', array(
	'name' => 'url',
	'id' => 'videolist_url',
        'onkeyup' => 'validateYouTubeUrl();',
	'value' => $vars['url']
));

$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('save'),
        'id' => 'share',
        'hidden' => 'true',
	'name' => 'save',
));
}

$action_buttons = $save_button . $delete_link;

//echo $vars['simple'];

$comments_label = elgg_echo('comments');
$comments_input = elgg_view('input/select', array(
	'name' => 'comments_on',
	'id' => 'videolist_comments_on',
	'value' => $vars['comments_on'],
	'options_values' => array('On' => elgg_echo('on'), 'Off' => elgg_echo('off'))
));


$access_label = elgg_echo('access');
$access_input = elgg_view('input/access', array(
	'name' => 'access_id',
	'id' => 'videolist_access_id',
	'value' => $vars['access_id'],
	'entity' => $vars['entity'],
	'entity_type' => 'object',
	'entity_subtype' => 'videolist',
));

$container_guid_input = elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));
$guid_input = elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['guid']));


echo <<<___HTML

<div>
	<label for="blog_title">$video_label</label>
	$video_input
</div>

<div>
	<label for="blog_comments_on">$comments_label</label>
	$comments_input
</div>

<div>
	<label for="blog_access_id">$access_label</label>
	$access_input
</div>


$guid_input
$container_guid_input

___HTML;

$footer = <<<___HTML

$action_buttons
___HTML;

elgg_set_form_footer($footer);