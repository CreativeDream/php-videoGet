<?php
   # ========================================================================#
   #  
   #  Title      VideoGet Class
   #  Author:    CreativeDream.net
   #  Version:	 1.0
   #  Date:      22-Jun-2013
   #  Purpose:   Get information about video by URL in OpenGraph meta tags or by <iframe>, <object> elements
   #  Requires : Requires PHP 4 >= 4.1.0.
   #  Usage Example:
   #                  include("classes/videoget.Class.php");
   #                  $video = new videoGet( string $url, array $get );
   #                           $url - URL from website with video, website must have OpenGraph meta tags; $url can also be <iframe> or <object> LINE: 46
   #                           $get - array with OpenGraph meta tags property value og:(name)
   #
   # ========================================================================#
   
   class videoGet {
	  public $get = array('title','description','image','video','url','site_name'); //what we should get
	  public $defaultImg = "./images/icons/defaultImg.jpg"; //default thumbnail, if original is empty
	  //DO NOT CHANGE INFORMATION UNDER!
	  private $video;
	  private $VideoData = array();
	  
	  function __construct($url){
			if(!filter_var($url, FILTER_VALIDATE_URL) && strpos($url, "<iframe") === false && strpos($url, "<object") === false){return FALSE;}
			$this->video = $url;
	  }
	  
	  private function pasreVideoURL(){
		 $this->video = (substr($this->video,-2) == '#!')?substr($this->video,0,-2):$this->video;
		 switch ($this->video){
		   case strpos($this->video, "<iframe") !== false:
		   case strpos($this->video, "<object") !== false:
			   $this->elementVideoGet();
		   break;
		 }
		 $this->VideoData();
	  }
	  
	  private function elementVideoGet(){
		  $element = $this->video;
		  $url = preg_match('/src="(.*?)"/',$this->video,$matches); //src data from <iframe> object
		  if($url == FALSE){return FALSE;}
		  
		  //make for custom website
		  if(strstr($matches[1], "youtube.com")){
			  $this->video = 'http://www.youtube.com/watch?v=' . substr(strrchr($matches[1], "/"),1);
			  return true;
		  }
		  if(strstr($matches[1], "vimeo.com")){
			  $this->video = 'https://vimeo.com/' . substr(strrchr($matches[1], "/"),1);
			  return true;
		  }
		  /*
		  if(strstr($matches[1], "custom website")){
			  $this->video = 'custom website url';
			  return true;
		  }
		  */
		  
		  foreach($this->get as $tag){
			  $this->VideoData[$tag] = '';
		  }
		  $this->VideoData['image'] = $this->defaultImg;
		  $this->VideoData['video'] = $matches[1];
		  return;
	  }
	  
	  private function VideoData(){
		  if(!empty($this->VideoData)){return;}
		  $url = $this->video;
		  $dom = new DOMDocument;
		  @$dom->loadHtmlFile($url);
		  $xpath = new DOMXPath($dom);
		  foreach($this->get as $tag){
			  $element = $xpath->query('//meta[@property="og:'. $tag .'"]');
			  $this->VideoData[$tag] = ($element->length > 0)?$element->item(0)->getAttribute('content'):'';
		  }
		  if(in_array('image',$this->get) && empty($this->VideoData['image'])){
			  $this->VideoData['image'] = $this->defaultImg;
		  }
		  if(in_array('video',$this->get) && empty($this->VideoData['video'])){
			  $this->VideoData = FALSE;
		  }elseif(in_array('video',$this->get) && !empty($this->VideoData['video'])){
  		      $this->VideoData['video'] = str_replace('/v/','/embed/',$this->VideoData['video']);
		  }
		  $dom = NULL;
	  }
	  public function getVideoData(){
		  $this->pasreVideoURL();
		  return $this->VideoData;
	  }
   }
?>
