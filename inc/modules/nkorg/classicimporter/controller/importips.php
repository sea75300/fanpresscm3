<?php
    namespace fpcm\modules\nkorg\classicimporter\controller;
    
    class importips extends common {
        
        /**
         * Controller-Processing
         */
        public function process() {
            parent::process();

            $db = $this->initDatabase();
            
            if (!$db) die('0');
            
            $data = $db->fetch($db->select('bannedips', '*'), true);
            
            foreach ($data as $value) {
                
                $ip = new \fpcm\model\ips\ipaddress();
                $ip->setIpaddress($value->ip);
                $ip->setIptime($value->bann_time);
                $ip->setUserid($value->bann_by);
                $ip->setNocomments(1);
                
            }
                
            die('1');
        }

    }
?>