/**
 * FanPress CM UI Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2016, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.ui = {

    load: function() {

        jQuery(document).tooltip();

        fpcmJs.assignButtons();
        this.assignSelectmenu();
        this.initInputShadow();
        this.spinner('input.fpcm-ui-spinner');
        this.tabs('.fpcm-tabs-general');
        this.accordion('.fpcm-tabs-accordion');
        this.highlightModule();

    },
    
    translate: function(langVar) {
        
        return fpcmLang[langVar] === undefined ? langVar : fpcmLang[langVar];

    },

    actionButtonsGenreal: function() {
        jQuery('.fpcm-ui-actions-genreal').click(function () {
            if (jQuery(this).hasClass('fpcm-noloader')) jQuery(this).removeClass('fpcm-noloader');
            if (!confirm(fpcm.ui.translate('confirmMessage'))) {
                jQuery(this).addClass('fpcm-noloader');
                return false;
            }            
        });
    },
    
    assignBlankIconButton: function() {        
        this.button('.fpcm-ui-button-blank', {
            icon: "ui-icon-blank",
            showLabel: false
        });        
    },
    
    assignCheckboxes: function() {
        jQuery('#fpcmselectall').click(function(){
            jQuery('.fpcm-select-allsub').prop('checked', false);
            if (jQuery(this).prop('checked'))        
                jQuery('.fpcm-list-selectbox').prop('checked', true);
            else
                jQuery('.fpcm-list-selectbox').prop('checked', false);
        });
        jQuery('#fpcmselectalldraft').click(function(){
            jQuery('.fpcm-select-allsub-draft').prop('checked', false);
            if (jQuery(this).prop('checked'))        
                jQuery('.fpcm-list-selectbox-draft').prop('checked', true);
            else
                jQuery('.fpcm-list-selectbox-draft').prop('checked', false);
        });
        jQuery('#fpcmselectalltrash').click(function(){
            jQuery('.fpcm-select-allsub-trash').prop('checked', false);
            if (jQuery(this).prop('checked'))        
                jQuery('.fpcm-list-selectbox-trash').prop('checked', true);
            else
                jQuery('.fpcm-list-selectbox-trash').prop('checked', false);
        });
        jQuery('#fpcmselectallrevisions').click(function(){
            if (jQuery(this).prop('checked'))        
                jQuery('.fpcm-list-selectboxrevisions').prop('checked', true);
            else
                jQuery('.fpcm-list-selectboxrevisions').prop('checked', false);
        });
    },
    
    assignCheckboxesSub: function() {
        jQuery('.fpcm-select-allsub').click(function(){
            var subValue = jQuery(this).val();
            if (jQuery(this).prop('checked'))        
                jQuery('.fpcm-list-selectbox-sub' + subValue).prop('checked', true);
            else
                jQuery('.fpcm-list-selectbox-sub' + subValue).prop('checked', false);
        });
    },
    
    assignSelectmenu: function() {
        
        this.selectmenu('.fpcm-ui-input-select');
        this.selectmenu(
            '.fpcm-ui-input-select-articleactions', {
            position: {
                my: 'left top',
                at: 'left bottom+5',
                offset: null
            }
        });    

        this.selectmenu(
            '.fpcm-ui-input-select-moduleactions', {
            position: {
                my: 'left top',
                at: 'left bottom+5',
                offset: null
            }
        });

    },

    
    initInputShadow: function() {
        jQuery('.fpcm-ui-input-wrapper input[type=text]').focus(function () {
            jQuery(this).parent().parent().addClass('fpcm-ui-input-wrapper-hover');
        }).blur(function () {
            jQuery(this).parent().parent().removeClass('fpcm-ui-input-wrapper-hover');
        });

        jQuery('.fpcm-ui-input-wrapper input[type=password]').focus(function () {
            jQuery(this).parent().parent().addClass('fpcm-ui-input-wrapper-hover');
        }).blur(function () {
            jQuery(this).parent().parent().removeClass('fpcm-ui-input-wrapper-hover');
        });

        jQuery('.fpcm-ui-input-wrapper textarea').focus(function () {
            jQuery(this).parent().parent().addClass('fpcm-ui-input-wrapper-hover');
        }).blur(function () {
            jQuery(this).parent().parent().removeClass('fpcm-ui-input-wrapper-hover');
        });  
    },
    
    accordion: function(elemClassId, params) {
        
        if (params === undefined) {
            params = {
                header: "h2",
                heightStyle: "content"
            };
        }  

        jQuery(elemClassId).accordion(params);

    },
    
    tabs: function(elemClassId, params) {

        if (params === undefined) params = {};        
        jQuery(elemClassId).tabs(params);

    },

    spinner: function(elemClassId, params) {

        if (params === undefined) params = {};        
        jQuery(elemClassId).spinner(params);

    },

    datepicker: function(elemClassId, params) {

        if (params === undefined) {
            params = {};
        }

        params.showButtonPanel   = true,
        params.showOtherMonths   = true,
        params.selectOtherMonths = true,
        params.monthNames        = this.translate('jquiDateMonths'),
        params.dayNames          = this.translate('jquiDateDays'),
        params.dayNamesShort     = this.translate('jquiDateDaysShort'),
        params.dayNamesMin       = this.translate('jquiDateDaysShort')
        params.firstDay          = 1;
        params.dateFormat        = "yy-mm-dd";

        jQuery(elemClassId).datepicker(params);

    },

    selectmenu: function(elemClassId, params) {

        if (params === undefined) {
            params = {};
        }

        if (params.width === undefined) {
            params.width = 200;
        }

        jQuery(elemClassId).selectmenu(params);

    },
    
    checkboxradio: function(elemClassId, params, onClick) {

        if (params === undefined) {
            params = {};
        }

        jQuery(elemClassId).checkboxradio(params);

        if (onClick === undefined) {
            return;
        }
        
        jQuery(elemClassId).click(onClick);
    },
    
    controlgroup: function(elemClassId, params) {
      
        if (params === undefined) {
            params = {};
        }

        jQuery(elemClassId).controlgroup(params);

    },
    
    button: function(elemClassId, params, onClick) {

        if (params === undefined) {
            params = {};
        }

        jQuery(elemClassId).button(params);
        
        if (onClick === undefined) {
            return;
        }
        
        jQuery(elemClassId).click(onClick);

    },
    
    progressbar: function(elemClassId, params){

        if (params === undefined) {
            params = {};
        }

        jQuery(elemClassId).progressbar(params);
    },
    
    dialog: function(params) {

        if (params.title === undefined) {
            params.title = '';
        }

        if (params.id === undefined) {
            params.id = (new Date()).getTime();
        }

        if (params.dlWidth === undefined) {
            params.dlWidth = 500;
        }

        if (params.modal === undefined) {
            params.modal = true;
        }

        if (params.resizable === undefined) {
            params.resizable = false;
        }
        
        var dialogId = 'fpcm-dialog-'+  params.id;
        if (params.content !== undefined) {
            fpcmJs.appendHtml('#fpcm-body', '<div class="fpcm-ui-dialog-layer fpcm-editor-dialog" id="' + dialogId + '">' +  params.content + '</div>');
        }
        
        var dlParams = {};
        dlParams.width    = params.dlWidth;        
        dlParams.modal    = params.modal;
        dlParams.resizable= params.resizable;
        dlParams.title    = params.title;
        dlParams.buttons  = params.dlButtons;
        dlParams.open     = params.dlOnOpen;
        dlParams.close    = params.dlOnClose;
        
        if (params.dlHeight !== undefined) {
            dlParams.height   = params.dlHeight;            
        }
        
        if (params.dlMinWidth !== undefined) {
            dlParams.minWidth   = params.dlMinWidth;
        }
        
        if (params.dlMinHeight !== undefined) {
            dlParams.minHeight   = params.dlMinHeight;            
        }
        
        jQuery('#' + dialogId).dialog(dlParams);

        return true;
    },
    
    highlightModule: function() {

        if (window.fpcmNavigationActiveItemId !== undefined) {
            jQuery('#' + window.fpcmNavigationActiveItemId).addClass('fpcm-menu-active');
        }

        var active_submenu_items = jQuery('#fpcm-navigation-ul ul.fpcm-submenu').find('li.fpcm-menu-active');
        if (active_submenu_items.length !== undefined && active_submenu_items.length) {
            jQuery(active_submenu_items[0]).parent().parent().addClass('fpcm-menu-active');
        }

    }
    
}