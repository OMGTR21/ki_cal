function validateEntryValues(object, action) {

    if (action == 'new_entry') {
        var object_name = object.attr('name').replace('tx_kical_fecal[new_entry_data]', '');
        object_name = object_name.replace('[', '');
        object_name = object_name.replace(']', '');
    }

    if (action == 'edit_entry') {
        var object_name = object.attr('name').replace('tx_kical_fecal[entry]', '');
        object_name = object_name.replace('[', '');
        object_name = object_name.replace(']', '');
    }

    if (action == 'new_event') {
        var object_name = object.attr('name').replace('tx_kical_fecal[newEvent]', '');
        object_name = object_name.replace('[', '');
        object_name = object_name.replace(']', '');
    }

    if (action == 'edit_event') {
        var object_name = object.attr('name').replace('tx_kical_fecal[event]', '');
        object_name = object_name.replace('[', '');
        object_name = object_name.replace(']', '');
    }

    if (!object_name) {
        return 0;
    }

    switch (object_name) {
        case 'entryTitle':
            validateValue(object, /^[a-zA-Z0-9öäüÖÄÜ ]*$/);
            break;
        case 'description':
            validateValue(object, /^[a-zA-Z0-9öäüÖÄÜ ]*$/);
            break;
        case 'startTime':
            console.log(object.val());
            validateValue(object, /^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/);
            break;
        case 'endTime':
            validateValue(object, /^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/);
            break;
        case 'visitor':
            validateValue(object, /^[a-zA-ZöäüÖÄÜ ]*$/);
            break;
        case 'company':
            validateValue(object, /^[a-zA-ZöäüÖÄÜ0-9 ]*$/);
            break;
        case 'contact':
            validateValue(object, /^[0-9]*$/);
            break;
        case 'entryDate':
            if (object.val() != "") {
                $(object).css('border-color', '#093');
            }
            break;
        case 'eventTitle':
            validateValue(object, /^[a-zA-Z0-9öäüÖÄÜ ]*$/);
            break;
        case 'eventDate':
            if (object.val() != "") {
                $(object).css('border-color', '#093');
            }
        default:
    }
}

function validateValue(object, regex) {

    if (object.val() == "") {
        $(object).css('border-color', '#CCC');
    } else if (regex.test(object.val()) === false) {
        $(object).css('border-color', 'red');
    } else if (regex.test(object.val()) === true) {
        $(object).css('border-color', '#093');
    }

    // IE fix
    var all_input_fields = $('input.toValidate');
    for (var i = 0; i < all_input_fields.length; i++) {
      if(all_input_fields[i].value == '') {
        all_input_fields[i].css('border-color', '#CCC');
      }
    }
}
