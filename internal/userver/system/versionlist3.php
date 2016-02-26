<?php
    $newversion    = '3.1.5';
    $newversionDev = '3.2.0-b1';
    
    $installfile   = 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress3.1.5_full.zip';
    
    $signature = (file_exists(__DIR__.'/packages/fanpress_update_version3.1.5.zip')
               ? '$sig$'.md5_file(__DIR__.'/packages/fanpress_update_version3.1.5.zip').'_'
                        .sha1_file(__DIR__.'/packages/fanpress_update_version3.1.5.zip').'$sig$'
               : '');

    $versions = array(
        'default' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.1.5.zip',
            'force'     => 0,
            'message'   => 'Third bugfix release of FanPress CM 3.1.x!',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-5-veroeffentlicht/',
            'signature' => $signature
        ),

        '3.2.0-dev' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.2.0-b1.zip',
            'force'     => 0,
            'message'   => 'FanPress CM 3.2 beta1',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-4-veroeffentlicht/',
            'signature' => ''
        ),

        '3.2.0-a1' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.2.0-b1.zip',
            'force'     => 0,
            'message'   => 'FanPress CM 3.2 beta1',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-4-veroeffentlicht/',
            'signature' => ''
        )
    );
?>