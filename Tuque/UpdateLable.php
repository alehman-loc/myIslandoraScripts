/*
 * Take Title from MODS file into Label
 * Comment out Either Iterate or Array.
 * 
 */

//Load Repository
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;

//Load API with an object 
$api_a = $repository->api->a;

// OR Comma separated array of pids w/ds.
$arrPIDS = array(870, 871, 872); 
foreach ($arrPIDS as&$pid) {

  $preObject = 'islandora:' . $pid;
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
      $node = $modsDS_doc->getElementsByTagName('titleInfo')->item(0);
      $kid = $node->getElementsByTagName('title')->item(0);
		
		$count = 0;
		
	    $title = $kid.textContent;
	    //echo $object, " Title: ", $title, "\n";
	    $object->label = $title;
			}
		}