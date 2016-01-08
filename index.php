<html>
 <head>
  <title>Simple Media Player</title>
  <link href="site.css" rel="stylesheet">
 </head>
 <body>
<?php

$root = "/var/www/html/";
$dir = $_GET["dir"];
if(strlen($dir)>1)
  $dir = $dir . DIRECTORY_SEPARATOR;

$full = $root . $dir;
$thisFile = $root . "index.php";
$css = $root . "site.css";

$dh  = opendir($full);
while (false !== ($filename = readdir($dh))) {
    $files[] = $filename;
}

sort($files);

foreach($files as $f)
{
   $partFile = $dir . $f;
   $fullFile = $root . $dir . $f;

   if (strcmp($fullFile, $thisFile) == 0 ||
       strcmp($fullFile, $css) == 0 || 
       strcmp($f,".") == 0 || 
       (strcmp($f,"..") == 0 && strcmp($root,$full) == 0 ) )   
      continue;

   if(is_dir($fullFile))
   {  
      $end = str_replace($full, "", $partFile);
      if(strcmp($f,"..") == 0)
        $end = str_replace($root,"", dirname($full));
      if(strcmp($end . DIRECTORY_SEPARATOR, $root) == 0)
        $end = "";

      printf("<div class='parent' ><a class='directory' href='index.php?dir=" . $end . "' >%s</a></div>",  $f);
      printnl();
   }
   else
   {
      $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $f); 
      $path = $dir . DIRECTORY_SEPARATOR . $f;
      printf("<div class='parent' ><a class='file' href='%s' >%s</a></div>", $path, $withoutExt);
      printnl();
   }
}


function printnl()
{
   printf("<br/>");
}
?>
 </body>
</html>
