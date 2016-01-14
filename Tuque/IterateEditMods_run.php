$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;
$api_a = $repository->api->a;
$arrPIDS = array(3, 5, 6); 
$arrDates = array(Date, 1905, 1906-01);
foreach(array_keys($arrPIDS) as $key) { 
	$preObject = 'islandora:' . $arrPIDS[$key]; 
	$object = islandora_object_load($preObject);
	$dsid = 'MODS';
	$datastream  = islandora_datastream_load('MODS', $object);
	$modsDS = $datastream->getContent('');
	$modsDS_doc = new DOMDocument();
	$modsDS_doc->loadXML($modsDS);
	$modsDS_doc->saveXML();
	$dateText = $arrDates[$key];
	$node = $modsDS_doc->getElementsByTagName('originInfo')->item(0);
	$newDate = $modsDS_doc->createElement("mods:dateCreated", "$dateText");
	$newDate->setAttribute('keyDate', 'yes');
	$node->appendChild($newDate);
	foreach ($node->childNodes as $p) {
		echo $preObject."Nodes ".$p->nodeName." ".$p->nodeValue.'<br>';
	}
	
}
