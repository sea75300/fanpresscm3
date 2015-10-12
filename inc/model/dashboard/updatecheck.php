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
            $this->content  = implode(PHP_EOL, array('<table class="fpcm-ui-table">', implode(PHP_EOL, $this->tableContent),'</table>'));
            $this->name     = 'syscheck';            
            $this->position = 3;
            $this->height   = 0;
        }
        
        /**
         * Check ausführen
         */
        protected function runCheck() {

            $systemUpdates = new \fpcm\model\updater\system();
            $checkRes      = $systemUpdates->checkUpdates();
            
            $content  = '<tr><td>';
            $content .= ($checkRes === true)
                      ? '<div class="fpcm-dashboard-updates-current">'.$this->language->translate('UPDATE_VERSIONCHECK_CURRENT', array( '{{releaseinfo}}' => $systemUpdates->getRemoteData('notice') ? '<a href="'.$systemUpdates->getRemoteData('notice').'">Release-Infos</a>' : '', '{{releasmsg}}' => $systemUpdates->getRemoteData('message'))).'</div>'
                      : (($checkRes === \fpcm\model\updater\system::SYSTEMUPDATER_FURLOPEN_ERROR)
                            ? '<div class="fpcm-dashboard-updates-outdated">'.$this->language->translate('UPDATE_NOTAUTOCHECK').'</div>'
                            : '<div class="fpcm-dashboard-updates-outdated">'.$this->language->translate('UPDATE_VERSIONCHECK_NEW', array('{{versionlink}}' => 'index.php?module='.FPCM_CONTROLLER_SYSUPDATES)).'</div>');

            $content .= '</td></tr>';            
            $this->tableContent[] = $content;
            
            $moduleUpdates = new \fpcm\model\updater\modules();
            $checkRes      = $moduleUpdates->checkUpdates();
            
            $content  = '<tr><td>';
            $content .= ($checkRes === true)
                      ? '<div class="fpcm-dashboard-updates-outdated">'.$this->language->translate('UPDATE_MODULECHECK_NEW').'</div>'
                      : (($checkRes === \fpcm\model\updater\modules::MODULEUPDATER_FURLOPEN_ERROR)
                            ? '<div class="fpcm-dashboard-updates-outdated">'.$this->language->translate('UPDATE_MODULECHECK_FAILED').'</div>'
                            : '<div class="fpcm-dashboard-updates-current">'.$this->language->translate('UPDATE_MODULECHECK_CURRENT').'</div>');

            $content .= '</td></tr>';            
            $this->tableContent[] = $content;
        }
    }