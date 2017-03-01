<?php
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, "http://www.php.net");
    curl_exec ($curl);
    curl_close ($curl);
?>