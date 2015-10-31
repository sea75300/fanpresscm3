<?php
    /**
     * Recent articles Dashboard Container
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\model\editor;

    /**
     * Recent articles dashboard container object
     * 
     * @package fpcm.model.dashboard
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class htmlEditor extends \fpcm\model\abstracts\articleEditor {

        /**
         * Liefert zu ladender CSS-Dateien für Editor zurück
         * @return array
         */
        public function getCssFiles() {
            return $this->fileLib->getCmCssFiles();
        }

        /**
         * Pfad der Editor-Template-Datei
         * @return string
         */
        public function getEditorTemplate() {
            return \fpcm\classes\baseconfig::$viewsDir.'articles/editors/html.php';
        }

        /**
         * Liefert zu ladender Javascript-Dateien für Editor zurück
         * @return array
         */ 
        public function getJsFiles() {

            return array_merge(
                $this->fileLib->getCmJsFiles(),
                array(
                    \fpcm\classes\loader::libGetFileUrl('leela-colorpicker', 'leela.colorpicker-1.0.2.jquery.min.js'),
                    \fpcm\classes\baseconfig::$jsPath.'editor.js'
                )
            );
        }

        /**
         * Array von Javascript-Variablen, welche in Editor-Template genutzt werden
         * @return array
         */
        public function getJsVars() {

            $editorHtmlColors = array(
                '#000000','#993300','#333300','#003300','#003366','#00007f','#333398','#333333',
                '#800000','#ff6600','#808000','#007f00','#007171','#0000e8','#5d5d8b','#6c6c6c',
                '#f00000','#e28800','#8ebe00','#2f8e5f','#30bfbf','#3060f1','#770077','#8d8d8d',                
                '#f100f1','#f0c000','#eeee00','#00f200','#00efef','#00beee','#8d2f5e','#b5b5b5',
                '#ed8ebe','#efbf8f','#e8e88b','#bbeabb','#bcebeb','#89b6e4','#b88ae6','#ffffff'
            );
            
            return array(
                'fpcmCmColors'                  => $editorHtmlColors,
                'fmcEditorKeyShortcutsEnabled'  => true,
                'fpcmEditorAutocompleteLinks'   => $this->getEditorLinks(),
                'fpcmEditorAutocompleteImages'  => $this->getFileList()
            );
        }

        /**
         * Array von Variablen, welche in Editor-Template genutzt werden
         * @return array
         */
        public function getViewVars() {
            
            $editorStyles = $this->getEditorStyles();

            $vars = array(
                'aligns' => array(
                    'left'      => 'left',
                    'center'    => 'center',
                    'right'     => 'right'
                ),
                'targets' => array(
                    '_blank'  => '_blank',
                    '_top'    => '_top',
                    '_self'   => '_self',
                    '_parent' => '_parent'
                ),
                'editorStyles' => $editorStyles,
                'cssClasses'   => $editorStyles,
                'extraButtons' => array(
                    array('title' => '', 'id' => '', 'class' => '', 'htmltag' => '', 'icon' => '')
                )
            );

            $vars = $this->events->runEvent('editorInitHtml', $vars);
            array_shift($vars['extraButtons']);
            
            return $vars;
        }
        
    }