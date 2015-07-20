/*
 * Delete disd_arr Datastreams. 
 * Enter comma separated arrays of 
 * pids and DS.
 */

$arrPIDS = array(91734, 91898); 
$dsid_arr = array('OBJ', 'TN', 'JPG', 'JP2');
 
//Load Repo and API
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;
$api_m = $repository->api->m;

foreach ($arrPIDS as&$pid) {
      $object = 'wyu:' . $pid;
			foreach ($dsid_arr as&$dsid) {
				if (!isset($object[$dsid])) {
					echo "No $dsid Datastream for $object \n";
					return;
				}
				else {
					$api_m->purgeDatastream($object, $dsid);
					echo "purged $dsid from $object \n";
				}
			}
}
		
//Sequence of Collections to Purge.
$startPID = '117800';
$endPID = '117801';

//Iterate through objects to purge DS.
for($pid=$startPID; $pid<=$endPID; $pid++) {
  $object = 'wyu:' . $pid;
	foreach ($dsid_arr as&$dsid) {
		if (!isset($object[$dsid])) {
			echo "No $dsid Datastream for $object \n";
			return;
		}
		else {
			$api_m->purgeDatastream($object, $dsid);
			echo "purged $dsid from $object \n";
		}
	}//foreach
}//for
echo "Purged TNs from $startPID through $endPID.";