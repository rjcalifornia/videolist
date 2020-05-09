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
$videolist_type= get_input('video_type');

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
    if($videolist_type == "1")
    {
        
//parse_str( parse_url( $url, PHP_URL_QUERY ), $videoDetails );

   // $videoId = $videoDetails['v']; 
        
    //Using oembed protocol instead to get the video title. Storing the thumbnail URL for future purposes
    $xml = simplexml_load_file("http://www.youtube.com/oembed?url=". $url ."&format=xml");
    $title = $xml->title;
    $thumb_url = $xml->thumbnail_url;

    }
    
    if($videolist_type == "2")
    {
        $content = file_get_contents("https://vimeo.com/api/oembed.json?url=" . $url . '&width=480&height=360');
        ///parse_str($content, $ytarr);
        $jsondec = json_decode($content);
        $title = $jsondec->title;
    }


$videolist = new ElggVideolist();
$videolist->title = $title;
$videolist->video_url = $url;
$videolist->access_id = $access;
$videolist->comments_on = $comments;
$videolist->subtype = 'videolist';
$videolist->container_guid = $container;
$videolist->videolist_type = $videolist_type;
$videolist->owner_guid = elgg_get_logged_in_user_guid();
$videolist->status = 'published';
$videolist->thumbnail_url = $thumb_url;
$videolist_guid = $videolist->save();

// if the my_blog was saved, we want to display the new post
// otherwise, we want to register an error and forward back to the form
if ($videolist_guid) {
       elgg_create_river_item(array(
				'view' => 'river/object/videolist/create',
				'action_type' => 'create',
				'subject_guid' => $videolist->owner_guid,
				'object_guid' => $videolist->getGUID(),
			));
   system_message("Your video was shared.");
   forward($videolist->getURL());
} else {
   register_error("The video could not be saved.");
   forward(REFERER); // REFERER is a global variable that defines the previous page
}
}


