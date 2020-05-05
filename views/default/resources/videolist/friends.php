<?php

$page_type = elgg_extract('page_type', $vars);
$username = elgg_extract('username', $vars);

$user = get_user_by_username($username);
if (!$user) {
	forward('', '404');
}

$params = [
	'filter_context' => 'friends',
	'title' => elgg_echo('videolist:title:friends'),
];

$crumbs_title = $user->name;
elgg_push_breadcrumb($crumbs_title, "videolist/owner/{$user->username}");
elgg_push_breadcrumb(elgg_echo('friends'));

elgg_register_title_button('videolist', 'add', 'object', 'videolist');

$options = [
	'type' => 'object',
	'subtype' => 'videolist',
	'full_view' => false,
	'relationship' => 'friend',
	'relationship_guid' => $user->getGUID(),
	'relationship_join_on' => 'owner_guid',
	'no_results' => elgg_echo('videolist:none'),
	'preload_owners' => true,
	'preload_containers' => true,
];

$params['content'] = elgg_list_entities_from_relationship($options);

$params['sidebar'] = elgg_view('videolist/sidebar', ['page' => $page_type]);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($params['title'], $body);
