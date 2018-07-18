<?php

/**
 * Package object
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\model\packages;

/**
 * Update package objekt
 * 
 * @package fpcm\model\packages
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @since FPCM 3.6
 */
class updatev4 extends update {

    /**
     * Konstruktor
     * @param string $type Package-Type
     * @param string $key Package-Key
     * @param string $version Package-Version
     * @param string $signature Package-Signature
     */
    public function __construct($type, $key, $version = '', $signature = '')
    {
        $this->filename     = 'fanpress_update_version4.0.0.zip';

        $this->remoteFile   = \fpcm\classes\baseconfig::$updateServer.self::FPCMPACKAGE_SERVER_PACKAGEPATH.$this->filename;
        $this->localFile    = \fpcm\classes\baseconfig::$tempDir.$this->filename;
        $this->extractPath  = dirname($this->localFile).'/'.md5(basename($this->localFile, '.zip')).'/';
        $this->tempListFile = \fpcm\classes\baseconfig::$tempDir.md5($this->localFile);
    }
    
    protected function init()
    {
        return false;
    }

}
