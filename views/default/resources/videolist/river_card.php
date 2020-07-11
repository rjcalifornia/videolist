<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
echo elgg_view('videolist/css');

$object = $vars['object'];
$siteName = elgg_echo('videolist:brand');
$siteUrl = elgg_get_site_url();
$videoTitle = $object->title;
$videoUrl = $object->getUrl();


$cardPreview = 
<<<___HTML
<div class="card article" style="background-color: #313945;     min-width: 200px;
    padding: 40px; color: #464646;
    font-size: 16px;
    position: relative;
    width: auto;
    z-index: 1;">
    <div class="videolist-provider">
        <a class="videolist-provider-name" href="$siteUrl">
           <span class="videolist-head-river-elgg-icon fa fa-play-circle-o"></span> $siteName
        </a>
    </div>
    
<div class="art-bd">
<center>
<a href="$videoUrl">
<span class="videolist-river-elgg-icon fa fa-youtube-play"></span>
</a>
</center>
</div>
<div class="txt-bd">
<h2 class="title">
<a class="videolist-title" href="$videoUrl">
$videoTitle
</a>
    </h2>
    </br>
     <a class="videolist-action" href="$videoUrl">View video... &gt;</a>
        </div>
   
</div>
</br>
___HTML;

echo $cardPreview;
