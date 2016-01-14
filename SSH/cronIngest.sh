#!/usr/bin/bash
#
# Ingest a sequence of folders  named by Islandora Collection PID into their respective collections - Declare CModel, 
#

#declare(cModel="islandora:sp_large_image_cmodel");
cModel="islandora:sp_large_image_cmodel";

for PID in test-1 test-2
do
echo "Processing IngestSeqPIDS.sh"
# time drush --root=/var/www/html --user=amandarl --uri=http://uwdigital.uwyo.edu/ islandora_batch_scan_preprocess --namespace=wyu --content_models=$cm --parent=wyu:$PID --type=directory --target=/home/amandarl/$PID
time drush --root=/var/www/html --user=amandarl --uri=http://uwdigital.uwyo.edu/ islandora_batch_scan_preprocess --namespace=wyu --content_models=$cModel --parent=wyu:$PID --type=directory --target=/home/amandarl/$PID
done