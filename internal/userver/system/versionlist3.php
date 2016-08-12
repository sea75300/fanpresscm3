<?php
    $newversion    = '3.2.4';
    
    $installfile   = 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress3.2.4_full.zip';
    
    $signature = (file_exists(__DIR__.'/packages/fanpress_update_version3.2.4.zip')
               ? '$sig$'.md5_file(__DIR__.'/packages/fanpress_update_version3.2.4.zip').'_'
                        .sha1_file(__DIR__.'/packages/fanpress_update_version3.2.4.zip').'$sig$'
               : '');

    $versions = array(
        'default' => array(
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version3.2.4.zip',
            'force'     => 0,
            'message'   => 'Next minor release of FanPress CM 3.x!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-2-3-veroeffentlicht/',
            'signature' => $signature
        )
    );
?>