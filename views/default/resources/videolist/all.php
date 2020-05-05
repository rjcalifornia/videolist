<?php

$page_type = elgg_extract('page_type', $vars);

$params = get_shared_videolist();

$params['sidebar'] = elgg_view('videolist/sidebar', ['page' => $page_type]);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($params['title'], $body);