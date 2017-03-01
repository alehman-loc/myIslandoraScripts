/*
* Change object lables for 
* Objects in islandora:618 
* by amandarl@uwyo.edu
*/

$arrPIDS = array(870, 871, 872); 
$titleString = '1982_Equus_';

// Load user/connection/API 
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;
$api_a = $repository->api->a;

/*
* Iterate through pids and new labels
*/

foreach(array_keys($arrPIDS) as $key) {
	$preObject = 'islandora:' . $arrPIDS[$key];
	$titleConcat = $titleString . $arrPIDS[$key];
	$object = islandora_object_load($preObject);
		if (!$object) {
			echo "Object Not Loaded";
			return;
		}	
			$repository = $object->repository;
		
// Print/Purge $dsid if you want to
			$api_m = $repository->api->m;		
/*			$api_m->purgeDatastream($object, $dsid);
			echo "purged $dsid from $object \n";*/

//Ingest new datastream and update Lable
			$object->label = $titleConcat;
			echo "New label ingested for $preObject via Tuque. \n";
}