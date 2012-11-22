<?php
header("Content-Disposition: attachment; filename=".$_GET["name"].".csv");
$struct[0] = array("Date","Time","Title","Description");
$fields = $struct[$_GET["type"]];
 
for ($i=0;$i<count($fields);$i++)  
    echo '"'.str_replace('"','""', $fields[$i]).'",';
echo "\n";
 
$filename = "database/cal".$_GET["id"]."data.txt";
$fd = fopen ($filename, "r");
$contents = @fread ($fd, filesize($filename));
fclose ($fd);
$items = explode("\n*-*\n", $contents); 
for ($i=0;$i<count($items);$i++) 
{
   $subitems = split ("\n", $items[$i]);
   for ($j=0;$j<3;$j++)
       echo '"'.str_replace('"','""', $subitems[$j]).'",'; 
   $desc = "";    
   for ($j=3;$j<count($subitems);$j++)
       $desc .= $subitems[$j];
   echo '"'.str_replace('"','""', $desc).'",';     
   echo "\n";    
}
?>