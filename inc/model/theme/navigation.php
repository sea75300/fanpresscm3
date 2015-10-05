<?php
    /**
     * ACP Menu Objekt
     * 
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\theme;

    /**
     * ACP Menu Objekt
     * 
     * @package fpcm.model.theme
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    class navigation extends \fpcm\model\abstracts\staticModel {

        /**
         * Permissions-Objekt
         * @var \fpcm\model\system\permissions
         */
        private $permissions;

        /**
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();
            
            $this->cache = new \fpcm\classes\cache('navigation_'.$this->session->getUserId());
        }

        /**
         * Navigation rendern
         * @return array
         */
        public function render() {
            
            if (!$this->cache->isExpired()) {
                return $this->cache->read();
            }
            
            $this->permissions = new \fpcm\model\system\permissions($this->session->getCurrentUser()->getRoll());

            $navigation = $this->getNavigation();
            $navigation = $this->events->runEvent('navigationRender', $navigation);

            foreach ($navigation as &$moduleOptions) {
                $moduleOptions = $this->checkPermissions($moduleOptions);            
            }

            $this->cache->write($navigation, $this->config->system_cache_timeout);
            
            return $navigation;
        }

        /**
         * Berechtigungen für Zugriff auf Module prüfen
         * @param array $navigation
         * @return array
         */
        private function checkPermissions($navigation) {            
            foreach ($navigation as $key => &$value) {
                if (isset($value['submenu']) && count($value['submenu'])) {
                    $value['submenu'] = $this->checkPermissions($value['submenu']);
                }
                if (isset($value['permission']) && count($value['permission'])) {
                    if (!$this->permissions->check($value['permission'])) {
                        unset($navigation[$key]);
                    }
                }                
            }

            return $navigation;
        }

        /**
         * Baut Navigation auf
         * @return array
         */
        private function getNavigation() {
            $navigationArray = array(
                'dashboard'      => array(
                    array(
                        'url'               => 'system/dashboard',
                        'description'       => $this->language->translate('HL_DASHBOARD'),
                        'icon'              => 'fa fa-home fa-fw',
                        'class'             => '',
                        'id'                => ''                        
                    )
                ),
                'addnews'      => array(
                    array(
                        'url'               => 'articles/add',
                        'permission'        => array('article' => 'add'),
                        'description'       => $this->language->translate('HL_ARTICLE_ADD'),
                        'icon'              => 'fa fa-pencil fa-fw',
                        'class'             => '',
                        'id'                => ''                        
                    )
                ),
                'editnews'      => array(
                    array(
                        'url'               => '#',
                        'permission'        => array('article' => 'edit'),
                        'description'       => $this->language->translate('HL_ARTICLE_EDIT'),
                        'icon'              => 'fa fa-book fa-fw',
                        'submenu'           => self::editorSubmenu(),
                        'class'             => 'fpcm-navigation-noclick',
                        'id'                => 'nav-id-editnews'                        
                    )
                ),
                'comments'   => array(
                    array(
                        'url'               => 'comments/list',
                        'permission'        => array('article' => array('editall', 'edit'), 'comment' => array('editall', 'edit')),
                        'description'       => $this->language->translate('HL_COMMENTS_MNG'),
                        'icon'              => 'fa fa-comments fa-fw',
                        'class'             => '',
                        'id'                => ''                        
                    )
                ),
                'filemanager'   => array(
                    array(
                        'url'               => 'files/list&mode=1',
                        'permission'        => array('article' => 'add', 'article' => 'edit'),
                        'description'       => $this->language->translate('HL_FILES_MNG'),
                        'icon'              => 'fa fa-folder-open fa-fw',
                        'class'             => '',
                        'id'                => ''                        
                    )
                ),
                'options'       => array(
                    array(
                        'url'               => '#',
                        'permission'        => array('system' => 'options'),
                        'description'       => $this->language->translate('HL_OPTIONS'),
                        'icon'              => 'fa fa-cog fa-fw',
                        'class'             => 'fpcm-navigation-noclick',
                        'id'                => '',
                        'submenu'           => $this->optionSubmenu()
                    )
                ),
                'modules'       => array(
                    array(
                        'url'               => '#',
                        'permission'        => array('system' => 'options', 'modules' => 'configure'),
                        'description'       => $this->language->translate('HL_MODULES'),
                        'icon'              => 'fa fa-plug fa-fw',
                        'class'             => 'fpcm-navigation-noclick',
                        'id'                => '',
                        'submenu'           => $this->modulesSubmenu()                     
                    )
                ),
                'help'          => array(
                    array(
                        'url'               => 'system/help',
                        'description'       => $this->language->translate('HL_HELP'),
                        'icon'              => 'fa fa-question-circle fa-fw',
                        'class'             => '',
                        'id'                => ''                        
                    )
                ),
                'after'         => array()
            );

            $eventResult = $this->events->runEvent('navigationAdd', $navigationArray);

            if (!$eventResult) return $navigationArray;

            return array_merge($navigationArray, $eventResult);

        }

        /**
         * Erzeugt Submenü für News bearbeiten
         * @return array
         */
        private function editorSubmenu() {
            return array(
                array(
                    'url'               => 'articles/listall',
                    'permission'        => array('article' => 'edit', 'article' => 'editall'),
                    'description'       => $this->language->translate('HL_ARTICLE_EDIT_ALL'),
                    'class'             => '',
                    'id'                => '',
                    'icon'              => 'fa fa-book fa-fw'
                ),
                array(
                    'url'               => 'articles/listactive',
                    'permission'        => array('article' => 'edit'),
                    'description'       => $this->language->translate('HL_ARTICLE_EDIT_ACTIVE'),
                    'class'             => '',
                    'id'                => '',
                    'icon'              => 'fa fa-book fa-fw'
                ),
                array(
                    'url'               => 'articles/listarchive',
                    'permission'        => array('article' => 'edit', 'article' => 'editall', 'article' => 'archive'),
                    'description'       => $this->language->translate('HL_ARTICLE_EDIT_ARCHIVE'),
                    'class'             => '',
                    'id'                => '',
                    'icon'              => 'fa fa-book fa-fw'
                )                
            );
        }

        /**
         * Erzeugt Optionen-Submenü
         * @return array
         */
        private function optionSubmenu() {
            return array(
                array(
                    'url'               => 'system/options',
                    'permission'        => array('system' => 'options'),
                    'description'       => $this->language->translate('HL_OPTIONS_SYSTEM'),
                    'class'             => '',
                    'id'                => '',
                    'icon'              => 'fa fa-cog fa-fw'
                ),
                array(
                    'url'               => 'users/list',
                    'permission'        => array('system' => 'users', 'system' => 'rolls'),
                    'description'       => $this->language->translate('HL_OPTIONS_USERS'),
                    'class'             => '',
                    'id'                => '',
                    'icon'              => 'fa fa-users fa-fw'
                ),
                array(
                    'url'               => 'system/permissions',
                    'permission'        => array('system' => 'permissions'),
                    'description'       => $this->language->translate('HL_OPTIONS_PERMISSIONS'),
                    'class'             => '',
                    'id'                => '',
                    'icon'              => 'fa fa-key fa-fw'
                ),
                array(
                    'url'               => 'ips/list',
                    'permission'        => array('system' => 'options'),
                    'description'       => $this->language->translate('HL_OPTIONS_IPBLOCKING'),
                    'class'             => '',
                    'id'                => '',
                    'icon'              => 'fa fa-unlock fa-fw'
                ),
                array(
                    'url'               => 'categories/list',
                    'permission'        => array('system' => 'categories'),
                    'description'       => $this->language->translate('HL_CATEGORIES_MNG'),
                    'class'             => '',
                    'id'                => '',
                    'icon'              => 'fa fa-file-o fa-fw'
                ),
                array(
                    'url'               => 'system/templates',
                    'permission'        => array('system' => 'templates'),
                    'description'       => $this->language->translate('HL_OPTIONS_TEMPLATES'),
                    'class'             => '',
                    'id'                => '',
                    'icon'              => 'fa fa-code fa-fw'
                ),
                array(
                    'url'               => 'smileys/list',
                    'permission'        => array('system' => 'smileys'),
                    'description'       => $this->language->translate('HL_OPTIONS_SMILEYS'),
                    'class'             => '',
                    'id'                => '',
                    'icon'              => 'fa fa-smile-o fa-fw'
                ),
                array(
                    'url'               => 'system/logs',
                    'permission'        => array('system' => 'options'),
                    'description'       => $this->language->translate('HL_LOGS'),
                    'class'             => '',
                    'id'                => '',
                    'icon'              => 'fa fa-exclamation-triangle fa-fw'
                )

            );
        }

        /**
         * Erzeugt Submenü in Module
         * @return array
         */
        private function modulesSubmenu() {
            $items = array(
                array(
                    'url'               => 'modules/list',
                    'permission'        => array('modules' => 'install', 'modules' => 'uninstall', 'modules' => 'configure', 'modules' => 'enable'),
                    'description'       => $this->language->translate('HL_MODULES_MNG'),                    
                    'class'             => '',
                    'id'                => '',
                    'spacer'            => true,
                    'icon'              => 'fa fa-plug fa-fw'
                )
            );

            $eventResult = $this->events->runEvent('navigationSubmenuModulesAdd', $items);

            if (count($eventResult) == count($items)) {            
                $items[0]['spacer'] = false;
                return $items;
            }

            return $eventResult;
        }    
    }
