<?php

$xml = new DomDocument('1.0');

$local=$xml->createElement("local");
$xml->appendChild($local);

echo "<xmp>" . $xml->saveXML()."</xmp>";

?>