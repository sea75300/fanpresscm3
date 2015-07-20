<?php

namespace fpcm\modules\nkorg\modulecreator\model;

class moduleclass extends \fpcm\model\abstracts\staticModel {

    protected $draftContent;

    public function __construct() {
        $this->draftContent = file_get_contents(__DIR__.'/moduleclass.txt');
    }

    public function parse(array $data) {

        $replacements        = array(
            '{{eventname}}'  => $data['eventname'],
            '{{modulename}}' => $data['modulename'],
            '{{vendor}}'     => $data['vendor'],
            '{{modulekey}}'  => $data['modulekey'],
            '{{version}}'    => $data['version'],
            '{{infolink}}'   => $data['infolink'],
            '{{author}}'     => $data['author'],
            '{{year}}'       => date('Y')
        );
        
        return str_replace(array_keys($replacements), array_values($replacements), $this->draftContent);
        
    }

}
