for PID in $(seq 54082 54085); do 
 drush --root=/var/www/coalliance/current --user=amandarl --uri=http://uwyo.coalliance.org islandora_batch_scan_preprocess --namespace=wyu --content_models=islandora:sp_large_image_cmodel --parent=wyu:$PID --type=directory --target=/home/amandarl/ingest/$PID

done