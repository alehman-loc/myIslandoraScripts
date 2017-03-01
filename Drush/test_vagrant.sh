#!/usr/bin/bash 

# Location: opt/LibOps/test_lib_dev_drf.sh
# This is a document for testing Jeffs Updates
# It ingests a video, a pdf, and three books.  
# Checklist for QA Stage in Trello.
# Update https://www-lib.uwyo.edu/redmine/issues/70 when ready.


# Logfile: in folder where you ran the script
>> test_log_DATE.log

# Ingest PDF
echo begin PDF PreIngest ; date
time drush --v --root=/var/www/drupal --uri=http://localhost:8000 --user=admin ibsp --namespace=islandora --parent=islandora:sp_pdf_collection --content_models=islandora:sp_pdf --type=directory --target=/home/vagrant/drush_test_al/test_PDF

echo ibi ; date
time drush -v --root=/var/www/drupal  ibi

# Ingest video
echo begin Video PreIngest ; date
 drush --root=/var/www/drupal --uri=http://localhost:8000 --user=admin ibsp --namespace=islandora --parent=islandora:video_collection --content_models=islandora:sp_videoCModel --type=directory --target=/home/vagrant/drush_test_al/test_Video
 
# Ingest books
echo begin Books PreIngest ; date
time drush -v --root=/var/www/drupal --uri=http://localhost:8000 --user=admin islandora_book_batch_preprocess --namespace=islandora --parent=islandora:book_batch_test --content_models=islandora:bookCModel --type=directory --target=/home/vagrant/drush_test_al/test_Books

echo ibi 
time drush -v --root=/var/www/drupal  ibi ; date

