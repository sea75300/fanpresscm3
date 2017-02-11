<?php
    namespace fpcm\classes;

    /**
     * Crypt wrapper class
     * 
     * @package fpcm\classes\timer
     * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
     * @copyright (c) 2011-2017, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     * @since FPCM 3.5
     */ 
    final class crypt {

        /**
         *
         * @var string
         */
        protected $method = '';

        /**
         *
         * @var string
         */
        protected $passwd = '';

        /**
         *
         * @var string
         */
        protected $iv     = '';

        /**
         *
         * @var bool
         */
        protected $hasCrypt = false;

        /**
         *
         * @var bool
         */
        protected $hasConfig = false;

        /**
         * Konstruktor
         * @return boolean
         */
        public function __construct() {

            $this->hasCrypt = function_exists('openssl_encrypt') && function_exists('openssl_decrypt');
            if (!$this->hasCrypt || baseconfig::installerEnabled()) {
                return false;
            }

            $conf = baseconfig::getCryptConfig();
            if (!is_array($conf)) {
                trigger_error('Failure while initializing crypt module, no crypt config available!');
                return false;
            }
            
            $this->hasConfig = true;
            foreach ($conf as $key => $value) {
                $this->$key = $value;
            }

        }

        /**
         * Daten verschlüsseln
         * @param string $data
         * @return string
         */
        public function encrypt($data) {

            if (is_array($data) || is_object($data)) {
                $data = json_encode($data);
            }

            if (!$this->hasCrypt) {
                return $this->simpleEncrypt($data);
            }

            $result = openssl_encrypt($data, $this->method, $this->passwd, 0, $this->iv);
            if ($result === false) {
                trigger_error('Crypt error: '.openssl_error_string());
                return $this->simpleEncrypt($data);
            }

            return $result;
        }

        /**
         * Daten entschlüsseln
         * @param string $data
         * @return string
         */
        public function decrypt($data) {

            if (is_array($data) || is_object($data)) {
                $data = json_decode($data);
            }

            if (!$this->hasCrypt) {
                return $this->simpleDecrypt($data);
            }

            $result = openssl_decrypt($data, $this->method, $this->passwd, 0, $this->iv);
            if ($result === false) {
                trigger_error('Crypt error: '.openssl_error_string());
                return $this->simpleDecrypt($data);
            }

            return $result;
        }

        /**
         * Initialisiert Crypt Key und Methode
         * @return bool
         */
        public function initCrypt() {
            
            if (!$this->hasCrypt) {
                return false;
            }

            if ($this->hasConfig) {
                return true;
            }
            
            $method = strtolower(openssl_get_cipher_methods()[OPENSSL_CIPHER_AES_256_CBC]);

            $config = [
                'method' => $method,
                'passwd' => security::createPasswordHash(uniqid(mt_rand()), security::createSalt()),
                'iv'     => substr(uniqid(mt_rand().microtime(true)), 0, openssl_cipher_iv_length($method))
            ];
            
            return file_put_contents(baseconfig::$configDir.'crypt.php', '<?php'.PHP_EOL.' $config = '.var_export($config, true).PHP_EOL.'?>');
            
        }

        /**
         * einfache Verschlüsselung via base64_encode und str_rot13
         * @param string $data
         * @return string
         */
        private function simpleEncrypt($data) {
            return str_rot13(base64_encode(str_rot13(base64_encode(str_rot13(base64_encode($data))))));
        }

        /**
         * einfache Entschlüsselung via base64_decode und str_rot13
         * @param string $data
         * @return string
         */
        private function simpleDecrypt($data) {
            return base64_decode(str_rot13(base64_decode(str_rot13(base64_decode(str_rot13($data))))));
        }

    }

?>