<?php
    $tmpfile = $_FILES['fileToUpload']['tmp_name'];
    $filename = basename($_FILES['fileToUpload']['name']);
    $data = array(
        'uploaded_file' => curl_file_create($tmpfile, $_FILES['fileToUpload']['type'], $filename)
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data)
?>