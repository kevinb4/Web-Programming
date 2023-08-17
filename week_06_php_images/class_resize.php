<?php

class ImageResize{

/* constructor */
function ImageResize() 
	{
      	
  	}

/* resize an image and output the new file */
function resize($inputfile, $outputfile)
	{
	// Get new sizes
	list($width, $height) = getimagesize($inputfile);

	$aspect= 150/$width;
	$newwidth = 150;
	$newheight = $height * $aspect;

	// Load
	$thumb = imagecreatetruecolor($newwidth, $newheight);
	$source = imagecreatefromjpeg($inputfile);

	// Resize
	imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	// Output
	imagejpeg($thumb, $outputfile, 80);
	}

}

?>