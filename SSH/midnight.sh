/usr/bin/bash

time drush -v --user=amandarl --uri=http://uwdigital.uwyo.edu islandora_batch_ingest ; date 2>&1 | tee home/amandarl/logfiles/logfile12-3_GJBX-Cron.log