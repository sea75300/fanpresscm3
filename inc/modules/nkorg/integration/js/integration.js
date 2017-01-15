jQuery(document).ready(function() {

    fpcm.ui.accordion('.fpcm-tabs-accordion-integration');
    
    jQuery('#btnSpacerArticleTitle').click(function() {
        fpcmJs.showLoader(true);

        fpcm.ajax.post('nkorg/integration/articletitle', {
            data: {
                spacertext: jQuery('#spacertextArticle').val()
            },
            execDone: function () {
                fpcmJs.showLoader(false);
                fpcmJs.assignText('#codearticletitle', fpcm.ajax.getResult('nkorg/integration/articletitle'));
            }
        });

        return false;
    });

    jQuery('#btnSpacerPageTitle').click(function() {
        fpcmJs.showLoader(true);

        fpcm.ajax.post('nkorg/integration/pagetitle', {
            data: {
                spacertext: jQuery('#spacertextPage').val()
            },
            execDone: function () {
                fpcmJs.showLoader(false);
                fpcmJs.assignText('#codepagetitle', fpcm.ajax.getResult('nkorg/integration/articletitle'));
            }
        });

        return false;
    });
    
    jQuery('#btnLimitListSetShowArticles').click(function() {
        fpcmJs.showLoader(true);
        jQuery('#limitListSpanShowArticles').text(jQuery('#limitListShowArticles').val());
        fpcmJs.showLoader(false);
        
        return false;
    });
    
    jQuery('#btnLimitListSetShowArchive').click(function() {
        fpcmJs.showLoader(true);
        jQuery('#limitListSpanShowArchive').text(jQuery('#limitListShowArchive').val());
        fpcmJs.showLoader(false);
        
        return false;
    });
    
    jQuery('#btnShowLatestLimitSet').click(function() {
        fpcmJs.showLoader(true);
        jQuery('#showLatestLimitSpan').text(jQuery('#showLatestLimit').val());
        fpcmJs.showLoader(false);
        
        return false;
    });
    
});