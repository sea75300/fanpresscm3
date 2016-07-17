/**
 * FanPress CM javascript installer functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

var fpcmInstaller = function () {
    
    var self = this;
    
    this.breakDbInit = false;
    
    this.checkDBData = function() {
        sfields = jQuery('.fpcm-installer-data');
        sParams = {};

        jQuery.each(sfields, function( key, obj ) {
            var objVal  = jQuery(obj).val();
            var objName = jQuery(obj).attr('id').replace('database', '');                                
            sParams[objName] = objVal;
        }); 

        fpcmAjax.action     = 'installer/checkdb';
        fpcmAjax.data       = {dbdata: sParams};
        fpcmAjax.execDone   = "if (fpcmAjax.result == '1' || fpcmAjax.result == 1) { jQuery('#installerform').submit();return true; } else { alert(fpcmInstallerDBTestFailed); }";
        fpcmAjax.async      = false;
        fpcmAjax.post();
        fpcmAjax.reset();
        
        return false;
    };
    
    this.initDatabase = function () {
        jQuery.each(fpcmSqlFiles, function( key, obj ) {

            fpcmJs.appendHtml('#fpcm-installer-execlist', '<p>' + fpcmSqlFileExec.replace('{{tablename}}', key) + '</p>');

            fpcmAjax.action     = 'installer/initdb';
            fpcmAjax.data       = {file: obj};
            fpcmAjax.execDone   = "fpcmInstaller.initDatabaseFailed(fpcmAjax.result);";
            fpcmAjax.async      = false;
            fpcmAjax.post();
            fpcmAjax.reset();
            
            if (self.breakDbInit) {
                return false;
            }            
        });
    };
    
    this.progressbar = function (pgMaxValue, pgValue) {
        fpcm.ui.progressbar('.fpcm-installer-progressbar', {
            max: pgMaxValue,
            value: pgValue
        });
    };
    
    this.initDatabaseFailed = function (result) {        
        if(result == 0){        
            fpcmJs.appendHtml('#fpcm-installer-execlist', "<p class='fpcm-ui-important-text'>FAILED!</p>");
            self.breakDbInit = false;
        }
    };
}