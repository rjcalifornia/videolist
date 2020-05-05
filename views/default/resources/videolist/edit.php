<?php

elgg_gatekeeper();

$page_type = elgg_extract('page_type', $vars);
$guid = elgg_extract('guid', $vars);
$revision = elgg_extract('revision', $vars);
$simple = elgg_extract('simple', $vars);

$params = videolist_get_page_content_edit('edit', $guid, $revision, $simple);

if (isset($params['sidebar'])) {
	$params['sidebar'] .= elgg_view('videolist/sidebar', ['page' => $page_type]);
} else {
	$params['sidebar'] = elgg_view('videolist/sidebar', ['page' => $page_type]);
}

$body = elgg_view_layout('content', $params);

echo elgg_view_page($params['title'], $body);
