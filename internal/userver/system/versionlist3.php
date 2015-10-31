<?php
    $newversion    = '3.1.0';
    $newversionDev = '3.1.0';
    
    $installfile   = 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress3.1.0_full.zip';
    
    $signature = (file_exists(__DIR__.'/packages/fanpress_update_version3.1.0.zip') ? '$sig$'.md5_file(__DIR__.'/packages/fanpress_update_version3.1.0-rc5.zip').'_'.sha1_file(__DIR__.'/packages/fanpress_update_version3.1.0.zip').'$sig$' : '');

    $versions = array(
        'default' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.1.0.zip',
            'force'     => 0,
            'message'   => 'First minor release of FanPress CM 3.x, includes bugfixes and new features!',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-0-veroeffentlicht/',
            'signature' => $signature
        ),

//        '3.1.0-rc5dev' => array(
//            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.1.0.zip',
//            'force'     => 0,
//            'message'   => 'First minor release of FanPress CM 3.x, includes bugfixes and new features!',
//            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-0-veroeffentlicht/',
//            'signature' => $signature
//        )
    );
?>