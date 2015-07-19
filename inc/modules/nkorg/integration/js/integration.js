jQuery(document).ready(function() {
    jQuery('.fpcm-tabs-accordion-integration').accordion({
        header: 'h2',
        heightStyle: 'content'
    });
    
    jQuery('#btnSpacerArticleTitle').click(function() {
        fpcmJs.showLoader(true);

        jQuery.ajax({
            url: fpcmAjaxActionPath + 'nkorg/integration/articletitle',
            type: 'POST',
            data: {
                spacertext: jQuery('#spacertextArticle').val()
            }
        })
        .done(function(result) {
            fpcmJs.showLoader(false);
            jQuery('#codearticletitle').text(result);
        })
        .fail(function() {
            alert(fpcmAjaxErrorMessage);
        });
        
        return false;
    });
    
    jQuery('#btnSpacerPageTitle').click(function() {
        fpcmJs.showLoader(true);

        jQuery.ajax({
            url: fpcmAjaxActionPath + 'nkorg/integration/pagetitle',
            type: 'POST',
            data: {
                spacertext: jQuery('#spacertextPage').val()
            }
        })
        .done(function(result) {
            fpcmJs.showLoader(false);
            jQuery('#codepagetitle').text(result);
        })
        .fail(function() {
            alert(fpcmAjaxErrorMessage);
        });
        
        return false;
    });
});