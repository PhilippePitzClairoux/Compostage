<?php

$xml = new DomDocument('1.0');
$xml->formatOutput = true;

$local=$xml->createElement("local");
$xml->appendChild($local);

//for (every bed in sent data)

	$bed=$xml->createElement("bed");
	//$bed->setAttribute("id",1); // id given
	$local->appendChild($bed);

	//for (every zone in sent data)
	
		$zone=$xml->createElement("zone");
		$bed->appendChild($zone);
									//GIVEN ID in date
		$id=$xml->createElement("id","1");
		$zone->appendChild($id);
									//GIVEN name in date
		$name=$xml->createElement("name","Zone A");
		$zone->appendChild($name);

		//for (every Raspberry in sent data)
		$raspberry=$xml->createElement("raspberry");
		$zone->appendChild($raspberry);

		$sensors=$xml->createElement("sensors");
		$raspberry->appendChild($sensors);

		//TO CHANGE will get name from given data
		$sensorType = ["temp", "humidity", "ph"];
		for ($i=0; $i < 3; $i++) { 
			$sensor=$xml->createElement($sensorType[$i]);
			$sensors->appendChild($sensor);

			$title=$xml->createElement($sensorType[$i], $sensorType[$i]);
			$sensor->appendChild($title);

			//for (every value from given sensor)
				$value=$xml->createElement("value", "22");
				$time=$xml->createElement("time", "22/22/22");
				$value->appendChild($time);
				$sensor->appendChild($value);
		}
echo "<xmp>" . $xml->saveXML()."</xmp>";
?>