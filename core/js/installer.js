/**
 * FanPress CM javascript installer functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

var fpcmInstaller = function () {
    
    var self = this;
    
    this.checkDBData = function() {
        sfields = jQuery('.fpcm-installer-data');
        sParams = {};

        jQuery.each(sfields, function( key, obj ) {
            var objVal  = jQuery(obj).val();
            var objName = jQuery(obj).attr('id').replace('database', '');                                
            sParams[objName] = objVal;
        }); 
        
        jQuery.ajax({
            url: fpcmAjaxActionPath + 'installer/checkdb',
            type: 'POST',
            async: false,
            data: {
                'dbdata': sParams
            }
        })
        .done(function(result) {
            if (result == '1' || result == 1) {
                jQuery('#installerform').submit();
                return true;
            } else {
                alert(fpcmInstallerDBTestFailed);
            }
        })
        .fail(function() {
            alert('Error during AJAX request');
        });
        
        return false;
    };
    
    this.initDatabase = function () {
        jQuery.each(fpcmSqlFiles, function( key, obj ) {

            jQuery('#fpcm-installer-execlist').append('<p>' + fpcmSqlFileExec.replace('{{tablename}}', key) + '</p>');
            
            jQuery.ajax({
                url: fpcmAjaxActionPath + 'installer/initdb',
                type: 'POST',
                async: false,
                data: {
                    'file': obj
                }
            })
            .done(function(result) {
                if (result == '0' || result == 0) {
                    jQuery('#fpcm-installer-execlist').append('<p class="fpcm-ui-important-text">FAILED!</p>');
                    return false;
                }
            })
            .fail(function() {
                alert('Error during AJAX request');
            });            
        });         
    };
    
    this.progressbar = function (pgMaxValue, pgValue) {
        jQuery('.fpcm-installer-programmbar').progressbar({
            max: pgMaxValue,
            value: pgValue
        });
    };    
}