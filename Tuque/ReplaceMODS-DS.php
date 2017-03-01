/*
* Delete/Replace an existing 
* Datastream
* Remove all double quotes from 
* replacement string.
* by amandarl@uwyo.edu
*/


//Variables
$dsid = 'MODS';
$arrPIDS = array(72394, 72591, 153869); 
$volCount = 2;
$year = 1910;

// Load user/connection/API 
$user = user_load(1);
$connection = islandora_get_tuque_connection($user);
$repository = $connection->repository;
$api_a = $repository->api->a;

//Iterate through pids 
foreach ($arrPIDS as&$pid) {
    $vol = str_pad($volCount, 2, "0", STR_PAD_LEFT);
    $titleString = "Wyo [Volume " . $vol. " - Senior Class of " . $year . "]";
	$preObject = 'wyu:' . $pid;
	$object = islandora_object_load($preObject);
		if (!$object) {
			echo "Object Not Loaded";
			return;
		}	
	$repository = $object->repository;

//Replacement String
	$newString = "
<mods xmlns='http://www.loc.gov/mods/v3' xmlns:mods='http://www.loc.gov/mods/v3' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'>
  <titleInfo>
    <title>$titleString</title>
  </titleInfo>
  <titleInfo displayLabel='Also known as:' type='alternative'>
    <title>Wyo yearbook</title>
  </titleInfo>
  <part>
    <detail type='volume'>
        <number>$vol</number>
    </detail>
   </part>
  <name type='corporate'>
    <namePart>University of Wyoming</namePart>
    <namePart>Junior Class.</namePart>
  </name>
  <typeOfResource>text</typeOfResource>
  <originInfo>
    <place>
      <placeTerm type='text'>Laramie, Wyo</placeTerm>
    </place>
    <publisher>University of Wyoming</publisher>
    <dateIssued keyDate='yes'>$year</dateIssued>
    <issuance>continuing</issuance>
    <copyrightDate>$year</copyrightDate>
  </originInfo>
  <language>
    <languageTerm authority='iso639-2b' type='code'>eng</languageTerm>
  </language>
  <physicalDescription>
    <form authority='marcform'>print</form>
    <digitalOrigin>reformatted digital</digitalOrigin>
  </physicalDescription>
  <note type='statement of responsibility'>Junior Class, University of Wyoming</note>
  <subject authority='lcsh'>
    <name type='corporate'>
      <namePart>University of Wyoming</namePart>
    </name>
    <topic>Students -- Periodicals -- Yearbooks</topic>
  </subject>
  <accessCondition type='useAndReproduction'>You may use the digital images and catalog records found on this website for your private study, scholarship or research. Some of the images from the University of Wyoming Libraries are in the public domain.</accessCondition>
  <location>
    <url usage='primary display'>http://hdl.handle.net/10176/$preObject</url>
  </location>
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
//Load Datastream and inc Counts
            $volCount++;
            $year ++;
            $datastream->setContentFromString($newString);
			//test: print_r ($newString);
            
//Ingest Datastream and Update Object's Label
			$object->ingestDatastream($datastream);
			$object->label = $titleString;
			echo "New $dsid ingested for $preObject via Tuque. \n";
}