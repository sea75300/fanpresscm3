<?php

    $installfile    = 'https://github.com/sea75300/fanpresscm3/releases/download/v3.7.1/fanpress3.7.1_full.zip';
    
    $signature     = (file_exists(__DIR__.'/packages/fanpress_update_version3.7.1.zip')
                    ? '$sig$'.md5_file(__DIR__.'/packages/fanpress_update_version3.7.1.zip').'_'.sha1_file(__DIR__.'/packages/fanpress_update_version3.7.1.zip').'$sig$'
                    : '');

    $versions = array(
        'default' => array(
            'newversion'    => '3.7.1',
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version3.7.1.zip',
            'force'     => 0,
            'message'   => 'Preparing release for auto upgrade to FanPress CM 4!!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-7-0-veroeffentlicht/',
            'signature' => $signature,
            'phpversion' => '5.5.3',
            'release'   => '10.08.2018',
            'v4Available'   => true,
            'v4version'     => '4.0.0-rc17',
        ),
        '3.7.0' => array(
            'newversion'    => '3.7.1',
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version3.7.1.zip',
            'force'     => 0,
            'message'   => 'Preparing release for auto upgrade to FanPress CM 4!!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-7-0-veroeffentlicht/',
            'signature' => $signature,
            'phpversion' => '5.5.3',
            'release'   => '10.08.2018',
            'v4Available'   => false,
            'v4version'     => '',
        ),

        '3.4' => array(
            'newversion'    => '0.0.0',
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version0.0.0.zip',
            'force'     => 0,
            'message'   => 'Support for FPCM 3.4.x discontinued as of August 10th 2018!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-7-0-veroeffentlicht/',
            'signature' => '',
            'phpversion'    => '5.4.0',
            'release'   => '0.0.0'
        ),

        '3.3' => array(
            'newversion'    => '0.0.0',
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version0.0.0.zip',
            'force'     => 0,
            'message'   => 'Support for FPCM 3.3.x discontinued as of May 13th 2018!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-6-3-veroeffentlicht/',
            'signature' => '',
            'phpversion'    => '5.4.0',
            'release'   => '0.0.0'
        ),

        '3.2' => array(
            'newversion'    => '0.0.0',
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version0.0.0.zip',
            'force'     => 0,
            'message'   => 'Support for FPCM 3.2.x discontinued as of December 26th 2017!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-6-3-veroeffentlicht/',
            'signature' => '',
            'phpversion'    => '5.4.0',
            'release'   => '0.0.0'
        ),

        '3.1' => array(
            'newversion'    => '0.0.0',
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version0.0.0.zip',
            'force'     => 0,
            'message'   => 'Support for FPCM 3.0.x and FPCM 3.1.x discontinued as of April 14th 2017!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-4-0-veroeffentlicht/',
            'signature' => '',
            'phpversion'    => '5.4.0'
        ),

        '3.0' => array(
            'newversion'    => '0.0.0',
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version0.0.0.zip',
            'force'     => 0,
            'message'   => 'Support for FPCM 3.0.x and FPCM 3.1.x discontinued as of April 14th 2017!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-4-0-veroeffentlicht/',
            'signature' => '',
            'phpversion'    => '5.4.0'
        )
    );
?>