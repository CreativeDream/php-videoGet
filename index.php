<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Get Video information by URL</title>
</head>

<body>

  <?php
    include("videoget.Class.php");
	
    $url = "http://www.youtube.com/watch?v=T6DJcgm3wNY";
	#$url = '<iframe width="560" height="315" src="http://www.youtube.com/embed/T6DJcgm3wNY?rel=0" frameborder="0" allowfullscreen></iframe>';
    $get = array('title','description','image','video','url','site_name');
	
    $video = new videoGet($url, $get);
	
	$video = $video->getVideoData();
	
	if($video){
		echo "<pre>";
		print_r($video);
		echo "</pre>";
	}else{
		echo "<p>Video link in unavailable!</p>";
	}
  ?>
  
</body>
</html>
