/*
 * Edit and Replace a MODS file. 
 *
 *TODO - CHECK Iteration and Edit Element from date to Rights. 
 */

//Load Repository
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;

//Load API with an object - edit to iterate PIDS?
$api_a = $repository->api->a;

$pids = '112471,112666,112720';

// vars
$items = array();

if (isset($pids)) {
		drush_print($pids);
		$tempPids = explode(',', $pids);

		if (is_numeric($pids)) {
				array_push($items, $pids);
		}
		else if (count($tempPids) > 1) {
				$items = $tempPids;
		}
		else if (preg_match('/(\d+)(-)(\d+)/', $pids)) {
				echo 'this is a range of pids.' . PHP_EOL;
				$start =  preg_replace('/(\d+)(-)(\d+)/', '${1}', $pids);
				$end =  preg_replace('/(\d+)(-)(\d+)/', '${3}', $pids);
				echo 'start: ' . $start . ' end: ' . $end . PHP_EOL;
				for ($n = $start; $n <= $end; $n++) {
						array_push($items, $n);
				}
		}
		else {
				drush_print('ERROR: must include either comma-delimited list or range of numbers.');
				return;
		}
}
else {
		drush_print('ERROR: must include either comma-delimited list or range of numbers.');
		return;
}
		
//Iterate through Objects.
foreach($items as $item) {
  $preObject = 'wyu:' . $pid;
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
    $modsDS_doc = DOMDocument::loadXML($modsDS);
    // $modsDS_doc->saveXML();
    libxml_use_internal_errors(true);
    if (!$modsDS_doc) {
      echo "Failed loading XML: ";
      foreach(libxml_get_errors() as $error) {
        echo "<br>", $error->message;
      }
    } else {
		
		
		//TODO - change over to Rights
		
		
      $node = $modsDS_doc->getElementsByTagName('originInfo')->item(0);
      $kid = $node->getElementsByTagName('dateCreated')->item(0);
//      $node->removeChild($kid);            $kid = $node->getElementsByTagName('dateCreated')->item(0);
/*	    $kid ->removeChild ($kid->firstChild);
            $update = new DOMText('2009');
	    $kid->appendChild($update);
	    $kid->removeAttribute('keydate');
	    $kid->setAttribute('keyDate', 'yes'); */
	    $date = $kid->textContent;
	    echo $preObject, " Date: ", $date, "\n";
	    $modsDS_string = $modsDS_doc->saveXML();
//	    print_r($modsDS_string);
	}

			/*Re-Ingest New MODS File.
			$datastream->setContentFromString($modsDS_string);
			echo "New keyDate ingested for $pid via Tuque. \n";*/
	}