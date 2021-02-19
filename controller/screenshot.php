<?php 
$image = $_POST['image'];

//$location = "C:\wamp64\www\DIPSW-P2\upload";

$location = "../upload/diagmin/";

$image_parts = explode(";base64,", $image);

$image_base64 = base64_decode($image_parts[1]);

//$filename = "screenshot_".uniqid().'.jpg';
$filename = $_POST['diag'].'.jpg';

$file = $location . $filename;

file_put_contents($file, $image_base64);