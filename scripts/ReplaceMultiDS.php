/*
* Delete/Replace an existing 
* Datastream
* Remove all double quotes from 
* replacement string.
* by amandarl@uwyo.edu
*/

//Variables
$dsid = 'MODS';
$dsid2 = 'DC';
$arrPIDS = array(98904, 98905); 
$titleString = '[Page of] The Dynamo - July 1917';
$issueDate = '1917-07-01';

// Load user/connection/API 
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;
$api_a = $repository->api->a;

//Iterate through pids and 
foreach ($arrPIDS as&$pid) {
	$preObject = 'wyu:' . $pid;
	$object = islandora_object_load($preObject);
		if (!$object) {
			echo "Object Not Loaded";
			return;
		}	
			$repository = $object->repository;

//New datastream strings
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

$newDC = "<oai_dc:dc xmlns:dc='http://purl.org/dc/elements/1.1/' xmlns:oai_dc='http://www.openarchives.org/OAI/2.0/oai_dc/' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:schemaLocation='http://www.openarchives.org/OAI/2.0/oai_dc/ http://www.openarchives.org/OAI/2.0/oai_dc.xsd'>
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
			
//Get $dsid Datastream
 $datastream  = islandora_datastream_load($dsid, $object);
  if (!$datastream) {
    echo "Datastream Not Loaded";
    return;
  }//Ingest new datastreams and update Label.
//$dsid Datastream Ingest	
		$datastream = $object->constructDatastream($dsid);
		$datastream->label = $dsid;
		$datastream->mimetype = 'text/xml';
		$datastream->setContentFromString($newString);
		$object->ingestDatastream($datastream);
		
		$object->label = $titleString;

//Get and ingest $dsid2 Datastream
 $datastream2  = islandora_datastream_load($dsid2, $object);
  if (!$datastream2) {
    echo "DC Datastream Not Loaded";
    return;
  }
		$loadDS2 = $datastream2->getContent('');
		$loadDS_doc2 = DOMDocument::loadXML($loadDS2);
		$loadDS_string2 = $loadDS_doc2->saveXML();
		$datastream2 = $object->constructDatastream($dsid2);
		$datastream2->label = '$dsid2 Datastream';
		$datastream2->mimetype = 'text/xml';
		$datastream2->setContentFromString($newDC);
		$object->ingestDatastream($datastream2);
		
		echo "New $dsid and DC ingested for $preObject via Tuque. \n";

}








