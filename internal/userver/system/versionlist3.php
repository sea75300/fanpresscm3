<?php
    $newversion    = '3.2.0';
    
    $installfile   = 'http://updates.nobody-knows.org/fanpress/system/packages/fanpress3.2.0_full.zip';
    
    $signature = (file_exists(__DIR__.'/packages/fanpress_update_version3.2.0.zip')
               ? '$sig$'.md5_file(__DIR__.'/packages/fanpress_update_version3.2.0.zip').'_'
                        .sha1_file(__DIR__.'/packages/fanpress_update_version3.2.0.zip').'$sig$'
               : '');

    $versions = array(
        'default' => array(
            'file'      => 'http://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version3.2.0.zip',
            'force'     => 0,
            'message'   => 'Next minor release of FanPress CM 3.x!',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-2-0-veroeffentlicht/',
            'signature' => $signature
        )
    );
?>