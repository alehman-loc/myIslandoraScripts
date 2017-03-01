/*
* Change object lables for 
* Objects in  
* by amandarl@uwyo.edu
*/

$arrPIDS = array(73585, 74688, 75017, 75924, 75334, 73946, 77330, 76826, 77630); 

// Load user/connection/API 
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;
$api_a = $repository->api->a;

/*
* Iterate through pids and new labels
*/

$year = 1926;
foreach(array_keys($arrPIDS) as $key) {
	$preObject = 'wyu:' . $arrPIDS[$key];
	$object = islandora_object_load($preObject);
		if (!$object) {
			echo "Object Not Loaded";
			return;
		}	
			$repository = $object->repository;
	$titleString = 'Wyo [y' . $year . ']';
	$year++;
		
// Print/Purge $dsid if you want to
/*			$api_m = $repository->api->m;		
			$api_m->purgeDatastream($object, $dsid);
			echo "purged $dsid from $object \n";*/

//Update Lable
			$object->label = $titleString;
			echo "New label ingested for $preObject via Tuque. \n";
}