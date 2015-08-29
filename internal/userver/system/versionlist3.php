<?php
    $newversion    = '3.0.3';
    $newversionDev = '3.0.3';
    
    $installfile   = 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress3.0.3_full.zip';
    
    $versions = array(
        'default' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.0.3.zip',
            'force'     => 0,
            'message'   => 'Frist release of FanPress CM 3.x!',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-veroeffentlicht/',
            'signature' => '$sig$'.md5_file(__DIR__.'/packages/fanpress3.0.3_full.zip').'_'.sha1_file(__DIR__.'/packages/fanpress3.0.3_full.zip').'$sig$'
        )
    );
?>