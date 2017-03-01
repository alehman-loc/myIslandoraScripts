/*
* Replace an existing Datastream
* count/update object lable for MODS
* Remove all double quotes from 
* replacement string.
*/

/* Variables and comma separated arrays of pids
* and replacement values for newString.
*/
$dsid = 'RELS-EXT';
$issueCount = 1;
$arrPIDS = array(160774, 158790,);
$arrDates = array("1975-01-01", "1976-01-01" );
// Load user, connection, API with an object 
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;
$api_a = $repository->api->a;

// Iterate through objects
foreach (array_keys($arrPIDS) as $key) {
  $preObject = 'wyu:' . $arrPIDS[$key];
  $object = islandora_object_load($preObject);
  $issueDate= $arrDates[$key];
  if (!$object) {
    echo "Object Not Loaded";
    return;
  }

// Replacing variables SINGLE quotes
	$newString = "<?xml version='1.0'?>
<rdf:RDF xmlns:rdf='http://www.w3.org/1999/02/22-rdf-syntax-ns#' xmlns:fedora='info:fedora/fedora-system:def/relations-external#' xmlns:fedora-model='info:fedora/fedora-system:def/model#' xmlns:islandora='http://islandora.ca/ontology/relsext#'>
    <rdf:Description rdf:about='info:fedora/$preObject'>
        <fedora:isMemberOf rdf:resource='info:fedora/wyu:139302'/>
        <fedora-model:hasModel rdf:resource='info:fedora/islandora:newspaperIssueCModel'/>
        <islandora:newspaper-batched>true</islandora:newspaper-batched>
        <islandora:isSequenceNumber>$issueCount</islandora:isSequenceNumber>
        <islandora:dateIssued>$issueDate</islandora:dateIssued>
    </rdf:Description>
</rdf:RDF>";
  $repository = $object->repository;
//Get $dsid Datastream
  $datastream  = islandora_datastream_load($dsid, $object);
  if (!$datastream) {
    echo "Datastream Not Loaded";
    return;
  } //Edit Content
    $loadDS = $datastream->getContent('');
    $loadDS_doc = DOMDocument::loadXML($loadDS);
    $loadDS_string = $loadDS_doc->saveXML();
	// Check Strings - 
    print_r ("$issueCount" . "\n");
	print_r ($loadDS_string);
	print_r ($newString);
	
/*     $datastream->setContentFromString($newString);
    print_r ( "New $dsid ingested for $preObject via Tuque. \n"); */
    $issueCount++;
}