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
        $this->filename     = $key.'_version'.$version.'.zip';
        $this->remoteFile   = \fpcm\classes\baseconfig::$updateServer.self::FPCMPACKAGE_SERVER_PACKAGEPATH.'v4/'.$this->filename;
        $this->localFile    = \fpcm\classes\baseconfig::$tempDir.$this->filename;
        $this->extractPath  = dirname($this->localFile).'/'.md5(basename($this->localFile, '.zip')).'/';
        $this->tempListFile = \fpcm\classes\baseconfig::$tempDir.md5($this->localFile);
        $this->archive      = new \ZipArchive();
    }
    
    public function copy()
    {
        $oldList = file(\fpcm\classes\baseconfig::$configDir.'files.txt', FILE_IGNORE_NEW_LINES);
        $oldList = !is_array($oldList) || !count($oldList) ? [] : array_slice($oldList, 1, -2);

        $newList = file($this->extractPath.'fanpress'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'files.txt', FILE_IGNORE_NEW_LINES);
        $newList = !is_array($newList) || !count($newList) ? [] : array_slice($newList, 1, -2);

        if (!file_exists($this->tempListFile)) {
            \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
            return false;
        }

        (new \fpcm\classes\cache())->cleanup();

        $this->loadPackageFileListFromTemp();
        if (!count($this->files)) {
            \fpcm\classes\baseconfig::enableAsyncCronjobs(true);
            return false;
        }

        $res = true;
        foreach ($this->files as $zipFile) {

            $source = $this->extractPath.$zipFile;

            $dest   = dirname(\fpcm\classes\baseconfig::$baseDir).$this->copyDestination.$zipFile;
            $dest   = is_dir($source) ? dirname($dest).'/'.basename($dest) : $dest;                
            $dest   = $this->replaceFanpressDirString($dest);

            if (substr($dest, -8) === 'fanpress') {
                continue;
            }

            if (is_dir($source)) {
                if (!file_exists($dest) && !mkdir($dest, 0777)) {
                    if (!is_array($res)) $res = [];
                    $res[] = $dest;
                }
                continue;
            }

            if (file_exists($dest)) {

                if (sha1_file($source) == sha1_file($dest)) {
                    $this->updateProtocol($zipFile, -1);
                    continue;
                }

                $backFile = $dest.'.back';
                if (file_exists($backFile)) {
                    unlink($backFile);
                }

                rename($dest, $backFile);

            }

            $success = copy($source, $dest);
            if (!$success) {
                if (!is_array($res)) $res = [];                    
                $res[] = $dest;
            }

            $this->updateProtocol($zipFile, $success);
        }            

        if (is_array($res)) {
            fpcmLogSystem('Error while moving update package content from ' . \fpcm\model\files\ops::removeBaseDir(\fpcm\classes\baseconfig::$baseDir) . ' to ' . \fpcm\model\files\ops::removeBaseDir($this->getExtractPath()));
            fpcmLogSystem(implode(PHP_EOL, $this->pkg->getCopyErrorPaths()));
            return self::FPCMPACKAGE_FILESCOPY_ERROR;
        }

        fpcmLogPackages($this->getKey().' '.$this->getVersion(), $this->protocol);

        if (!count($oldList) || !count($newList)) {
            return true;
        }

        $base = dirname(\fpcm\classes\baseconfig::$baseDir);

        $deleteProto = [];
        
        $diff = array_diff($oldList, $newList);
        foreach ($diff as $file) {
            
            if (strpos($file, 'fanpress/data/') !== false) {
                continue;
            }

            $file = $base.DIRECTORY_SEPARATOR.$this->replaceFanpressDirString($file);
            if (!file_exists($file) || is_dir($file)) {
                continue;
            }

            $deleteProto[] = $file;
            if (!unlink($file)) {
                return false;
            }

        }
        
        if (count($deleteProto)) {
            fpcmLogSystem('Removed files during upgrade:'.PHP_EOL. implode(PHP_EOL, $deleteProto));
        }
        
        return true;
    }
    
    protected function init()
    {
        return false;
    }

    /**
     * 
     * @return array
     */
    private function getExcludes()
    {
        return ['fanpress'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'installer.enabled'];
    }

}
