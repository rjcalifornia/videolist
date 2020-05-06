<?php
/**
 * Blog sidebar
 *
 * @package Blog
 */

$page = elgg_extract('page', $vars);
$video_guid = elgg_extract('video_guid', $vars);
//echo 'test';
$guid = 36;
$share_url = "videolist/add/$guid";
	$share_link = elgg_view('output/url', array(
		'href' => $share_url,
		'text' => elgg_echo('videolist:add'),
		'class' => 'elgg-menu-content elgg-button elgg-button-action',
		//'confirm' => true,
	));
        
$share_label = elgg_echo('videolist:options');


$mark_recommended_url = "action/videolist/recommended?guid=$video_guid";
	$mark_recommended_link = elgg_view('output/url', array(
		'href' => $mark_recommended_url,
		'text' => elgg_echo('videolist:recommended:add'),
		'class' => 'elgg-menu-content elgg-button elgg-button-action',
		'confirm' => true,
	));
        
$video_details = get_entity($video_guid);
//echo $video_details->marked;
$recommended_label = elgg_echo('videolist:video:recommended');

        
echo <<<___HTML
<div class="elgg-menu elgg-menu-owner-block elgg-menu-owner-block-default">
	<p><label for="blog_title">$share_label</label></p>
	<p>$share_link</p>
</div>
</br>

 
___HTML;

if (elgg_is_admin_logged_in() && $video_details->marked != 'recommended'){   
echo <<<___HTML

<div class="elgg-menu elgg-menu-owner-block elgg-menu-owner-block-default">
	
	<p>$mark_recommended_link</p>
</div>
</br>
___HTML;
}

if($video_details->marked == 'recommended')
{
echo <<<___HTML
<div class="elgg-menu elgg-menu-owner-block elgg-menu-owner-block-default">
	<p><label for="blog_title" style='color:#4690D6;'>$recommended_label</label></p>
	
</div>
</br>

 
___HTML;
}

      
// fetch & display latest comments
if ($page != 'friends') {
	echo elgg_view('page/elements/comments_block', array(
		'subtypes' => 'videolist',
		'container_guid' => elgg_get_page_owner_guid(),
	));
}

 

if ($page != 'friends') {
	echo elgg_view('page/elements/tagcloud_block', array(
		'subtypes' => 'videolist',
		'container_guid' => elgg_get_page_owner_guid(),
	));
}
