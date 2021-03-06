<?php
/**
 * View for blog objects
 *
 * @package Blog
 */

$full = elgg_extract('full_view', $vars, FALSE);
$videolist = elgg_extract('entity', $vars, FALSE);

if (!videolist) {
	return TRUE;
}

$owner = $videolist->getOwnerEntity();
$categories = elgg_view('output/categories', $vars);
$excerpt = $videolist->excerpt;
if (!$excerpt) {
	$excerpt = elgg_get_excerpt($videolist->description);
}

$owner_icon = elgg_view_entity_icon($owner, 'tiny');

$vars['owner_url'] = "videolist/owner/$owner->username";
$by_line = elgg_view('page/elements/by_line', $vars);

// The "on" status changes for comments, so best to check for !Off
if ($videolist->comments_on != 'Off') {
	$comments_count = $videolist->countComments();
	//only display if there are commments
	if ($comments_count != 0) {
		$text = elgg_echo("comments") . " ($comments_count)";
		$comments_link = elgg_view('output/url', array(
			'href' => $videolist->getURL() . '#comments',
			'text' => $text,
			'is_trusted' => true,
		));
	} else {
		$comments_link = '';
	}
} else {
	$comments_link = '';
}

$subtitle = "$by_line $comments_link $categories";

$metadata = '';
if (!elgg_in_context('widgets')) {
	// only show entity menu outside of widgets
	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'videolist',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
}

if ($full) {
    
   

//echo $videolist->videolist_type;
    
    if($videolist->videolist_type == '2')
    {
        
        //echo $videolist->video_url;
        $content = file_get_contents("https://vimeo.com/api/oembed.json?url=" . $videolist->video_url . '&width=620&height=480');
        ///parse_str($content, $ytarr);
        $jsondec = json_decode($content);
$body = 
<<<___HTML
        <center>
        $jsondec->html;
        </center>


___HTML;

  
    }
    else
    {
$body = <<<___HTML
<center>
<video
    id="vid1"
    class="video-js vjs-default-skin"
    controls
    
    width="640" height="480"
    data-setup='{ "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "$videolist->video_url"}] }'
  >
  </video>
  </center>
___HTML;
    }


	$params = array(
		'entity' => $videolist,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view('object/elements/full', array(
		'entity' => $videolist,
		'summary' => $summary,
		'icon' => $owner_icon,
                'test' => $test,
		'body' => $body,
	));

} elseif (elgg_in_context('gallery')) {
	echo '<div class="file-gallery-item">';
	echo "<h3>" . $videolist->title . "</h3>";
	echo elgg_view_entity_icon($videolist, 'medium');
        //echo '<img src="'. $videolist->thumbnail_url .'" alt="logo"  width="100"/>';
	echo "<p class='subtitle'>$owner_link $date</p>";
	echo '</div>';
}
else {
	// brief view

	$params = array(
		'entity' => $videolist,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $excerpt,
		'icon' => $owner_icon,
	);
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params);
        echo elgg_view('extras/featured', array('videolist'=>$videolist));

}
