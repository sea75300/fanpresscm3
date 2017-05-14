if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.nkorg_inactivitymanager = {

    init: function() {
        fpcm.ui.setFocus('msgtext');
        fpcm.ui.datepicker('input.nkorg-inactivity-manager-dates', {
            showButtonPanel: true,
            showOtherMonths: true,
            selectOtherMonths: true
        });
    }

};