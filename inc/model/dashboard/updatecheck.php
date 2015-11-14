<?php
    /**
     * Update check Dashboard Container
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\model\dashboard;

    /**
     * Update check dashboard container object
     * 
     * @package fpcm.model.dashboard
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class updatecheck extends \fpcm\model\abstracts\dashcontainer {
        
        /**
         * ggf. nötige Container-Berechtigungen
         * @var array
         */
        protected $checkPermissions = array('system' => 'options', 'system' => 'update');
        
        /**
         * Container table content
         * @var array
         */
        protected $tableContent = array();

        /**
         * Konstruktor
         */
        public function __construct() {            
            parent::__construct();   
            
            $this->runCheck();

            $this->headline = $this->language->translate('SYSTEM_UPDATE');
            $this->content  = implode(PHP_EOL, array('<table class="fpcm-ui-table fpcm-dashboard-updates">', implode(PHP_EOL, $this->tableContent),'</table>'));
            $this->name     = 'syscheck';            
            $this->position = 3;
            $this->height   = 0;
        }
        
        /**
         * Check ausführen
         */
        protected function runCheck() {

            $this->getSystemUpdateStatus();
            $this->getModuleUpdateStatus();
        }
        
        /**
         * Liefert System-Update-HTML zurück
         * @since FPCM 3.1.0
         */
        private function getSystemUpdateStatus()
        {
            $systemUpdates = new \fpcm\model\updater\system();
            $checkRes      = $systemUpdates->checkUpdates();
            
            switch ($checkRes) {
                case true :
                    $iconClass   = 'fa-check';
                    $statusClass = 'fpcm-dashboard-updates-current';
                    $statusText  = $this->language->translate('UPDATE_VERSIONCHECK_CURRENT', array( '{{releaseinfo}}' => $systemUpdates->getRemoteData('notice') ? '<a href="'.$systemUpdates->getRemoteData('notice').'">Release-Infos</a>' : '', '{{releasmsg}}' => $systemUpdates->getRemoteData('message')));
                    break;
                case \fpcm\model\updater\system::SYSTEMUPDATER_FURLOPEN_ERROR:
                    $iconClass   = 'fa-exclamation-triangle';
                    $statusClass = 'fpcm-dashboard-updates-checkerror';
                    $statusText  = $this->language->translate('UPDATE_NOTAUTOCHECK');
                    break;
                default:
                    $iconClass   = 'fa-cloud-download';
                    $statusClass = 'fpcm-dashboard-updates-outdated';
                    $statusText  = $this->language->translate('UPDATE_VERSIONCHECK_NEW', array('{{versionlink}}' => 'index.php?module='.FPCM_CONTROLLER_SYSUPDATES));
                    break;
            }

            $this->renderTable($iconClass, $statusClass, $statusText);
        }
        
        /**
         * Liefert Modul-Update-HTML zurück
         * @since FPCM 3.1.0
         */
        private function getModuleUpdateStatus() {
            
            $moduleUpdates = new \fpcm\model\updater\modules();
            $checkRes      = $moduleUpdates->checkUpdates();            
            
            switch ($checkRes) {
                case true :
                    $iconClass   = 'fa-cloud-download';
                    $statusClass = 'fpcm-dashboard-updates-outdated';
                    $statusText  = $this->language->translate('UPDATE_MODULECHECK_NEW');
                    break;
                case \fpcm\model\updater\modules::MODULEUPDATER_FURLOPEN_ERROR:
                    $iconClass   = 'fa-exclamation-triangle';
                    $statusClass = 'fpcm-dashboard-updates-checkerror';
                    $statusText  = $this->language->translate('UPDATE_MODULECHECK_FAILED');
                    break;
                default:
                    $iconClass   = 'fa-check';
                    $statusClass = 'fpcm-dashboard-updates-current';
                    $statusText  = $this->language->translate('UPDATE_MODULECHECK_CURRENT');
                    break;
            }

            $this->renderTable($iconClass, $statusClass, $statusText);
        }
        
        /**
         * Tabellenzeile rendern
         * @param string $statusClass
         * @param string $statusText
         * @param string $iconClass
         * @since FPCM 3.1.0
         */
        private function renderTable($iconClass, $statusClass, $statusText) {
            $content  = '<tr><td>';
            $content .= '<span class="fa-stack fa-fw fa-2x '.$statusClass.'"><span class="fa fa-square fa-stack-2x"></span><span class="fa '.$iconClass.' fa-stack-1x fa-inverse"></span></span>';            
            $content .= '</td><td>';
            $content .= $statusText;
            $content .= '</td></tr>';
            $this->tableContent[] = $content;
        }
    }