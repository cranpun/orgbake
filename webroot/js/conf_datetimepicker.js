function initMoment() {
    moment.locale("ja");
}

function initDateTimePicker(cssselector) {
    var now = moment();
    //now.add(1, "days");
    $(cssselector).datetimepicker({
        format: "YYYY-MM-DD HH:mm",
        defaultDate: now.format("YYYY-MM-DD HH:mm"),
        dayViewHeaderFormat: "YYYY-MM",
        sideBySide: true
    });
}

function initDatePicker(cssselector) {
    var now = moment();
    //now.add(1, "days");
    $(cssselector).datetimepicker({
        format: "YYYY-MM-DD",
        defaultDate: now.format("YYYY-MM-DD"),
        dayViewHeaderFormat: "YYYY-MM",
        sideBySide: true
    });
}
