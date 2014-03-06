<?php
$file = md5(uniqid()).'.jpg';
$handle = fopen($file,'w');
$data = explode(",", $_POST['imgthumb']);
fwrite($handle,base64_decode($data[1]));
fclose($handle);
echo "<img src='{$_POST['imgthumb']}'>";
?>



