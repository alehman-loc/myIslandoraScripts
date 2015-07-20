/*
* Delete/Replace an existing 
* Datastream
* Remove all double quotes from 
* replacement string.
* by amandarl@uwyo.edu
*/


//Variables
$dsid = 'DC';
$arrPIDS = array(98904, 98905); 
$titleString = '[Page of] The Dynamo - July 1917';
$issueDate = '1917-07-01';

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

$newString = "<oai_dc:dc xmlns:dc='http://purl.org/dc/elements/1.1/' xmlns:oai_dc='http://www.openarchives.org/OAI/2.0/oai_dc/' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:schemaLocation='http://www.openarchives.org/OAI/2.0/oai_dc/ http://www.openarchives.org/OAI/2.0/oai_dc.xsd'>
  <dc:title>$titleString</dc:title>
  <dc:subject>J.C. Penney Co. --Periodicals</dc:subject>
  <dc:description>Please see issue for bibliographic information.</dc:description>
  <dc:contributor></dc:contributor>
  <dc:date>$issueDate</dc:date>
  <dc:format>reformatted digital</dc:format>
  <dc:identifier>http://hdl.handle.net/10176/$preObject</dc:identifier>
  <dc:relation>The Dynamo</dc:relation>
  <dc:rights>The University of Wyoming provides access to these public domain materials for educational and research/scholarly purposes. If you wish to publish or reproduce materials from these collections, please attribute each item to Emmett D. Chisum Special Collections, University of Wyoming Libraries. Laramie, WY.</dc:rights>
</oai_dc:dc>";

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