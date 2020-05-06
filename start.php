<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// register an initializer
elgg_register_event_handler('init', 'system', 'videolist_init');

function videolist_init() {
    // register the save action
    
    
    elgg_register_library('elgg:videolist', __DIR__ . '/lib/videolist.php');

    // register the page handler
    elgg_register_page_handler('videolist', 'videolist_page_handler');
    
    elgg_register_entity_type('object', 'videolist');
    
    
    // add a site navigation item
	$item = new ElggMenuItem('videolist', elgg_echo('videolist:videos'), 'videolist/all');
	elgg_register_menu_item('site', $item);


    // register a hook handler to override urls
    elgg_register_plugin_hook_handler('entity:url', 'object', 'videolist_set_url');
    
    elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'videolist_set_icon_url');
    elgg_register_action("videolist/save", __DIR__ . "/actions/videolist/save.php");
    elgg_register_action("videolist/delete", __DIR__ . "/actions/videolist/delete.php");
    elgg_register_action("videolist/recommended", __DIR__ . "/actions/videolist/recommended.php");
    
    // Add group option
    add_group_tool_option('videolist', elgg_echo('videolist:enablegroup'), true);
    elgg_extend_view('groups/tool_latest', 'videolist/group_module');
}


function videolist_set_url($hook, $type, $url, $params) {
    $entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'videolist')) {
		$friendly_title = elgg_get_friendly_title($entity->title);
		return "videolist/view/{$entity->guid}/$friendly_title";
	}
}

function videolist_page_handler($page) {
    
    elgg_load_library('elgg:videolist');
    
    elgg_push_breadcrumb(elgg_echo('videolist:videos'), 'videolist/all');
    
    $page_type = elgg_extract(0, $page, 'all');
	$resource_vars = [
		'page_type' => $page_type,
	];

	switch ($page_type) {
		case 'owner':
			$resource_vars['username'] = elgg_extract(1, $page);
			
			echo elgg_view_resource('videolist/owner', $resource_vars);
			break;
		case 'friends':
			$resource_vars['username'] = elgg_extract(1, $page);
			
			echo elgg_view_resource('videolist/friends', $resource_vars);
			break;
		 
		case 'view':
			$resource_vars['guid'] = elgg_extract(1, $page);
			
			echo elgg_view_resource('videolist/view', $resource_vars);
			break;
		case 'add':
			$resource_vars['guid'] = elgg_extract(1, $page);
			
			echo elgg_view_resource('videolist/add', $resource_vars);
			break;
		 
		case 'group':
			$resource_vars['group_guid'] = elgg_extract(1, $page);
			$resource_vars['subpage'] = elgg_extract(2, $page);
			$resource_vars['lower'] = elgg_extract(3, $page);
			$resource_vars['upper'] = elgg_extract(4, $page);
			
			echo elgg_view_resource('videolist/group', $resource_vars);
			break;
		case 'all':
			echo elgg_view_resource('videolist/all', $resource_vars);
			break;
                    
                case 'edit':
			$resource_vars['guid'] = elgg_extract(1, $page);
			$resource_vars['revision'] = elgg_extract(2, $page);
			$resource_vars['simple'] = 1;
			echo elgg_view_resource('videolist/edit', $resource_vars);
			break;
		default:
			return false;
	}

	return true;
}

function videolist_set_icon_url($hook, $type, $url, $params) {
	$file = $params['entity'];
	$size = elgg_extract('size', $params, 'large');
	if (elgg_instanceof($file, 'object', 'videolist')) {
		// thumbnails get first priority
		$thumbnail = $file->getIcon($size);
		$thumb_url = elgg_get_inline_url($thumbnail, true);
		if ($thumb_url) {
			return $thumb_url;
		}

		$mapping = array(
			
			'audio' => 'music',
			
			'video' => 'video',
		);

		$mime = 'video';
		if ($mime) {
			$base_type = substr($mime, 0, strpos($mime, '/'));
		} else {
			$mime = 'none';
			$base_type = 'none';
		}

		if (isset($mapping[$mime])) {
			$type = $mapping[$mime];
		} elseif (isset($mapping[$base_type])) {
			$type = $mapping[$base_type];
		} else {
			$type = 'general';
		}

		if ($size == 'large') {
			$ext = '_lrg';
		} else {
			$ext = '';
		}

		$url = elgg_get_simplecache_url("file/icons/{$type}{$ext}.gif");
		$url = elgg_trigger_plugin_hook('file:icon:url', 'override', $params, $url);
		return $url;
	}
}
