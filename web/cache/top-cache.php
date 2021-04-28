<?php

    $url = $_SERVER['SCRIPT_NAME'];
    $query = $_SERVER['QUERY_STRING'];
    #echo $url;
    $break = Explode('/', $url);
    #print_r($break);
    $file = $break[count($break) - 1];
    #echo $file;
    $cachefile = 'cache/cached-'.substr_replace($file ,"",-4).'-'.$query.'.html';
    $cachetime = 2160;

    // Serve from the cache if it is younger than $cachetime
    if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
        echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile))." -->\n";
        readfile($cachefile);
        exit;
    }

    ob_start(); // Start the output buffer

?>