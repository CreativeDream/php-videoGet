php-videoGet
============

Simple PHP script wich will get information about video by URL(from OpenGraph meta tags, like facebook). Now you can get videos Information from Youtube, Vimeo, Vkontakte, Coub, DailyMotion, MetaCafe, Rutube and many others...

__<a href="http://creativedream.net/plugins/php-video-get/" target="_blank">Demo Page</a>__

Usage
-------
The class is called 'videoGet', and function is called 'getVideoData'. So just call it ;)
~~~ php
$url = "http://www.youtube.com/watch?v=T6DJcgm3wNY";
$get = array('title','description','image','video','url','site_name');
	
$video = new videoGet($url, $get);
$video = $video->getVideoData();
~~~~

License
-------
> Licensed under <a href="http://opensource.org/licenses/MIT">MIT license</a>.
