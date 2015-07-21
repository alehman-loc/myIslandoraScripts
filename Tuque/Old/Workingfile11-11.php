Experiments:
************************************
/*
 * Replace a field in a MODS file. 
 *
 * 
 * 
 *
 */
 
  $user = user_load(1);
  $connection = islandora_get_tuque_connection($user);
  $repository = $connection->repository;

  $api_a = $repository->api->a;
  $mods_ds = getDatastreamDissemination(wyu:9000031, MODS);
  print-r($mods_ds);
	
	$command = escapeshellcmd('R:\Amanda\Batching_and_Drush\Scripts\EditMODS.py');
	$output = shell_exec($command);
	echo $output;
************************************
string $argument = "wyu%3A112666";

echo rawurldecode ( $argument );

************************************
Worked: 
*********************************
$type = 'php';
$message = 'testing watchdog';

watchdog($type, $message, $variables = array(), $severity = WATCHDOG_NOTICE, $link = NULL);
**********************************
/*
 * Purge a range of objects from Fedora. 
 *
 * update startPID and endPID, paste into 
 * devel Execute PHP block in dashboard.
 *
 */
 
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;

$api_m = $repository->api->m;
$startPID = '102';
$endPID = '131';

for($pid=$startPID; $pid<=$endPID; $pid++) {
        $object = 'islandora:' . $pid;
        $returnTimestamp = 
		$api_m->purgeObject($object);
        echo "purged $object at: " . $returnTimestamp . PHP_EOL;
    }
  echo "Purged objects $startPID through $endPID.";
***********************************
/*
 * Purge an object. 
 *
 */
 
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;

$api_m = $repository->api->m;
$api_m->purgeObject('wyu:9000027');

*************************************
************************************
/*
 * Delete TN Datastream for Collections. 
 *
 *
 */
 
  $user = user_load(1);
  $connection = islandora_get_tuque_connection($user);
  $repository = $connection->repository;
  
  $api_m = $repository->api->m;
  $startPID = '107955';
  $endPID = '108023';

for($pid=$startPID; $pid<=$endPID; $pid++) {
        $object = 'wyu:' . $pid;
        $returnTimestamp = 
		$api_m->purgeDatastream($object, 'TN');
        echo "purged TN from $object at: " . $returnTimestamp . PHP_EOL;
    }
  echo "Purged TNs from $startPID through $endPID.";
  
******************************************

Experiments:
************************************
/*
 * 
 *
 * 
 */


************************************

************************************
Worked: 
*********************************
$type = 'php';
$message = 'testing watchdog';

watchdog($type, $message, $variables = array(), $severity = WATCHDOG_NOTICE, $link = NULL);
**********************************

***********************************
/*
 * Purge an object. 
 *
 */
 
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;

$api_m = $repository->api->m;
$api_m->purgeObject('wyu:9000027');

*************************************
************************************