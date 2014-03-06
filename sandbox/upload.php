<?php
$file='myImage.jpeg';
$handle = fopen($file,'w');
$data = explode(",", $_POST['imgthumb']);
fwrite($handle,base64_decode($data[1]));
fclose($handle);
echo "<img src='{$_POST['imgthumb']}'>";
?>



