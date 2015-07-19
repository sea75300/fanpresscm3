<?php
    /**
     * FanPress CM example captcha plugin model
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace fpcm\modules\nkorg\examplemodule\model;

    class examplePlugin extends \fpcm\model\abstracts\spamCaptcha {

        protected $text = 'Enter FanPress CM Testtext';

        public function checkAnswer() {

            if (!\fpcm\classes\http::get('answer') || \fpcm\classes\http::get('answer') != $this->text) {
                return false;
            }
            
            return true;
        }
        
        public function createPluginInput() {
            return '<input type="text" class="fpcm-pub-textinput" name="answer" value="The text...">';
        }

        public function createPluginText() {
            if ($this->session->exists()) return $this->text;
        }        

        public function checkExtras() {
            return true;
        }


    }
