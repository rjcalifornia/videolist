<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$videolist = get_entity($vars['videolist']->getGUID());
elgg_extend_view('page/elements/head', 'extras/scripts');

    if($videolist->videolist_type == '2')
    {
        
        //echo $videolist->video_url;
        $content = file_get_contents("https://vimeo.com/api/oembed.json?url=" . $videolist->video_url . '&width=480&height=320');
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
    
    width="480" height="320"
    data-setup='{ "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "$videolist->video_url"}] }'
  >
  </video>
  </center>
  </br>
___HTML;
    }
    
    echo $body;
?>
