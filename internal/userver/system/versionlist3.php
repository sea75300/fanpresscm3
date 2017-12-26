<?php

    $installfile    = 'https://github.com/sea75300/fanpresscm3/releases/download/v3.6.3/fanpress3.6.3_full.zip';
    
    $signature     = (file_exists(__DIR__.'/packages/fanpress_update_version3.6.3.zip')
                    ? '$sig$'.md5_file(__DIR__.'/packages/fanpress_update_version3.6.3.zip').'_'.sha1_file(__DIR__.'/packages/fanpress_update_version3.6.3.zip').'$sig$'
                    : '');

    $versions = array(
        'default' => array(
            'newversion'    => '3.6.3',
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version3.6.3.zip',
            'force'     => 0,
            'message'   => 'Next minor release of FanPress CM 3.x!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-6-3-veroeffentlicht/',
            'signature' => $signature,
            'phpversion' => '5.5.3',
            'release'   => '30.11.2017'
        ),

        '3.2' => array(
            'newversion'    => '0.0.0',
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version3.0.0.zip',
            'force'     => 1,
            'message'   => 'Support for FPCM 3.2.x discontinued as of December 26th 2017!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-6-3-veroeffentlicht/',
            'signature' => $signature2,
            'phpversion'    => '5.4.0',
            'release'   => '03.02.2017'
        ),

        '3.1' => array(
            'newversion'    => '0.0.0',
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version0.0.0.zip',
            'force'     => 0,
            'message'   => 'Support for FPCM 3.0.x and FPCM 3.1.x discontinued as of April 14th 2017!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-4-0-veroeffentlicht/',
            'signature' => $signature,
            'phpversion'    => '5.4.0'
        ),

        '3.0' => array(
            'newversion'    => '0.0.0',
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version0.0.0.zip',
            'force'     => 0,
            'message'   => 'Support for FPCM 3.0.x and FPCM 3.1.x discontinued as of April 14th 2017!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-4-0-veroeffentlicht/',
            'signature' => $signature,
            'phpversion'    => '5.4.0'
        )
    );
?>