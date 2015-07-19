jQuery(document).ready(function() {
    fpcmJs.setFocus('fpcm2_path');
    
    jQuery('.fpcm-tabs-accordion-importer').accordion({
        disabled: true,
        header: 'h2',
        heightStyle: 'content'
    });
    
    jQuery('.fpcm-ui-checkdata-text').hide();
    
    jQuery('.fpcm-classicimporter-importstart').click(function() {
        fpcmJs.showLoader(true);

        var obj = jQuery(this); 

        var fn = obj.attr('id');
        
        var ajaxAction = 'checkConnection';
        var moduleUrl  = '';
        switch (fn) {
            case 'btnStartImportCategories' :
                ajaxAction = 'importcategories';
                moduleUrl = 'categories/list';
                break;
            case 'btnStartImportRolls' :
                ajaxAction = 'importrolls';
                moduleUrl = 'users/list';
                break;
            case 'btnStartImportUser' :
                ajaxAction = 'importusers';
                moduleUrl = 'users/list';
                break;
            case 'btnStartImportIps' :
                ajaxAction = 'importips';
                moduleUrl = 'ips/list';
                break;
            case 'btnStartImportSmileys' :
                ajaxAction = 'importsmileys';
                moduleUrl = 'smileys/list';
                break;
            case 'btnStartImportUploads' :
                ajaxAction = 'filescheckcount';
                moduleUrl = 'files/list&mode=2';
                break;
            case 'btnStartImportArticles' :
                ajaxAction = 'articlescheckcount';
                moduleUrl = 'articles/listall';
                break;
            case 'btnStartImportConfig' :
                ajaxAction = 'importconfig';
                moduleUrl = 'system/options';
                break;
            case 'btnStartImportTemplates' :
                ajaxAction = 'importtemplates';
                moduleUrl = 'system/templates';
                break;
            case 'btnSystemReset' :
                ajaxAction = 'resetSystem';
                break;
        }

        var openButton = '<a href="' + fpcmActionPath + moduleUrl + '" class="fpcm-ui-button fpcm-buttons" target="_blank">' + fpcmClassicImporterOpenModule + '</a>';

        jQuery.ajax({
            url: fpcmAjaxActionPath + 'nkorg/classicimporter/' + ajaxAction,
            type: 'POST',
            data: {
                path: jQuery('#fpcm2_path').val()
            }
        })
        .done(function(result) {
            fpcmJs.showLoader(false);

            switch (fn) {
                case 'btnCheckPath' :
                    if(result == 1) {
                        fpcmJs.addAjaxMassage('notice', 'FPCM_CLASSICIMPORTER_IMPORT_FPCM2_CHECKPATH_OK');
                        jQuery('.fpcm-tabs-accordion-importer').accordion( "option", "disabled", false);
                    } else if(result == 2) {
                        fpcmJs.addAjaxMassage('error', 'FPCM_CLASSICIMPORTER_IMPORT_FPCM2_CHECKPATH_VERSION');
                    } else {
                        fpcmJs.addAjaxMassage('error', 'FPCM_CLASSICIMPORTER_IMPORT_FPCM2_CHECKPATH_ERR');
                    }
                    break;
                case 'btnSystemReset' :
                    if(result == 1) {
                        fpcmJs.addAjaxMassage('notice', 'FPCM_CLASSICIMPORTER_RESET_OK');
                    } else {
                        fpcmJs.addAjaxMassage('error', 'FPCM_CLASSICIMPORTER_RESET_ERROR');
                    }
                    break;
                case 'btnStartImportUploads' :                    
                    importUploads(result, obj, openButton);
                    break;
                case 'btnStartImportArticles' :                    
                    importArticles(result, obj, openButton);
                    break;
                default :
                    jQuery(obj).parent().parent().find('.fpcm-ui-checkdata-text').remove();
                    if(result == 1) {
                        fpcmJs.addAjaxMassage('notice', 'FPCM_CLASSICIMPORTER_IMPORT_FINISHED');
                        jQuery(obj).parent().parent().find('.fpcm-ui-checkdata-text').append(openButton).fadeIn();
                        fpcmJs.assignButtons();
                    } else {
                        fpcmJs.addAjaxMassage('error', 'FPCM_CLASSICIMPORTER_IMPORT_ERROR');
                    }                    
                    break;
            }
        })
        .fail(function() {
            alert(fpcmAjaxErrorMessage);
        });
    });
});

function importArticles(result, obj, openButton){
    
    jQuery('.fpcm-ui-progressbar').remove();
    jQuery(obj).parent().parent().find('.fpcm-ui-checkdata-text').find('.fpcm-ui-button ').remove();

    var data = jQuery.parseJSON(jQuery.trim(result));               

    if(!data.length) {
        fpcmJs.addAjaxMassage('error', 'FPCM_CLASSICIMPORTER_IMPORT_ERROR');
        return false;
    }

    var progbar = '<div class="fpcm-ui-progressbar"><div class="fpcm-ui-progressbar-label"></div></div>';

    jQuery(obj).parent().parent().append(progbar).fadeIn();
    jQuery('.fpcm-ui-progressbar').progressbar({
        max: data.length,
        value: 0
    });   

    var i = 1;
    var res = true;
    for (i = 1; i<=data.length; i++) {
        var elem = data[i-1];

        jQuery.ajax({
            url: fpcmAjaxActionPath + 'nkorg/classicimporter/articlesimport',
            type: 'POST',
            async: false,
            data: {
                path: jQuery('#fpcm2_path').val(),
                id: elem.id
            },
            beforeSend : function() {
                jQuery('.fpcm-ui-progressbar-label').html(fpcmClassicImporterArticleID + ' ' + elem.id + ': ' + elem.titel);
            }
        })
        .done(function(result) {
            if (result == 0) {
                fpcmJs.addAjaxMassage('error', 'FPCM_CLASSICIMPORTER_IMPORT_ERROR');
                res = false;
            } else {
                jQuery('.fpcm-ui-progressbar').progressbar('option', 'value', i);
                res = true;
            }

        });
    }

    jQuery('.fpcm-ui-progressbar-label').remove();

    if (res) {
        fpcmJs.addAjaxMassage('notice', 'FPCM_CLASSICIMPORTER_IMPORT_FINISHED');
        jQuery(obj).parent().parent().find('.fpcm-ui-checkdata-text').append(openButton).fadeIn();        
    }
    fpcmJs.assignButtons();
}

function importUploads(result, obj, openButton){
    
    jQuery('.fpcm-ui-progressbar').remove();
    jQuery(obj).parent().parent().find('.fpcm-ui-checkdata-text').find('.fpcm-ui-button ').remove();

    var data = jQuery.parseJSON(jQuery.trim(result));               

    if(!data.length) {
        fpcmJs.addAjaxMassage('error', 'FPCM_CLASSICIMPORTER_IMPORT_ERROR');
        return false;
    }

    var progbar = '<div class="fpcm-ui-progressbar"><div class="fpcm-ui-progressbar-label"></div></div>';

    jQuery(obj).parent().parent().append(progbar).fadeIn();
    jQuery('.fpcm-ui-progressbar').progressbar({
        max: data.length,
        value: 0
    });   

    var i = 1;
    var res = true;
    for (i = 1; i<=data.length; i++) {
        var elem = data[i-1];

        jQuery.ajax({
            url: fpcmAjaxActionPath + 'nkorg/classicimporter/filesimport',
            type: 'POST',
            async: false,
            data: {
                path: jQuery('#fpcm2_path').val(),
                file: elem.filename,
                id: elem.id                            
            },
            beforeSend : function() {
                jQuery('.fpcm-ui-progressbar-label').text(elem.filename);
            }
        })        
        .done(function(result) {
            if (result == 0) {
                fpcmJs.addAjaxMassage('error', 'FPCM_CLASSICIMPORTER_IMPORT_ERROR');
                res = false;
            } else {
                jQuery('.fpcm-ui-progressbar').progressbar('option', 'value', i);
                res = true;
            }
        });
    }

    if (res) {
        fpcmJs.addAjaxMassage('notice', 'FPCM_CLASSICIMPORTER_IMPORT_FINISHED');
        jQuery(obj).parent().parent().find('.fpcm-ui-checkdata-text').append(openButton).fadeIn();        
    }
    
    jQuery('.fpcm-ui-progressbar-label').remove();
    fpcmJs.assignButtons();
}