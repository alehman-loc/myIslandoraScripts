/*
* Delete/Replace an existing 
* Datastream
* Remove all double quotes from 
* replacement string.
* by amandarl@uwyo.edu
*/


//Variables
$dsid = 'MODS';
$arrPIDS = array(98904, 98905); 
$titleString = '[Page of] The Dynamo - July 1917';
$issueDate = '1917-07-01';

// Load user/connection/API 
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;
$api_a = $repository->api->a;

//Iterate through pids 
foreach ($arrPIDS as&$pid) {
	$preObject = 'wyu:' . $pid;
	$object = islandora_object_load($preObject);
		if (!$object) {
			echo "Object Not Loaded";
			return;
		}	
	$repository = $object->repository;

//Replacement String
	$newString = "<mods xmlns='http://www.loc.gov/mods/v3' xmlns:mods='http://www.loc.gov/mods/v3' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'>
	<titleInfo><title>$titleString</title></titleInfo>
	<abstract>Please see issue for bibliographic information.</abstract>
	<relatedItem type='host'><titleInfo><title>The Dynamo</title></titleInfo></relatedItem>
	<originInfo><dateCreated keyDate='yes'>$issueDate</dateCreated></originInfo>
	<physicalDescription><digitalOrigin>reformatted digital</digitalOrigin></physicalDescription>
	<subject><topic>J.C. Penney Co. --Periodicals</topic></subject>
	<location><url usage="primary display">http://hdl.handle.net/10176/$preObject</url></location>
	<accessCondition type='useAndReproduction'>The University of Wyoming provides access to these public domain materials for educational and research/scholarly purposes. If you wish to publish or reproduce materials from these collections, please attribute each item to Emmett D. Chisum Special Collections, University of Wyoming Libraries. Laramie, WY.</accessCondition>
	</mods>";

//Purge $dsid if you want to
			//$api_m = $repository->api->m;
		//	$api_m->purgeDatastream($object, $dsid);
		//	echo "purged $dsid from $object \n";

//Create Datastream Object  
	$datastream  = islandora_datastream_load($dsid, $object);
  if (!$datastream) {
	//Construct Datastream	
		$datastream = $object->constructDatastream($dsid);
		$datastream->label = $dsid;
		$datastream->mimetype = 'text/xml';
    return;
  }
//Load Datastream
	$loadDS = $datastream->getContent('');
	$loadDS_doc = DOMDocument::loadXML($loadDS);
	$loadDS_string = $loadDS_doc->saveXML();
	$datastream->setContentFromString($newString);
			

//Ingest Datastream and Update Object's Label
			$object->ingestDatastream($datastream);
			$object->label = $titleString;
			echo "New $dsid ingested for $preObject via Tuque. \n";
}