<?php
/**
 * Delete videolist entity
 *
 * @package Videolist
 */

$videolist_guid = get_input('guid');
$videolist = get_entity($videolist_guid);

if (elgg_instanceof($videolist, 'object', 'videolist') && $videolist->canEdit()) {
	$container = get_entity($videolist->container_guid);
	if ($videolist->delete()) {
		system_message(elgg_echo('videolist:message:deleted_post'));
		if (elgg_instanceof($container, 'group')) {
			forward("videolist/group/$container->guid/all");
		} else {
			forward("videolist/owner/$container->username");
		}
	} else {
		register_error(elgg_echo('videolist:error:cannot_delete_post'));
	}
} else {
	register_error(elgg_echo('videolist:error:post_not_found'));
}

forward(REFERER);