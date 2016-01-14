/*
 * Edit and Replace a MODS file. 
 * 
 * 
 */

//Load Repository
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;

//Load API with an object 
$api_a = $repository->api->a;

// Comma separated array of pids w/ds.
$arrPIDS = array(3, 5, 6); 
$arrDates = array(Date, 1905, 1906-01);

foreach(array_keys($arrPIDS) as $key) { 
	$preObject = 'islandora:' . $arrPIDS[$key]; //verify namespace
  $object = islandora_object_load($preObject);
  if (!$object) {
    echo "Object Not Loaded";
    return;
  }
  $repository = $object->repository;
	
  //Get MODS Datastream
  $dsid = 'MODS';
  $datastream  = islandora_datastream_load('MODS', $object);
  if (!$datastream) {
    echo "Datastream Not Loaded";
    return;
  } //Edit MODS Content
    $modsDS = $datastream->getContent('');
    $modsDS_doc = new DOMDocument();
    $modsDS_doc->loadXML($modsDS);
    $modsDS_doc->saveXML();
    libxml_use_internal_errors(true);
    if (!$modsDS_doc) {
      echo "Failed loading XML: ";
      foreach(libxml_get_errors() as $error) {
        echo "<br>", $error->message;
      }
    } else {
      $dateText = $arrDates[$key];
      $node = $modsDS_doc->getElementsByTagName('originInfo')->item(0);
      //$newDate = $modsDS_doc->createElement("dateCreated", "$dateText");
      //$newDate->setAttribute('keyDate', 'yes');
      //$node->appendChild($newDate);
      foreach ($node->childNodes as $p) {
		    echo $preObject."Nodes ".$p->nodeName." ".$p->nodeValue.'<br>';
	     }
     
	    $modsDS_string = $modsDS_doc->saveXML();
	    print_r($modsDS_string);
			}

			/*Re-Ingest New MODS File.*/
			$datastream_id = "MODS";
			$new_datastream = $object->constructDatastream($datastream_id);
			$datastream->setContentFromString($modsDS_string);
			echo "New Date ingested for $preObject via Tuque. \n";
	}