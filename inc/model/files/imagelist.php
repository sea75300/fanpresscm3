<?php
    /**
     * Image list object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\files;

    /**
     * Image list object
     * 
     * @package fpcm.model.files
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */    
    final class imagelist extends \fpcm\model\abstracts\filelist {

        /**
         * Konstruktor
         */
        public function __construct() {
            $this->table    = \fpcm\classes\database::tableFiles;
            $this->basepath = \fpcm\classes\baseconfig::$uploadDir;
            $this->exts     = image::$allowedExts;
            
            parent::__construct();
        }
        
        /**
         * Gibt Dateiindex in Datenbank zurück
         * @return array
         */
        public function getDatabaseList() {
            $images = $this->dbcon->fetch($this->dbcon->select($this->table, '*', '1=1'.$this->dbcon->orderBy(array('filetime DESC'))), true);
            
            $res = array();
            foreach ($images as $image) {
                $imageObj = new image('', '', '', false);
                $imageObj->createFromDbObject($image);
                $res[$image->filename] = $imageObj;
            }
            
            return $res;            
        }
        
        /**
         * Aktualisiert Dateiindex in Datenbank
         * @param int $userId
         */
        public function updateFileIndex($userId) {
            $folderFiles    = $this->getFolderList();
            $dbFiles        = $this->getDatabaseList();
            
            if (!$folderFiles || !count($folderFiles) || count($folderFiles) == count($dbFiles)) {
                return;
            }

            foreach ($folderFiles as $folderFile) {
                if (isset($dbFiles[$folderFile])) continue;                
                $image = new \fpcm\model\files\image(basename($folderFile), '', '', false, true);
                $image->setFiletime(time());
                $image->setUserid($userId);
                
                if (!in_array($image->getMimetype(), image::$allowedTypes) || !in_array(strtolower($image->getExtension()), image::$allowedExts)) {
                    trigger_error("Filetype not allowed in \"$folderFile\".");
                    continue;
                }
                
                if (!$image->exists(true) && !$image->save()) {
                    trigger_error("Unable to save image \"$folderFile\" to database.");
                }
            }
            
            foreach ($dbFiles as $dbFile) {
                if (!$dbFile->existsFolder() && !$dbFile->delete()) {
                    trigger_error("Unable to remove image \"$folderFile\" from database.");
                }
            }
            
            $this->createFilemanagerThumbs($folderFiles);
        }
        
        /**
         * Liefert Anzahl von Dateieinträgen in Datenbank zurück
         * @return int
         * @since FPCM 3.1
         */
        public function getDatabaseFileCount() {
            return $this->dbcon->count($this->table);
        }

        /**
         * Erzeugt Thumbanils für Dateimanager
         * @param arraye $folderFiles
         */
        public function createFilemanagerThumbs($folderFiles = null) {            
            $folderFiles = is_null($folderFiles) ? $this->getFolderList() : $folderFiles;
            include_once \fpcm\classes\loader::libGetFilePath('PHPImageWorkshop', 'ImageWorkshop.php');
            
            foreach ($folderFiles as $folderFile) {    
                $phpImgWsp = \PHPImageWorkshop\ImageWorkshop::initFromPath($folderFile);
                $image = new \fpcm\model\files\image(basename($folderFile), '', '');                
                if (!file_exists($image->getFileManagerThumbnail())) { 
                    if ($image->getWidth() <= 1500 || $image->getHeight() <= 1500) {
                        $phpImgWsp->cropMaximumInPixel(0, 0, "MM");
                    }
                    $phpImgWsp->resizeInPixel(100, 100);
                    $phpImgWsp->save(dirname($image->getFileManagerThumbnail()), basename($image->getFileManagerThumbnail()));

                    if (!file_exists($image->getFileManagerThumbnail())) {
                        trigger_error('Unable to create filemanager thumbnail: '.$image->getFileManagerThumbnail());
                    }
                }                
            }
        }
        
        /**
         * Gibt aktuelle Größe des upload-Ordners in byte zurück
         * @return int
         */
        public function getUploadFolderSize() {     
            return array_sum(array_map('filesize', $this->getFolderList()));
        }
        
    }
?>