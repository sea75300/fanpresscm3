<?php
    $newversion    = '3.1.7';
    $newversionDev = '3.1.7';
    
    $installfile   = 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress3.1.7_full.zip';
    
    $signature = (file_exists(__DIR__.'/packages/fanpress_update_version3.1.7.zip')
               ? '$sig$'.md5_file(__DIR__.'/packages/fanpress_update_version3.1.7.zip').'_'
                        .sha1_file(__DIR__.'/packages/fanpress_update_version3.1.7.zip').'$sig$'
               : '');

    $versions = array(
        'default' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.1.7.zip',
            'force'     => 0,
            'message'   => 'Seventh bugfix release of FanPress CM 3.1.x!',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-7-veroeffentlicht/',
            'signature' => $signature
        )
    );
?>