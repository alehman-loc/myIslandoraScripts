#!/bin/sh

userName=amandarl
ServerName=http://uwyo7.coalliance.org
contentModels=islandora:sp_basic_image_collection
collectionPid=islandora:389
batchType=zip
batchDir=/var/www/drupal7/sites/uwyo7.coalliance.org/files/testIngest_Images/basic_images.zip


drush -v --user=$userName --uri=$ServerName islandora_batch_scan_preprocess --content_models=$contentModels --parent=$collectionPid --type=$batchType --target=$batchDir ;

drush -v --user=$userName --uri=$ServerName islandora_batch_ingest ;

# drush -v --user=amandarl --uri=http://uwyo7.coalliance.org islandora_batch_scan_preprocess --content_models=islandora:sp_basic_image_collection --parent=islandora:1380 --type=directory --target=/var/www/drupal7/sites/uwyo7.coalliance.org/files/testIngest_Images/basic_images

# drush --user=amandarl --uri=http://uwyo7.coalliance.org islandora_batch_ingest