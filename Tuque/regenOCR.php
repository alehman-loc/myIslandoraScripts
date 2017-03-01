include drupal_get_path('module', 'islandora_ocr') . '/includes/derivatives.inc';
$arrPIDS= array('wyu:53986', 'wyu:53987', 'wyu:53988');

foreach ($arrPIDS as &$pid){
$object= islandora_object_load($pid);
$results = islandora_ocr_derive_ocr($object, False, array('source_dsid' => 'OBJ'));
dpm($results);
}

