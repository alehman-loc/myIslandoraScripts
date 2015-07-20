/*
 * Edit and Replace a MODS file. 
 *
 * 
 */

//Load Repository
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;

//Load API with an object - edit to iterate PIDS?
$api_a = $repository->api->a;

//accept range or comma-list of pids

$pids = (64913, 64931)
$items = array();

if (isset($pids)) {
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
				echo'ERROR: must include either comma-delimited list or range of numbers.';
				return;
		}
}
else {
		echo'ERROR: must include either comma-delimited list or range of numbers.';
		return;
}

//Iterate through Objects to purge them.
foreach($items as $item) {


  $preObject = 'wyu:' . $item;
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
      $node = $modsDS_doc->getElementsByTagName('originInfo')->item(0);
      $kid = $node->getElementsByTagName('dateCreated')->item(0);
//      $kid->removeAttribute('keydate');
//      $kid->setAttribute('keyDate', 'yes');
      $modsDS_string = $modsDS_doc->saveXML();
      $date = $kid->textContent;
      echo $preObject, $date;
//      print_r($modsDS_string);
  }

    //Re-Ingest New MODS File.
//    $datastream->setContentFromString($modsDS_string);
		//Uncomment if new datastream
    //$object->ingestDatastream($datastream);
//    echo "New keyDate ingested for $pid via Tuque.";
	}