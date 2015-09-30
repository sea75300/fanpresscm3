<?php
    /**
     * FanPress CM filesystem operations model
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\files;

    /**
     * Filesystem operations object
     * 
     * @package fpcm.model.files
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    final class ops {

        /**
         * Kopiert Verzeichnis-Inhalt rekursiv
         * @param string $source
         * @param string $destination
         * @param array $exclude
         */
        public static function copyRecursive($source, $destination, $exclude = array()) {
            $dir = opendir($source);
            
            $destination = realpath($destination);

            if(!file_exists($destination)) {
                if (!mkdir($destination, 0777)) {
                    return false;
                }
            }
            
            while(false !== ( $file = readdir($dir)) ) {
                if (( $file != '.' ) && ( $file != '..' )) {
                    if ( is_dir($source . '/' . $file) ) {
                        $recres = self::copyRecursive($source . '/' . $file,$destination . '/' . $file);
                    } else {
                        if(!empty($destination) && !empty($file) && file_exists($destination . '/' . $file) && !is_writable($destination . '/' . $file)) {
                            chmod($destination . '/' . $file, 0777);
                        }
                        if(count($exclude) && in_array($file, $exclude)) continue;
                        $cpres = copy($source . '/' . $file,$destination . '/' . $file);
                    }
                }
            }
            closedir($dir);
            
            return true;
        }
        
        /**
         * Löscht Verzeichnis-Inhalt rekursiv
         * @param string $path
         * @return bool
         */
        public static function deleteRecursive($path) {
            
            if (!$path || !file_exists($path) || !is_dir($path)) return false;

            $res = true;
            
            $pathFiles = glob($path.'/*');

            if (is_array($pathFiles)) {
                foreach ($pathFiles as $pathFile) {
                    if (!file_exists($pathFile) || !is_writable($pathFile) || strpos($path, './') !== false || strpos($path, '../') !== false) continue;                    
                    if (is_dir($pathFile)) {
                        $res = $res && self::deleteRecursive($pathFile);
                        continue;
                    }

                    $res = $res && unlink($pathFile);
                }   
            }
            
            return $res && rmdir($path);
        }
        
        /**
         * Entfernt FanPress CM baseDir-String aus einer Pfadangabe
         * @param string $path
         * @param bool $keepFanPress
         * @return string
         * @since FPCM 3.1
         */
        public static function removeBaseDir($path, $keepFanPress = false) {
            
            $replacePath = \fpcm\classes\baseconfig::$baseDir;
            if ($keepFanPress) {
                $replacePath = dirname($replacePath);
            }
            
            return str_replace($replacePath, '', $path);
        }
    }