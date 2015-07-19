<?php 
    include "modulelist3.php";

    $data       = json_decode(base64_decode(str_rot13($_GET['data'])), TRUE);
    $version    = trim(strip_tags($data['version']));
    
    header('Content-type: text/plain');
    header("Content-Transfer-Encoding: binary\n");
    print str_rot13(base64_encode(json_encode($modulesServer)));
    flush();
    
    die();
    
?>
