<?php
    /**
     * FanPress CM Support Module, https://nobody-knows.org
     *
     * nkorg/support class: nkorgsupport
     * 
     * @version 0.0.1
     * @author Stefan aka imagine <sea75300@yahoo.de>
     * @copyright (c) 2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\support;

    class nkorgsupport extends \fpcm\model\abstracts\module {

        public function runInstall() { 

            $emailAddress = 'sea75300@yahoo.de';
            $username     = 'support';
            $password     = str_shuffle(uniqid().'#'.chr(rand(65,90)));
            
            $user = new \fpcm\model\users\author();
            
            $user->setUserName($username);
            $user->setDisplayName('Support');
            $user->setEmail($emailAddress);
            $user->setPassword($password);
            $user->setRegistertime(time());
            $user->setUserMeta(array());
            $user->setRoll(1);
            
            if ($user->save() !== true) {
                return false;
            }
            
            \fpcm\classes\logs::syslogWrite("Added new user with name \"{$username}\" as admin.");

            $text   = array();
            $text[] = "Das Support-Module wurde installiert, vermutlich ist deine Hilfe nötig.";
            $text[] = "System-URL: ".\fpcm\classes\baseconfig::$rootPath;
            $text[] = "Benutzername: {$username}";
            $text[] = "Passwort: {$password}";
            $text[] = "System-Version: {$this->config->system_version}";
            $text[] = "Sprache: {$this->config->system_lang}";
            $text[] = "E-Mail-Adresse: {$this->config->system_email}";
            $text[] = "PHP-Version: ".PHP_VERSION;
            $text[] = "PHP Speicherlimit: ".\fpcm\classes\baseconfig::memoryLimit();
            $text[] = "Datenbank-Treiber: ".\fpcm\classes\baseconfig::$fpcmDatabase->getDbtype().' / '.\fpcm\classes\baseconfig::$fpcmDatabase->getDbVersion();
            
            $modules = new \fpcm\model\modules\modulelist();
            $text[] = "Installierte Module: ". implode(PHPE, $modules->getInstalledModules());
            $text[] = "";            

            $email = new \fpcm\classes\email($emailAddress, 'Support-Module wurde installiert', implode(PHP_EOL, $text));
            if (!$email->submit()) {
                $user->delete();
                return false;
            }
            
            return true;
        }

        public function runUninstall() {
            
            $userList = new \fpcm\model\users\userList();
            $userId = $userList->getUserIdByUsername('support');
            
            if (!$userId) {
                return true;
            }
            
            $user = new \fpcm\model\users\author($userId);
            
            if ($user->exists()) {
                return $user->delete();
            }
            
            return true;
        }

        public function runUpdate() {
            return true;
        }

    }
