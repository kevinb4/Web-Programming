<?php

include("class_resize.php");

$resize = new ImageResize();

$resize->resize("penguins.jpg", "output_file.jpg");

?>