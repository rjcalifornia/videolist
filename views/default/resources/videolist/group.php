<?php

$subpage = elgg_extract('subpage', $vars);
$page_type = elgg_extract('page_type', $vars);
$group_guid = elgg_extract('group_guid', $vars);
$lower = elgg_extract('lower', $vars);
$upper = elgg_extract('upper', $vars);

elgg_entity_gatekeeper($group_guid, 'group');
elgg_group_gatekeeper();

$group = get_entity($group_guid);

if (!isset($subpage) || $subpage == 'all') {
	$params = get_shared_videolist($group_guid);
} 

$params['sidebar'] = elgg_view('videolist/sidebar', ['page' => $page_type]);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($params['title'], $body);