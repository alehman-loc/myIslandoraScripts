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
$pid = 'wyu:64914';
$object = islandora_object_load($pid);
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
//    $kid ->removeChild ($kid->firstChild);
//    $update = new DOMText('1995');
//    $kid->appendChild($update);
//    $kid->removeAttribute('keydate');
//    $kid->setAttribute('keyDate', 'yes');
//    $date = $kid->textContent;
//    echo $date;
    $modsDS_string = $modsDS_doc->saveXML();
//    print_r($modsDS_string);
}

    /*Re-Ingest New MODS File.
    $datastream->setContentFromString($modsDS_string);
    echo "New keyDate ingested for $pid via Tuque.";*/