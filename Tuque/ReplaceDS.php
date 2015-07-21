/*
* Delete/Replace an existing 
* Datastream
* Remove all double quotes from 
* replacement string.
* by amandarl@uwyo.edu
*/

$dsid = 'MODS';
$arrPIDS = array(98904, 98905); 
$titleString = '[Page of] The Dynamo - July 1917';

$newString = "<mods xmlns='http://www.loc.gov/mods/v3' xmlns:mods='http://www.loc.gov/mods/v3' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'>
  <titleInfo>
    <title>$titleString</title>
  </titleInfo>
  <abstract>Please see issue for bibliographic information.</abstract>
  <relatedItem type='host'>
	<titleInfo><title>The Dynamo</title></titleInfo>
  </relatedItem>
</mods>";

// Load user/connection/API 
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;
$api_a = $repository->api->a;

//Iterate through pids and datastream replacements
foreach(array_keys($arrPIDS) as $key) {
	$preObject = 'wyu:' . $arrPIDS[$key];
	$object = islandora_object_load($preObject);
		if (!$object) {
			echo "Object Not Loaded";
			return;
		}	
			$repository = $object->repository;
			
//Purge $dsid if you want to
			//$api_m = $repository->api->m;
		//	$api_m->purgeDatastream($object, $dsid);
		//	echo "purged $dsid from $object \n";

//Ingest new datastream and update Lable
			$datastream = $object->constructDatastream($dsid);
			$datastream->label = $dsid;
			$datastream->mimetype = 'text/xml';
			$datastream->setContentFromString($newString);
			$object->ingestDatastream($datastream);
			$object->label = $titleString;
			echo "New $dsid ingested for $preObject via Tuque. \n";
}