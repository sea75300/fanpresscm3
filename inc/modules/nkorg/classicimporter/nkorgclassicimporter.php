<?php

namespace fpcm\modules\nkorg\classicimporter;

class nkorgclassicimporter extends \fpcm\model\abstracts\module {
    
    const mappingRolls = 'rollmapping';
    const mappingUser  = 'usermapping';
    const mappingCategories  = 'categorymapping';
    
    public function runInstall() { 
        return true;
    }

    public function runUninstall() {
        return true;
    }

    public function runUpdate() {
        return true;
    }

}
