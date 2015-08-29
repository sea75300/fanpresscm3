jQuery(document).ready(function() {
    fpcmJs.setFocus('msgtext');
    
    jQuery('input.nkorg-inactivity-manager-dates').datepicker({
        dateFormat: "yy-mm-dd",
        firstDay: 1,
        showButtonPanel: true,
        showOtherMonths: true,
        selectOtherMonths: true,
        monthNames: fpcmInactivityDatePicker['months'],
        dayNames: fpcmInactivityDatePicker['daysfull'],
        dayNamesShort: fpcmInactivityDatePicker['daysshort'],
        dayNamesMin: fpcmInactivityDatePicker['daysshort']
    });  
});
