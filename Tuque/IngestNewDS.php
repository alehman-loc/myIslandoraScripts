//Datastream ID and replacement string 
$dsid = 'MODS';
$newString = "<?xml version='1.0' encoding='UTF-8'?>
<mods xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns='http://www.loc.gov/mods/v3' xmlns:mods='http://www.loc.gov/mods/v3' xmlns:xlink='http://www.w3.org/1999/xlink' version='3.5' xsi:schemaLocation='http://www.loc.gov/mods/v3 http://www.loc.gov/standards/mods/v3/mods-3-5.xsd'>
	<titleInfo>
		 <title>Wyoming</title> 
	</titleInfo>  
	<name type='personal'>
		<role>
		<roleTerm authority='marcrelator' type='text'>creator</roleTerm>
		</role>
		<namePart>s.n.</namePart>
	</name>
	<typeOfResource>cartographic</typeOfResource>  
  <genre authority='marcgt'>Maps</genre>
	<originInfo> 
		<place> 
			<placeTerm>S.l.</placeTerm> 
		</place>  
		<publisher>s.n.</publisher>  
		<dateCreated keyDate='yes'>1887-01-01</dateCreated> 
    <dateCaptured>2010-06-07</dateCaptured>
	</originInfo>  
	<language type='text'> 
		<languageTerm>eng</languageTerm> 
	</language>  
	<physicalDescription> 
		<form>1 map : col. </form>  
		<extent>25 x 31 cm.</extent>  
		<digitalOrigin>reformatted digital</digitalOrigin>  
		<note></note> 
	</physicalDescription>  
	<abstract></abstract>  
	<subject> 
		<cartographics> 
			<scale>Scale [ca. 1:2,300,000]</scale> 
			<coordinates>W1110000--W1040000--N0450000--N0410000</coordinates> 
			<coordinates>(W 111⁰--W 104⁰/N 45⁰--N 41⁰).</coordinates> 
		</cartographics> 
	</subject>  
	<recordInfo> 
		<languageOfCataloging> 
				<languageTerm type='text' authority='iso639-2b'>English</languageTerm>
				<languageTerm type='code' authority='iso639-2b'>eng</languageTerm>
		</languageOfCataloging> 
	</recordInfo> 
</mods>";

//Comma separated array of pids w/ds to be replaced.
$arrPIDS = array(394); 

//Load user, connection, API with an object 
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;
$api_a = $repository->api->a;
foreach ($arrPIDS as&$pid) {
  $preObject = 'wyu:' . $pid;
  $object = islandora_object_load($preObject);
  if (!$object) {
    echo "Object Not Loaded";
    return;
  }
  $repository = $object->repository;
//Get $dsid Datastream
  $datastream = $object->constructDatastream($dsid);
	$datastream->label = 'MODS';
	$datastream->mimetype = 'text/xml';
	$datastream->setContentFromString($newString);
	$object->ingestDatastream($datastream);
	echo "New $dsid ingested for $pid via Tuque. \n";
}
