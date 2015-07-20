/*
* Edit Rels-Ext Datastream
*
* by amandarl@uwyo.edu
*/

$arrPIDS = array('wyu:121028', 'wyu:121154'); 
$compound = 'wyu:121161';
$count = 1;

// Load user/connection/API with object
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;
$api_a = $repository->api->a;

//Iterate through pids 
foreach($arrPIDS as&$pid) {
	$newCompound = islandora_object_load($pid);
		if (!$newCompound) {
			echo "Object Not Loaded";
			return;
		}
		$newCompound->relationships->add(FEDORA_RELS_EXT_URI, 'isConstituentOf', 'info:fedora/$compound');
		//$newCompound->relationships->add(ISLANDORA_RELS_EXT_URI, 'isSequenceNumberOf$compound', $count);
		echo "New relationships added for $pid via Tuque. \n";
		$count++;
}