for PID in 80754 42503
do
echo "Processing IngestSeqPIDS.sh"
time drush --root=/var/www/html --user=amandarl --uri=http://localhost.uwyo.edu/ islandora_batch_scan_preprocess --namespace=wyu --content_models=islandora:sp_large_image_cmodel --parent=wyu:$PID --type=directory --target=/home/amandarl/$PID
done