/**
 * FanPress CM javascript module list functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015-2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

var fpcmModulelist = function () {
    
    var self = this;
    
    this.actionButtons = function () {
        jQuery('.fpcm-module-openinfo-link').click(function () {
            self.showDetails(jQuery(this).attr('id'), jQuery(this).text());
            return false;
        });
        
        jQuery('.fpcm-modulelist-singleaction-install').click(function () {
            self.doSingleAction(jQuery(this).attr('id'), 'install');
            return false;
        });
        
        jQuery('.fpcm-modulelist-singleaction-update').click(function () {
            self.doSingleAction(jQuery(this).attr('id'), 'update');
            return false;
        });
        
        jQuery('.fpcm-modulelist-singleaction-enable').click(function () {
            self.doSingleAction(jQuery(this).attr('id'), 'enable');
            return false;
        });
        
        jQuery('.fpcm-modulelist-singleaction-disable').click(function () {
            self.doSingleAction(jQuery(this).attr('id'), 'disable');
            return false;
        });
        
        jQuery('.fpcm-modulelist-singleaction-uninstall').click(function () {
            self.doSingleAction(jQuery(this).attr('id'), 'uninstall');
            return false;
        });
        
        jQuery('#fpcmuireloadpkglist').click(function () {
            fpcmJs.showLoader(true);
            fpcm.ajax.get('modules/loadpkglist', {
                execDone: "fpcmJs.showLoader(false);"
            });
            return false;
        });

        if (noActionButtonAssign) return false;
        
        jQuery('.fpcm-ui-actions-modules').click(function () {
            if (jQuery(this).hasClass('fpcm-noloader')) jQuery(this).removeClass('fpcm-noloader');
            
            var size  = fpcm.ui.getDialogSizes(top, 0.35);

            fpcm.ui.dialog({
                title: fpcm.ui.translate('confirmHL'),
                content: fpcm.ui.translate('confirmMessage'),
                dlWidth: size.width,
                dlButtons: [
                    {
                        text: fpcm.ui.translate('yes'),
                        icon: "ui-icon-check",                    
                        click: function() {
                            var moduleKeys = [];
                            jQuery('.fpcm-list-selectbox:checked').map(function (idx, item) {
                                moduleKeys.push(jQuery(item).val());
                            });

                            if (moduleKeys.length == 0 || !jQuery('#moduleActions').val()) {
                                fpcmJs.showLoader(false);
                                fpcmJs.addAjaxMassage('error', 'SELECT_ITEMS_MSG');
                                return false;
                            }

                            var moduleAction = jQuery('#moduleActions').val();
                            if (moduleAction == 'install') {
                                self.runInstall(moduleKeys);
                            } else if (moduleAction == 'update') {
                                self.runUpdate(moduleKeys);
                            } else {
                                self.runActions(moduleAction, moduleKeys);
                            }

                            jQuery(this).dialog('close');
                        }
                    },
                    {
                        text: fpcm.ui.translate('no'),
                        icon: "ui-icon-closethick",
                        click: function() {
                            jQuery(this).addClass('fpcm-noloader');
                            jQuery('#moduleActions option:selected').prop('selected', false);
                            jQuery('#moduleActions').selectmenu('refresh');
                            jQuery('.fpcm-list-selectbox:checked').prop('checked', false);
                            jQuery(this).dialog('close');
                            fpcmJs.showLoader(false);
                        }
                    }
                ]
            });
        });
        
        return false;  
    };
    
    this.showDetails = function (moduleKey, moduleName) {

        var size = fpcm.ui.getDialogSizes();

        var details = fpcmModuleLayerInfos[moduleKey];
        fpcm.ui.dialog({
            id         : 'modulelist-infos',
            dlWidth    : size.width,
            resizable  : true,
            title      : fpcm.ui.translate('detailsHeadline') + ' « ' + moduleName + ' »',
            dlButtons  : [
                {
                    text: fpcm.ui.translate('close'),
                    icon: "ui-icon-closethick",
                    click: function() {
                        jQuery( this ).dialog( "close" );
                    }
                }
            ],
            dlOnOpen: function (event, ui) {
                jQuery.each(details, function(key, val) {
                    fpcmJs.appendHtml('#fpcm-dialog-modulelist-infos-' + key, '<span>' + val + '</span>');
                });
            },
            dlOnClose: function(event, ui) {
                jQuery.each(details, function(key, val) {
                    jQuery('#fpcm-dialog-modulelist-infos-' + key).empty();
                });
            }
        });
    };
    
    this.runActions = function (moduleAction, moduleKeys) {
        fpcmJs.showLoader(true);
        fpcm.ajax.post('modules/actions', {
            data: {
                keys: fpcm.ajax.toJSON(moduleKeys),
                action:moduleAction
            },
            execDone: function() {
                fpcmJs.showLoader(false);
                fpcmJs.assignHtml('#modules-list-content', fpcm.ajax.getResult('modules/actions'));
                noActionButtonAssign = true;
                fpcmJs.assignButtons();
                fpcm.ui.prepareMessages();
                jQuery('#moduleActions').prop('selectedIndex',0);
                jQuery('#moduleActions').selectmenu('refresh');
            }
        });

    };
    
    this.runInstall = function (moduleKeys) {
        fpcm.ajax.post('modules/actions', {
            data: {
                keys:moduleKeys,
                action:'install'
            },
            async: false,
            execDone: function () {
                fpcmJs.relocate(fpcmActionPath + 'package/modinstall');
            }
        });
    };
    
    this.runUpdate = function (moduleKeys) {

        fpcm.ajax.post('modules/actions', {
            data: {
                keys:moduleKeys,
                action:'update'
            },
            async: false,
            execDone: function () {
                fpcmJs.relocate(fpcmActionPath + 'package/modupdate');
            }
        });

    };
    
    this.doSingleAction = function (object_id, action) {
        jQuery('#cb_' + jQuery.trim(object_id)).prop('checked', true);
        jQuery('#moduleActions option[value="'+ action + '"]').prop('selected',true);
        jQuery('#moduleActions').selectmenu('refresh');
        jQuery('.fpcm-ui-actions-modules').trigger('click');  
    };
    
}

fpcmModulelist = new fpcmModulelist();