<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$videolist = get_entity($vars['videolist']->getGUID());


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
        $xml = simplexml_load_file("http://www.youtube.com/oembed?url=". $videolist->video_url ."&format=xml");
//        $body = $xml->html;
   
$body = <<<___HTML
<center>
$xml->html;
  </center>
  </br>
___HTML;

    }
    
    echo $body;
?>
