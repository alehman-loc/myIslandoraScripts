/*
 * Edit and Replace a MODS file. 
 * Comment out Either Iterate or Array.
 * 
 */

//Load Repository
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;

//Load API with an object 
$api_a = $repository->api->a;

/* //Iterate through Objects to purge them.
$startPID = '81101';
$endPID = '81103';
for($pid=$startPID; $pid<=$endPID; $pid++) { */
// OR Comma separated array of pids w/ds.
$arrPIDS = array(108662); 
foreach ($arrPIDS as&$pid) {

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
      $node = $modsDS_doc->getElementsByTagName('originInfo')->item(0);
      $kid = $node->getElementsByTagName('dateCreated')->item(0);
//      $node->removeChild($kid);     
/*	    $kid ->removeChild ($kid->firstChild);
            $update = new DOMText('2009');
	    $kid->appendChild($update); */
	    $kid->removeAttribute('keydate');
	    $kid->setAttribute('keyDate', 'yes');
	    $date = $kid->textContent;
	    echo $preObject, " Date: ", $date, "\n";
	    $modsDS_string = $modsDS_doc->saveXML();
	    print_r($modsDS_string);
			}

			/*Re-Ingest New MODS File.
//			$datastream_id = "MODS";
//			$new_datastream = $fedora_object->constructDatastream($datastream_id);
			$datastream->setContentFromString($modsDS_string);
			echo "New keyDate ingested for $pid via Tuque. \n";*/
	}