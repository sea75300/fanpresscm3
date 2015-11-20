<?php
    $newversion    = '3.1.4';
    $newversionDev = '3.1.4';
    
    $installfile   = 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress3.1.4_full.zip';
    
    $signature = (file_exists(__DIR__.'/packages/fanpress_update_version3.1.4.zip')
               ? '$sig$'.md5_file(__DIR__.'/packages/fanpress_update_version3.1.4.zip').'_'
                        .sha1_file(__DIR__.'/packages/fanpress_update_version3.1.4.zip').'$sig$'
               : '');

    $versions = array(
        'default' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.1.4.zip',
            'force'     => 0,
            'message'   => 'Second release of FanPress CM 3.1.x!',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-4-veroeffentlicht/',
            'signature' => $signature
        ),

        '3.1.1dev' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.1.4.zip',
            'force'     => 0,
            'message'   => 'Second release of FanPress CM 3.1.x!',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-4-veroeffentlicht/',
            'signature' => ''
        ),

        '3.1.3dev' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.1.4.zip',
            'force'     => 0,
            'message'   => 'Second release of FanPress CM 3.1.x!',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-4-veroeffentlicht/',
            'signature' => ''
        )
    );
?>