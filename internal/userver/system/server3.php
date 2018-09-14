<?php 

    $data       = json_decode(base64_decode(str_rot13($_GET['data'])), TRUE);

    $filename   = (isset($data['dev'])
                ? "versionlist3dev.php"
                : "versionlist3.php");

    require_once $filename;

    if (isset($data['webinstaller'])) {
        die(base64_encode(str_rot13(base64_encode($installfile))));
    }

    $version        = trim(strip_tags($data['version']));
    $version_minor  = implode('.', explode('.', $version, -1));

    if (isset($versions[$version_minor])) {
        $version = $version_minor;
    }
    elseif (!isset($versions[$version])) {
        $version = 'default';
    }

    $updateData             = array();
    $updateData['version']  = $versions[$version]['newversion'];
    
    $updateData['filepath'] = $versions[$version]['file'];
    
    $updateData['force']    = $versions[$version]['force'];
    
    $updateData['message']  = isset($versions[$version]['message'])
                            ? $versions[$version]['message']
                            : false;
     
    $updateData['notice']  = isset($versions[$version]['notice'])
                            ? $versions[$version]['notice']
                            : false;
     
    $updateData['signature'] = isset($versions[$version]['signature'])
                             ? $versions[$version]['signature']
                             : false;
     
    $updateData['phpversion'] = isset($versions[$version]['phpversion'])
                              ? $versions[$version]['phpversion']
                              : false;

     
    $updateData['v4Available'] = isset($versions[$version]['v4Available'])
                             ? $versions[$version]['v4Available']
                             : false;
     
    $updateData['v4version'] = isset($versions[$version]['v4version'])
                              ? $versions[$version]['v4version']
                              : false;
    
    header('Content-type: text/plain');
    header("Content-Transfer-Encoding: binary\n");
    print str_rot13(base64_encode(json_encode($updateData)));
    flush();
    
    die();
    
?>
