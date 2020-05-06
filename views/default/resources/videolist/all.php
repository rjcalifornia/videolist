<?php

$page_type = elgg_extract('page_type', $vars);

$params = get_shared_videolist();

$params['sidebar'] = elgg_view('videolist/sidebar', ['page' => $page_type]);

$featured_params = get_featured_videolist();


$body = elgg_view_layout('content', $params);
$body.= elgg_view_layout('content', $featured_params);
//$body.=  $params['testing'];
/*$body .= elgg_echo('videolist:videos:recommended');
foreach ($featured_params['content'] as $value) {
    
    $video = get_entity($value['guid']);
    $body.= elgg_view_entity($video, array('full_view' => false));
    
    
}*/

echo elgg_view_page($params['title'], $body);
/*

foreach ($featured_params['content'] as $value) {
    echo '<ul class="elgg-list elgg-list-entity"><li class="elgg-item elgg-item-object elgg-item-object-file">';
    $video = get_entity($value['guid']);
    echo elgg_view_entity($video, array('full_view' => false));
    echo '</li></ul>';
}*/
//echo  $params['testing'];
