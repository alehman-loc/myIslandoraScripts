/*
* Replace an array of Datastreams
* 
* Remove all double quotes from 
* replacement string.
*/

// Comma separated array of pids w/ds to be replaced.
$arrPIDS = array(35967, 35966, 35965, 35964, 35963, 35962, 35961, 35960, 35959, 35958, 35957, 35956, 35955, 35954, 35953, 35952, 35951, 35950, 35949, 35948, 35947, 35946, 35945, 35944, 35943, 35942, 35941, 35940, 35939, 35938, 35937, 35936, 35935, 35934);
//$issueDate = "2004-01-01";

// Load user, connection, API with an object 
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;
$api_a = $repository->api->a;
$count = 1;

// Iterate through objects
foreach ($arrPIDS as&$pid) {
	$padCount = str_pad($count, 4, "0", STR_PAD_LEFT);
	$titleString = "1992_SouthPacific_" . $padCount;
  $preObject = 'wyu:' . $pid;
  $object = islandora_object_load($preObject);
  if (!$object) {
    echo "Object Not Loaded";
    return;
  }
		$newStrings = array('MODS' => "<mods xmlns='http://www.loc.gov/mods/v3' xmlns:mods='http://www.loc.gov/mods/v3' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'>
  <titleInfo>
    <title>$titleString</title>
    <subTitle></subTitle>
  </titleInfo>
  <name type='personal'>
    <namePart>Selting, Leigh</namePart>
    <role>
      <roleTerm authority='marcrelator' type='text'>Director</roleTerm>
    </role>
  </name>
  <name type='corporate'>
    <namePart>University of Wyoming Department of Theater and Dance</namePart>
    <role>
      <roleTerm authority='marcrelator' type='text'>Contributor</roleTerm>
    </role>
  </name>
  <typeOfResource>still image</typeOfResource>
  <genre authority='marcgt'>picture</genre>
  <originInfo>
    <dateCreated>1992-01-01</dateCreated>
    <publisher>University of Wyoming Department of Theater and Dance</publisher>
    <place>
      <placeTerm type='text'>Laramie, WY</placeTerm>
    </place>
  </originInfo>
  <physicalDescription>
    <form authority='marcform'>nonprojected graphic</form>
    <digitalOrigin>reformatted digital</digitalOrigin>
  </physicalDescription>
  <accessCondition type='useAndReproduction'>The University of Wyoming provides access to these public domain materials for educational and research/scholarly purposes. If you wish to publish or reproduce materials from these collections, please attribute each item to Department of Theater and Dance, University of Wyoming. Laramie, WY.</accessCondition>
  <location>
    <url usage='primary display'>http://hdl.handle.net/10176/$preObject</url>
  </location>
</mods>", 'DC' => "<oai_dc:dc xmlns:oai_dc='http://www.openarchives.org/OAI/2.0/oai_dc/' xmlns:dc='http://purl.org/dc/elements/1.1/' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:schemaLocation='http://www.openarchives.org/OAI/2.0/oai_dc/ http://www.openarchives.org/OAI/2.0/oai_dc.xsd'>
  <dc:title>$titleString</dc:title>
  <dc:publisher>University of Wyoming Department of Theater and Dance</dc:publisher>
  <dc:contributor>University of Wyoming Department of Theater and Dance (Contributor)</dc:contributor>
	<dc:contributor>Selting, Leigh (Director)</dc:contributor>
  <dc:type>StillImage</dc:type>
  <dc:type>picture</dc:type>
	<dc:date>1992-01-01</dc:date>
  <dc:format>nonprojected graphic</dc:format>
  <dc:identifier>http://hdl.handle.net/10176/$preObject</dc:identifier>
  <dc:identifier>$preObject</dc:identifier>
  <dc:rights>The University of Wyoming provides access to these public domain materials for educational and research/scholarly purposes. If you wish to publish or reproduce materials from these collections, please attribute each item to Department of Theater and Dance, University of Wyoming. Laramie, WY.</dc:rights>
</oai_dc:dc>");
  $repository = $object->repository;
	
//Get $dsid Datastream if none, create
	$object->label = $titleString;
	$count++;
	foreach (array_keys($newStrings) as $key) {
		$datastream  = islandora_datastream_load($key, $object);
		if (!$datastream) {
			$datastream = $object->constructDatastream($key);
			$datastream->label = $key;
			$datastream->mimetype = 'text/xml';
			$datastream->setContentFromString($newStrings[$key]);
			$object->ingestDatastream($datastream);
		} //If exists - Edit Content
		$loadDS = $datastream->getContent('');
		$loadDS_doc = DOMDocument::loadXML($loadDS);
		$loadDS_string = $loadDS_doc->saveXML();
		$datastream->setContentFromString($newStrings[$key]);
		echo "New $key ingested for $preObject via Tuque. \n";
	}
}