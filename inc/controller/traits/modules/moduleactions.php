<?php
    /**
     * Module actions trait
     * 
     * Module actions trait
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\traits\modules;
    
    /**
     * Modul Aktionen
     * 
     * @package fpcm.controller.traits.modules.moduleactions
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    trait moduleactions {

        /**
         * Modul-Liste in View zuweisen
         * @param \fpcm\model\modules\modulelist $moduleList
         * @param bool $addInfoLayer
         */
        public function assignModules(\fpcm\model\modules\modulelist $moduleList, $addInfoLayer = true) {
            
            $remote  = $moduleList->getModulesRemote();            
            $modules = array_merge($remote, $moduleList->getModulesLocal());
            
            $jsInfo  = array();
            foreach ($modules as $key => $moduleItem) {

                if (isset($remote[$key])) {
                    $moduleItem->setVersionRemote($remote[$key]->getVersionRemote());
                }
                
                $dependencies = $moduleItem->getDependencies();
                
                $depencyData = array();
                if (count($dependencies)) {
                    foreach ($dependencies as $mkey => $version) {
                        $depencyData[] = $mkey.' - '.$this->lang->translate('VERSION').' '.$version;
                    }
                }
                
                $jsInfo[str_replace('/', '', $moduleItem->getKey())] = array(
                    'key'           => $moduleItem->getKey(),
                    'description'   => $moduleItem->getDescription(),
                    'author'        => $moduleItem->getAuthor(),
                    'link'          => $moduleItem->getLink() ? '<a href="'.$moduleItem->getLink().'" target="_blank">'.$moduleItem->getLink().'</a>' : '',
                    'dependencies'  => count($depencyData) ? implode('<br>', $depencyData) : '-',
                    'version'       => $moduleItem->getVersion(),
                    'versionrem'    => $moduleItem->getVersionRemote()
                );
            }

            $this->view->assign('modules', $modules);

            if ($addInfoLayer) {
                $this->view->addJsVars(array('fpcmModuleLayerInfos' => $jsInfo));                  
            }
            
            $this->view->assign('permissionInstall', $this->permissions->check(array('modules' => 'install')));
            $this->view->assign('permissionUninstall', $this->permissions->check(array('modules' => 'uninstall')));
            $this->view->assign('permissionEnable', $this->permissions->check(array('modules' => 'enable')));
        }
    
    }