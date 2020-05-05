<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$url = get_input('url');
$access = get_input('access_id');
$comments = get_input('comments_on');
$guid = get_input('guid');
$edited_title = get_input('title');
$container = (int)get_input('container_guid');

//$videoDetails = array();

if ($guid) {
	$entity = get_entity($guid);
        $entity->title = $edited_title;
        $entity->access_id = $access;
        $entity->comments_on = $comments;
        $videolist_guid = $entity->save();
        if ($videolist_guid) {
   system_message("Your video details were saved.");
   forward($entity->getURL());
} else {
   register_error("The video could not be saved.");
   forward(REFERER); // REFERER is a global variable that defines the previous page
}
}
else{
//$url = "http://www.youtube.com/watch?v=C4kxS1ksqtw&feature=relate";
parse_str( parse_url( $url, PHP_URL_QUERY ), $videoDetails );
$videoId = $videoDetails['v']; 


$content = file_get_contents("http://youtube.com/get_video_info?video_id=" . $videoId);
parse_str($content, $ytarr);
$jsondec = json_decode($ytarr['player_response'],true); 
$title = $jsondec['videoDetails']['title'];
//$title = $ytarr['title'];

$videolist = new ElggVideolist();
$videolist->title = $title;
$videolist->video_url = $url;
$videolist->access_id = $access;
$videolist->comments_on = $comments;
$videolist->subtype = 'videolist';
$videolist->container_guid = $container;
$videolist->owner_guid = elgg_get_logged_in_user_guid();
$videolist->status = 'published';

$videolist_guid = $videolist->save();

// if the my_blog was saved, we want to display the new post
// otherwise, we want to register an error and forward back to the form
if ($videolist_guid) {
   system_message("Your video was shared.");
   forward($videolist->getURL());
} else {
   register_error("The video could not be saved.");
   forward(REFERER); // REFERER is a global variable that defines the previous page
}
}


