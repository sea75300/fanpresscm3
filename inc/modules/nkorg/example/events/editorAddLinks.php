<?php
    /**
     * Example Module, https://nobody-knows.org
     *
     * nkorg/example event class: editorAddLinks
     * 
     * @version 3.4.0
     * @author Stefan Seehafer <Stefan Seehafer@yourdomain.xyz>
     * @copyright (c) 2016, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     *
     */

    namespace fpcm\modules\nkorg\example\events;

    class editorAddLinks extends \fpcm\model\abstracts\moduleEvent {

        public function run($params = null) {

            $params[] = array(
                'label' => 'Google',
                'value' => 'https://google.de'
            );

            $params[] = array(
                'label' => 'Yahoo',
                'value' => 'https://yahoo.de'
            );

            $params[] = array(
                'label' => 'Bing',
                'value' => 'https://bing.de'
            );

            $params[] = array(
                'label' => 'Wikipedia',
                'value' => 'https://de.wikipedia.org'
            );

            $params[] = array(
                'label' => 'Youtube.com',
                'value' => 'https://youtube.com'
            );

            $params[] = array(
                'label' => 'PHP.net',
                'value' => 'https://php.net'
            );

            $params[] = array(
                'label' => 'Nobody-Knows.org',
                'value' => 'https://nobody-knows.org/fanpress.cm/'
            );

            return $params;
        }

    }