<?php
$texto=" califragilístico     ";
echo "\r\n";
echo strlen($texto);
echo "\r\n";
echo trim($texto);
echo "\r\n";
echo strtoupper($texto);
echo "\r\n";
echo "\n".str_replace("\r\ncali","copon",$texto)."\n";
echo "\r\n";
?>