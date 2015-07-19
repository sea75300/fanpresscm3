<?php
    namespace fpcm\modules\nkorg\classicimporter\controller;
    
    class importconfig extends common {
        
        /**
         * Controller-Processing
         */
        public function process() {
            parent::process();

            $db = $this->initDatabase();
            
            if (!$db) die('0');
            
            $data = $db->fetch($db->select('config', '*'), true);
            $combined = array();
            foreach ($data as $value) {
                $combined[$value->config_name] = $value->config_value;                
            }            
            
            $newconfig = array();
            $newconfig['system_email']        = $combined['system_mail'];
            $newconfig['system_url']          = $combined['system_url'];
            $newconfig['system_dtmask']       = $combined['timedate_mask'];
            $newconfig['system_css_path']     = $combined['useiframecss'];
            $newconfig['articles_sort']       = $combined['sort_news'];
            $newconfig['articles_sort_order'] = $combined['sort_news_order'];

            $newconfig['comments_antispam_question'] = $combined['anti_spam_question'];
            $newconfig['comments_antispam_answer']   = $combined['anti_spam_answer'];            
            $newconfig['files_img_thumb_minwidth']   = $combined['max_img_thumb_size_x'];
            $newconfig['files_img_thumb_minheight']  = $combined['max_img_thumb_size_y'];
            $newconfig['file_img_thumb_width']       = $combined['max_img_size_x'];
            $newconfig['file_img_thumb_height']      = $combined['max_img_size_y'];
                
            $newconfig['twitter_data']['consumer_key']      = $combined['twitter_consumer_key'];
            $newconfig['twitter_data']['consumer_secret']   = $combined['twitter_consumer_secret'];
            $newconfig['twitter_data']['user_token']        = $combined['twitter_access_token'];
            $newconfig['twitter_data']['user_secret']       = $combined['twitter_access_token_secret'];
            $newconfig['twitter_events']['create']          = 1;
            $newconfig['twitter_events']['update']          = 0;
            
            $newconfig['twitter_data']   = json_encode($newconfig['twitter_data']);
            $newconfig['twitter_events'] = json_encode($newconfig['twitter_events']);
            
            $this->config->setNewConfig($newconfig);
            if (!$this->config->update()) die('0');
            
            die('1');
        }

    }
?>