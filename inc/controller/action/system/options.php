<?php
    /**
     * Option edit controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\controller\action\system;
    
    class options extends \fpcm\controller\abstracts\controller {

        use \fpcm\controller\traits\common\timezone;
        
        /**
         *
         * @var \fpcm\model\view\acp
         */
        protected $view;
        
        /**
         *
         * @var \fpcm\model\system\config
         */
        protected $config;
        
        /**
         *
         * @var int
         */
        protected $syscheck = 0;

        /**
         * Konstruktor
         */
        public function __construct() {
            parent::__construct();
            
            $this->checkPermission = array('system' => 'options');
            
            $this->view   = new \fpcm\model\view\acp('options', 'system');
            $this->config = new \fpcm\model\system\config(false, false);
        }
        
        /**
         * Request-Handler
         * @return boolean
         */
        public function request() {
            
            if ($this->getRequestVar('syscheck')) {
                $this->syscheck = $this->getRequestVar('syscheck', array(9));
            }
            
            if ($this->buttonClicked('configSave') && !$this->checkPageToken()) {
                $this->view->addErrorMessage('CSRF_INVALID');
                return true;
            }
            
            if ($this->buttonClicked('configSave')) {                
                $newconfig = $this->getRequestVar();

                if (!isset($newconfig['twitter_events'])) {
                    $newconfig['twitter_events'] = array('create' => 0, 'update' => 0);
                }

                foreach ($this->config->twitter_events as $key => $value) {
                    $newconfig['twitter_events'][$key] = (isset($newconfig['twitter_events'][$key]) && $newconfig['twitter_events'][$key] ? 1 : 0);
                }

                $newconfig['twitter_events']            = json_encode($newconfig['twitter_events']);
                
                if (!isset($newconfig['twitter_data'])) {
                    $newconfig['twitter_data'] = array('consumer_key' => '', 'consumer_secret' => '', 'user_token' => '', 'user_secret' => '');
                }

                foreach ($this->config->twitter_data as $key => $value) {
                    $newconfig['twitter_data'][$key] = isset($newconfig['twitter_data'][$key]) ? $newconfig['twitter_data'][$key] : '';
                }

                $newconfig['twitter_data']           = json_encode($newconfig['twitter_data']);
                
                $newconfig['articles_limit']                 = (int) $newconfig['articles_limit'];
                $newconfig['articles_acp_limit']             = (int) $newconfig['articles_acp_limit'];
                $newconfig['system_cache_timeout']           = (int) $newconfig['system_cache_timeout'];
                $newconfig['system_session_length']          = (int) $newconfig['system_session_length'];
                $newconfig['comments_flood']                 = (int) $newconfig['comments_flood'];
                $newconfig['system_loginfailed_locked']      = (int) $newconfig['system_loginfailed_locked'];
                $newconfig['comments_markspam_commentcount'] = (int) $newconfig['comments_markspam_commentcount'];
                $newconfig['file_img_thumb_width']           = (int) $newconfig['file_img_thumb_width'];
                $newconfig['file_img_thumb_height']          = (int) $newconfig['file_img_thumb_height'];
                $newconfig['file_list_limit']                = (int) $newconfig['file_list_limit'];
                $newconfig['system_updates_devcheck']        = (int) $newconfig['system_updates_devcheck'];
                $newconfig['articles_revisions_limit']       = (int) $newconfig['articles_revisions_limit'];
                $newconfig['articles_link_urlrewrite']       = (int) $newconfig['articles_link_urlrewrite'];
                $newconfig['articles_archive_datelimit']     = $newconfig['articles_archive_datelimit']
                                                             ? strtotime($newconfig['articles_archive_datelimit']) : 0;

                $this->config->setNewConfig($newconfig);
                if (!$this->config->update()) {
                    $this->view->addErrorMessage('SAVE_FAILED_OPTIONS');
                    return true;
                }
                
                $this->view->addNoticeMessage('SAVE_SUCCESS_OPTIONS');
            }
            
            if ($this->buttonClicked('twitterDisconnect')) {
                $twitterData = $this->config->twitter_data;
                
                $twitterData['user_token'] = '';
                $twitterData['user_secret'] = '';
                
                $this->config->setNewConfig(array(
                    'twitter_data'   => json_encode($twitterData),
                    'twitter_events' => json_encode(array('create' => 0, 'update' => 0))
                ));
                if (!$this->config->update()) {
                    $this->view->addNoticeMessage('SAVE_FAILED_OPTIONS');
                    return true;
                }
                
                $this->view->addNoticeMessage('SAVE_SUCCESS_OPTIONS');
            }            
            
            return true;
        }
        
        /**
         * Controller-Processing
         * @return boolean
         */
        public function process() {
            if (!parent::process()) return false;
            
            $timezones = array();
            
            foreach ($this->getTimeZones() as $area => $zones) {
                foreach ($zones as $zone) {
                    $timezones[$area][$zone] = $zone;
                }
            }
            
            $this->view->assign('timezoneAreas', $timezones);            
            
            $modes = array(
                $this->lang->translate('SYSTEM_OPTIONS_USEMODE_IFRAME') => 0,
                $this->lang->translate('SYSTEM_OPTIONS_USEMODE_PHPINCLUDE') => 1
            );
            $this->view->assign('systemModes', $modes);
            
            $editor = array(
                $this->lang->translate('SYSTEM_OPTIONS_NEWS_EDITOR_STD') => 0,
                $this->lang->translate('SYSTEM_OPTIONS_NEWS_EDITOR_CLASSIC') => 1
            );
            $this->view->assign('editors', $editor);            
            
            $sorts = array(
                $this->lang->translate('SYSTEM_OPTIONS_NEWS_BYINTERNALID')  => 'id',
                $this->lang->translate('SYSTEM_OPTIONS_NEWS_BYAUTHOR')      => 'createuser',
                $this->lang->translate('SYSTEM_OPTIONS_NEWS_BYWRITTENTIME') => 'createtime',
                $this->lang->translate('SYSTEM_OPTIONS_NEWS_BYEDITEDTIME')  => 'changetime',
            );
            $this->view->assign('sorts', $sorts);
            
            $sortOrders = array(
                $this->lang->translate('SYSTEM_OPTIONS_NEWS_ORDERASC')  => 'ASC',
                $this->lang->translate('SYSTEM_OPTIONS_NEWS_ORDERDESC') => 'DESC'
            );
            $this->view->assign('sortsOrders', $sortOrders);
            
            $templates = new \fpcm\model\pubtemplates\templatelist();
            
            $this->view->assign('articleTemplates', $templates->getArticleTemplates());
            $this->view->assign('commentTemplates', $templates->getCommentTemplates());            

            $this->view->assign('globalConfig', $this->config->getData());
            $this->view->assign('languages', array_flip($this->lang->getLanguages()));
            
            $notify = array(
                $this->lang->translate('SYSTEM_OPTIONS_COMMENT_NOTIFY_GLOBAL') => 0,
                $this->lang->translate('SYSTEM_OPTIONS_COMMENT_NOTIFY_AUTHOR') => 1,
                $this->lang->translate('SYSTEM_OPTIONS_COMMENT_NOTIFY_ALL')    => 2
            );
            $this->view->assign('notify', $notify);

            $this->view->assign('articleLimitList', \fpcm\model\system\config::getArticleLimits());
            $this->view->assign('articleLimitListAcp', \fpcm\model\system\config::getAcpArticleLimits());
            $this->view->assign('defaultFontsizes', \fpcm\model\system\config::getDefaultFontsizes());
            
            $this->view->addJsVars(array(
                'fpcmDtMasks' => \fpcm\classes\baseconfig::$dateTimeMasks
            ));
            
            $twitter = new \fpcm\model\system\twitter();
            
            $showTwitter = $twitter->checkRequirements();

            $this->view->assign('showTwitter', $showTwitter);
            $this->view->assign('twitterIsActive', $twitter->checkConnection());
            $this->view->assign('twitterScreenName', $twitter->getUsername());

            $this->view->setViewJsFiles(array(\fpcm\classes\baseconfig::$jsPath.'options.js'));
            $this->view->addJsVars(array('showTwitter' => $showTwitter ? 1 : 0, 'syscheck' => $this->syscheck));
            
            $this->view->render();            
        }
        
    }
?>