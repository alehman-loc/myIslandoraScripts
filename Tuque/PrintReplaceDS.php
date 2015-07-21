/*
* Print/Edit/Replace an existing 
* Datastream
* Remove all double quotes from 
* replacement string.
* by amandarl@uwyo.edu 2015-04-10
*/

$dsid = 'MODS';
$pid = '93734';

//TitleString in <title> and Label
$titleString = "2007SP_thebodythroughwhichdreamsflow_0152";

// Load user/connection/API with object
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;
$api_a = $repository->api->a;
$preObject = 'wyu:' . $pid;
$object = islandora_object_load($preObject);
  if (!$object) {
    echo "Object Not Loaded";
    return;
  }	
$repository = $object->repository;

//Get $dsid Datastream
  $datastream  = islandora_datastream_load($dsid, $object);
  if (!$datastream) {
    echo "Datastream Not Loaded";
    return;
  } //Edit Content
		$newString = "<mods xmlns='http://www.loc.gov/mods/v3' xmlns:mods='http://www.loc.gov/mods/v3' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'>
		<titleInfo>
			<title>$titleString</title>
		</titleInfo>
		<name type='personal'>
			<namePart>Hilliker, Rebecca</namePart>
			<role>
				<roleTerm authority='marcrelator' type='text'>Director</roleTerm>
			</role>
		</name>
		<typeOfResource>still image</typeOfResource>
		<genre authority='marcgt'>picture</genre>
		<originInfo>
			<dateCreated keyDate='yes'>2008</dateCreated>
			<publisher>University of Wyoming Department of Theater and Dance</publisher>
			<place>
				<placeTerm type='text'>Laramie, WY</placeTerm>
			</place>
		</originInfo>
		<physicalDescription>
			<form authority='marcform'>nonprojected graphic</form>
			<digitalOrigin>reformatted digital</digitalOrigin>
		</physicalDescription>
		<subject>
			<topic>Performing Arts</topic>
		</subject>
		<accessCondition type='useAndReproduction'>The University of Wyoming provides access to these public domain materials for educational and research/scholarly purposes. If you wish to publish or reproduce materials from these collections, please attribute each item to the Department of Theater and Dance, University of Wyoming. Laramie, WY.</accessCondition>
		<location>
			<url usage='primary display'>http://hdl.handle.net/10176/$preObject</url>
		</location>
		</mods>";
		
    $loadDS = $datastream->getContent('');
    $loadDS_doc = DOMDocument::loadXML($loadDS);
    $loadDS_string = $loadDS_doc->saveXML();

		/*Check Strings
		print_r ($loadDS_string);
		print_r ($newString);*/
//Update ds and object label
    $datastream->setContentFromString($newString);
		$object->label = $titleString;
    echo "New MODS ingested for $preObject via Tuque. \n";