<?php
    $newversion    = '3.1.6';
    $newversionDev = '3.1.6';
    
    $installfile   = 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress3.1.6_full.zip';
    
    $signature = (file_exists(__DIR__.'/packages/fanpress_update_version3.1.6.zip')
               ? '$sig$'.md5_file(__DIR__.'/packages/fanpress_update_version3.1.6.zip').'_'
                        .sha1_file(__DIR__.'/packages/fanpress_update_version3.1.6.zip').'$sig$'
               : '');

    $versions = array(
        'default' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.1.6.zip',
            'force'     => 0,
            'message'   => 'Third bugfix release of FanPress CM 3.1.x!',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-5-veroeffentlicht/',
            'signature' => $signature
        ),

        '3.1.1dev' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.1.6.zip',
            'force'     => 0,
            'message'   => 'Third bugfix of FanPress CM 3.1.x!',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-6-veroeffentlicht/',
            'signature' => ''
        ),

        '3.1.3dev' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.1.6.zip',
            'force'     => 0,
            'message'   => 'Third bugfix of FanPress CM 3.1.x!',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-6-veroeffentlicht/',
            'signature' => ''
        ),

        '3.1.5dev' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.1.6.zip',
            'force'     => 0,
            'message'   => 'Third bugfix of FanPress CM 3.1.x!',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-6-veroeffentlicht/',
            'signature' => ''
        )
    );
?>