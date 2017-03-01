for PID in 50959 140396
do
echo "Processing IngestSeqPIDS.sh"
time drush --root=/var/www/html --user=amandarl --uri=http://uwdigital.uwyo.edu/ islandora_batch_scan_preprocess --namespace=wyu --content_models=islandora:sp_pdf --parent=wyu:$PID --type=directory --target=/home/amandarl/$PID
done