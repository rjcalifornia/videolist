<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function get_shared_videolist($container_guid = NULL) {

	$return = array();

	$return['filter_context'] = $container_guid ? 'mine' : 'all';

	$options = array(
		'type' => 'object',
		'subtype' => 'videolist',
		'full_view' => false,
            'list_type' => 'gallery',
		'no_results' => elgg_echo('elggpress:none'),
		'preload_owners' => true,
		'distinct' => false,
	);

	$current_user = elgg_get_logged_in_user_entity();

	if ($container_guid) {
		// access check for closed groups
		elgg_group_gatekeeper();

		$container = get_entity($container_guid);
		if ($container instanceof ElggGroup) {
		$options['container_guid'] = $container_guid;
		} else {
			$options['owner_guid'] = $container_guid;
		}
		$return['title'] = elgg_echo('videolist:title:user_videos', array($container->name));

		$crumbs_title = $container->name;
		elgg_push_breadcrumb($crumbs_title);

		if ($current_user && ($container_guid == $current_user->guid)) {
			$return['filter_context'] = 'mine';
		} else if (elgg_instanceof($container, 'group')) {
			$return['filter'] = false;
		} else {
			// do not show button or select a tab when viewing someone else's posts
			$return['filter_context'] = 'none';
		}
	} else {
		$options['preload_containers'] = true;
		$return['filter_context'] = 'all';
		$return['title'] = elgg_echo('videolist:all:videos');
		elgg_pop_breadcrumb();
		elgg_push_breadcrumb(elgg_echo('videolist:blogs'));
	}

	elgg_register_title_button('videolist', 'add', 'object', 'videolist');

	$return['content'] = elgg_list_entities($options);

	return $return;
}




/**
 * Get page components to edit/create a blog post.
 *
 * @param string  $page     'edit' or 'new'
 * @param int     $guid     GUID of blog post or container
 * @param int     $revision Annotation id for revision to edit (optional)
 * @return array
 */
function videolist_get_page_content_edit($page, $guid = 0, $revision = NULL) {
//Set the form as multipart so elgg can handle the file
    //$form_vars = array('enctype' => 'multipart/form-data');
	

	$return = array(
		'filter' => '',
	);

	$vars = array();
	$vars['id'] = 'videolist-post-edit';
	$vars['class'] = 'elgg-form-alt';
       // $vars['enctype'] = 'multipart/form-data';
	$sidebar = '';
	 
		elgg_push_breadcrumb(elgg_echo('videolist:add'));
		$body_vars = videolist_prepare_form_vars(null);

		$title = elgg_echo('videolist:add');
		$content = elgg_view_form('videolist/save', $vars, $body_vars);
	

	$return['title'] = $title;
	$return['content'] = $content;
	$return['sidebar'] = $sidebar;
	return $return;
}

/**
 * Pull together blog variables for the save form
 *
 * @param ElggBlog       $post
 * @param ElggAnnotation $revision
 * @return array
 */
function videolist_prepare_form_vars($post = NULL, $revision = NULL) {
    
    
	// input names => defaults
	$values = array(
		'title' => NULL,
		'description' => NULL,
                'video_url' => NULL,
		'status' => 'published',
		'access_id' => ACCESS_DEFAULT,
		'comments_on' => 'On',
		'excerpt' => NULL,
		'tags' => NULL,
		'container_guid' => NULL,
		'guid' => NULL,
		'draft_warning' => '',
	);

	if ($post) {
		foreach (array_keys($values) as $field) {
			if (isset($post->$field)) {
				$values[$field] = $post->$field;
			}
		}

		if ($post->status == 'draft') {
			$values['access_id'] = $post->future_access;
		}
	}

	if (elgg_is_sticky_form('videolist')) {
		$sticky_values = elgg_get_sticky_values('videolist');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}
	
	elgg_clear_sticky_form('videolist');

	if (!$post) {
		return $values;
	}

	

	
	return $values;
}


?>