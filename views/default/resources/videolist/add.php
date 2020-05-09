<?php

elgg_gatekeeper();

$page_type = elgg_extract('page_type', $vars);
$guid = (int) elgg_extract('guid', $vars);
elgg_require_js("videolist/video_validation");
elgg_entity_gatekeeper($guid);
elgg_group_gatekeeper(true, $guid);

$container = get_entity($guid);

// Make sure user has permissions to add to container
if (!$container->canWriteToContainer(0, 'object', 'videolist')) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}
//elgg_extend_view('page/elements/head', 'extras/validation');


$params = videolist_get_page_content_edit('add', $guid, null, 0);

if (isset($params['sidebar'])) {
	$params['sidebar'] .= elgg_view('videolist/sidebar', ['page' => $page_type]);
} else {
	$params['sidebar'] = elgg_view('videolist/sidebar', ['page' => $page_type]);
}

$body = elgg_view_layout('content', $params);

echo elgg_view_page($params['title'], $body);

