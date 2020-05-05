<?php
/**
 * Register the ElggBlog class for the object/blog subtype
 */

if (get_subtype_id('object', 'videolist')) {
	update_subtype('object', 'videolist', 'ElggVideolist');
} else {
	add_subtype('object', 'videolist', 'ElggVideolist');
}
