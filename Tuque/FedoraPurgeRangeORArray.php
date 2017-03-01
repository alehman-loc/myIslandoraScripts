/*
 * Purge a range of objects from Fedora. 
 *
 * update startPID and endPID, or array, 
 * use devel Execute PHP block.
 * TODO - Error handling!! 
 */
 
//Load Repo and API
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;
$api_m = $repository->api->m;

<<<<<<< HEAD
//_BREAK__ Sequence Variables to replace.
$startPID = '116265';
$endPID = '116285';
>>>>>>> 

/* Iterate through Objects to purge them.
 * Correct the namespace!!
 */
for($pid=$startPID; $pid<=$endPID; $pid++) {
        $object = 'islandora:' . $pid;
        if (!$object) {
            echo "Object Not Loaded";
            return;
        }
	$api_m->purgeObject($object);
        echo "purged $object \n";
    }
  echo "Purged objects $startPID through $endPID.";
	
//_OR__ Array
$arrPIDS = array(57226, 57242, 57247, 57224, 57230, 57241, 57232); 
foreach ($arrPIDS as&$pid) {
	$object = 'wyu:' . $pid;
        $returnTimestamp = 
		$api_m->purgeObject($object);
        echo "purged $object \n";
    } 
