<?php

    $installfile   = 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress3.3.0_full.zip';
    
    $signature = (file_exists(__DIR__.'/packages/fanpress_update_version3.3.0.zip')
               ? '$sig$'.md5_file(__DIR__.'/packages/fanpress_update_version3.3.0.zip').'_'
                        .sha1_file(__DIR__.'/packages/fanpress_update_version3.3.0.zip').'$sig$'
               : '');

    $versions = array(
        'default' => array(
            'newversion'    => '3.3.0',
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version3.3.0.zip',
            'force'     => 0,
            'message'   => 'Next minor release of FanPress CM 3.x!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-3-0-veroeffentlicht/',
            'signature' => $signature
        ),

        '3.1' => array(
            'newversion'    => '3.2.4',
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version3.2.4.zip',
            'force'     => 1,
            'message'   => 'Latest version of FanPress CM 3.2 which can be directly updated from FanPress CM 3.0.x and 3.1.x!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-3-0-veroeffentlicht/',
            'signature' => $signature
        ),

        '3.0' => array(
            'newversion'    => '3.2.4',
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version3.2.4.zip',
            'force'     => 1,
            'message'   => 'Latest version of FanPress CM 3.2 which can be directly updated from FanPress CM 3.0.x and 3.1.x!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-3-0-veroeffentlicht/',
            'signature' => $signature
        )
    );
?>