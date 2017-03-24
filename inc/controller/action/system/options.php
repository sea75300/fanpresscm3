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
         *
         * @var array
         */
        protected $newconfig = [];

        /**
         *
         * @var bool
         */
        protected $mainSettingsChanged = false;

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
                $this->newconfig = $this->getRequestVar();

                if (!isset($this->newconfig['twitter_events'])) {
                    $this->newconfig['twitter_events'] = ['create' => 0, 'update' => 0];
                }

                foreach ($this->config->twitter_events as $key => $value) {
                    $this->newconfig['twitter_events'][$key] = (isset($this->newconfig['twitter_events'][$key]) && $this->newconfig['twitter_events'][$key] ? 1 : 0);
                }

                $this->newconfig['twitter_events']            = json_encode($this->newconfig['twitter_events']);
                
                if (!isset($this->newconfig['twitter_data'])) {
                    $this->newconfig['twitter_data'] = ['consumer_key' => '', 'consumer_secret' => '', 'user_token' => '', 'user_secret' => ''];
                }

                foreach ($this->config->twitter_data as $key => $value) {
                    $this->newconfig['twitter_data'][$key] = isset($this->newconfig['twitter_data'][$key]) ? $this->newconfig['twitter_data'][$key] : '';
                }

                foreach ($this->config->smtp_settings as $key => $value) {
                    $this->newconfig['smtp_settings'][$key] = isset($this->newconfig['smtp_settings'][$key]) ? $this->newconfig['smtp_settings'][$key] : '';
                }

                $this->newconfig['twitter_data']                   = json_encode($this->newconfig['twitter_data']);
                $this->newconfig['smtp_settings']                  = json_encode($this->newconfig['smtp_settings']);
                $this->newconfig['articles_limit']                 = (int) $this->newconfig['articles_limit'];
                $this->newconfig['articles_acp_limit']             = (int) $this->newconfig['articles_acp_limit'];
                $this->newconfig['system_cache_timeout']           = (int) $this->newconfig['system_cache_timeout'];
                $this->newconfig['system_session_length']          = (int) $this->newconfig['system_session_length'];
                $this->newconfig['comments_flood']                 = (int) $this->newconfig['comments_flood'];
                $this->newconfig['system_loginfailed_locked']      = (int) $this->newconfig['system_loginfailed_locked'];
                $this->newconfig['comments_markspam_commentcount'] = (int) $this->newconfig['comments_markspam_commentcount'];
                $this->newconfig['file_img_thumb_width']           = (int) $this->newconfig['file_img_thumb_width'];
                $this->newconfig['file_img_thumb_height']          = (int) $this->newconfig['file_img_thumb_height'];
                $this->newconfig['file_list_limit']                = (int) $this->newconfig['file_list_limit'];
                $this->newconfig['system_updates_devcheck']        = (int) $this->newconfig['system_updates_devcheck'];
                $this->newconfig['articles_revisions_limit']       = (int) $this->newconfig['articles_revisions_limit'];
                $this->newconfig['articles_link_urlrewrite']       = (int) $this->newconfig['articles_link_urlrewrite'];
                $this->newconfig['articles_imageedit_persistence'] = (int) $this->newconfig['articles_imageedit_persistence'];
                $this->newconfig['articles_archive_datelimit']     = $this->newconfig['articles_archive_datelimit']
                                                             ? strtotime($this->newconfig['articles_archive_datelimit']) : 0;

                $this->mainSettingsChanged = (hash(\fpcm\classes\security::defaultHashAlgo, json_encode($this->config->smtp_settings)) ===
                                              hash(\fpcm\classes\security::defaultHashAlgo, $this->newconfig['smtp_settings']) ? false : true);

                $this->config->setNewConfig($this->newconfig);
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
            
            $timezones = [];
            
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
            
            $smtpEncryption = array(
                'SSL'  => 'ssl',
                'TLS'  => 'tls',
                'Auto' => 'auto'
            );
            $this->view->assign('smtpEncryption', $smtpEncryption);

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
            
            $smtpActive = false;
            if ($this->config->smtp_enabled) {
                $mail = new \fpcm\classes\email('', '', '');
                $smtpActive = $mail->checkSmtp();
            }
            
            if ($smtpActive && $this->buttonClicked('configSave') && $this->mainSettingsChanged) {                
                $this->view->addNoticeMessage('SYSTEM_OPTIONS_EMAIL_ACTIVE');
            }

            $this->view->assign('smtpActive', $smtpActive);

            $this->view->setViewJsFiles([\fpcm\classes\baseconfig::$jsPath.'options.js']);
            $this->view->addJsVars([
                'showTwitter' => $showTwitter ? 1 : 0,
                'syscheck' => $this->syscheck
            ]);
            
            $this->view->render();            
        }
        
    }
?>