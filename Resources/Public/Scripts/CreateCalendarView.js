var first_call;

$(document).ready(function() {

    first_call = true;

    // Set calender title (current month + year)
    $("#current_month").attr("name", moment().locale("en").format("M") + '_' + moment().locale("en").format("YYYY"));

    // Set values of the input fields
    $("[name='month_selector']").val(moment().locale("en").format("M"));
    $("[name='year_input_field']").val(moment().format("YYYY"));

    // initialize current month
    if (typeof jsonEntryValues !== 'undefined' && typeof jsonEventValues !== 'undefined') {
      generateCurrentMonthFields(getCurrentMonth(), getCurrentYear());
    }

    // initialize calendar week nav
    calendarWeekNav();

    // Mark the current day
    markCurrentDay();

    // If clicked on save button, change cursor
    $('.btn-primary').on('click', function() {
        if ($('[name="tx_kical_fecal[new_entry_data][entryTitle]"]').val() !== "" && $('[name="tx_kical_fecal[new_entry_data][entryDate]"]').val() !== "") {
            $('body').css('cursor', 'progress');
        }

        if ($('[name="tx_kical_fecal[newEvent][eventTitle]"]').val() !== "" && $('[name="tx_kical_fecal[newEvent][eventDate]"]').val() !== "") {
            $('body').css('cursor', 'progress');
        }
    });

    // Event listener
    $("#month_plus").on("click", function() {
        addMonth();
    });

    $("#month_minus").on("click", function() {
        removeMonth();
    });

    $("#switch_to_today_btn").on("click", function() {
        goToToday();
    });

    $(".cw_buttons").on("click", function() {
        switchToCalendarWeek($(this).attr("cw"));
    });

    $("[name='year_input_field']").on('propertychange input', function() {
        yearMonthSelector();
    });

    $("[name='month_selector']").on('change', function() {
        yearMonthSelector();
    });
});



/*
 * Generate the month fields with the entries
 */
function generateCurrentMonthFields(current_month, current_year) {

    var days_of_pre_month = 0;
    var days_of_future_month = 1;
    var current_month_days = 0;
    var first_weekday_of_month = 0;
    var calendar_fields_html = "";
    var numerate_day_counter = 0;

    // Adjust format
    if (current_month < 10) {
        current_month = "0" + current_month;
    }

    // Get the number of days in the current month
    current_month_days = moment(current_year + "." + current_month + ".01", "YYYY.MM.DD").daysInMonth();

    // Get the first week day of the current month
    first_weekday_of_month = moment(current_year + "-" + current_month + "-01").locale("en").format("dddd");

    // Generate calendar fields
    calendar_fields_html = '<div id="current_month_wrapper">    <ul id="week_days">      <li class="week_days_header" id="monday_header">Montag</li>      <li class="week_days_header" id="tuesday_header">Dienstag</li>      <li class="week_days_header" id="wednesday_header">Mittwoch</li>      <li class="week_days_header" id="thursday_header">Donnerstag</li>      <li class="week_days_header" id="friday_header">Freitag</li>      <li class="week_days_header" id="saturday_header">Samstag</li>      <li class="week_days_header" id="sunday_header">Sonntag</li>    </ul>    <ul id="first_month_week" class="calendar_rows">      <li class="Monday" number="1"></li>      <li class="Tuesday" number="2"></li>      <li class="Wednesday" number="3"></li>      <li class="Thursday" number="4"></li>      <li class="Friday" number="5"></li>      <li class="Saturday" number="6"></li>      <li class="Sunday" number="7"></li>    </ul>    <ul id="second_month_week" class="calendar_rows">     <li class="Monday" number="8"></li>      <li class="Tuesday" number="9"></li>      <li class="Wednesday" number="10"></li>      <li class="Thursday" number="11"></li>      <li class="Friday" number="12"></li>      <li class="Saturday" number="13"></li>      <li class="Sunday" number="14"></li>    </ul>    <ul id="third_month_week" class="calendar_rows">      <li class="Monday" number="15"></li>      <li class="Tuesday" number="16"></li>      <li class="Wednesday" number="17"></li>      <li class="Thursday" number="18"></li>      <li class="Friday" number="19"></li>      <li class="Saturday" number="20"></li>      <li class="Sunday" number="21"></li>    </ul>    <ul id="fourth_month_week" class="calendar_rows">      <li class="Monday" number="22"></li>      <li class="Tuesday" number="23"></li>      <li class="Wednesday" number="24"></li>      <li class="Thursday" number="25"></li>      <li class="Friday" number="26"></li>      <li class="Saturday" number="27"></li>      <li class="Sunday" number="28"></li>    </ul>    <ul id="fifth_month_week" class="calendar_rows">      <li class="Monday" number="29"></li>      <li class="Tuesday" number="30"></li>      <li class="Wednesday" number="31"></li>      <li class="Thursday" number="32"></li>      <li class="Friday" number="33"></li>      <li class="Saturday" number="34"></li>      <li class="Sunday" number="35"></li>    </ul>  </div>'
    $("#calendar_fields").html(calendar_fields_html);

    // Numerate calendar fields
    numerate_day_counter = 1;
    for (var i = parseInt($("#first_month_week > ." + first_weekday_of_month).attr("number")); numerate_day_counter <= current_month_days; i++) {
        $("[number=" + i + "]").html(numerate_day_counter);

        if (numerate_day_counter < 10) {
            var tmp_day = "0" + numerate_day_counter;
        } else {
            var tmp_day = numerate_day_counter;
        }

        $("[number=" + i + "]").attr("date", tmp_day + "." + current_month + "." + current_year);
        numerate_day_counter++;
    }

    numerate_day_counter = 1;

    // Set the days of the pre-month
    days_of_pre_month = moment(getCurrentYear() + "-" + current_month + "-01").subtract(1, "months").daysInMonth();
    for (var i = parseInt($("#first_month_week > ." + first_weekday_of_month).attr("number")) - 1; i > 0; i--) {
        $("[number=" + i + "]").html(days_of_pre_month);
        $("[number=" + i + "]").addClass("pre_month_fields");

        if (parseInt(current_month) - 1 == 0) {
            $("[number=" + i + "]").attr("date", days_of_pre_month + ".12." + (parseInt(current_year) - 1));
        } else {

            if ((parseInt(current_month) - 1) < 10) {
                var tmp_month = "0" + (parseInt(current_month) - 1);
            } else {
                var tmp_month = (parseInt(current_month) - 1);
            }

            $("[number=" + i + "]").attr("date", days_of_pre_month + "." + tmp_month + "." + current_year);
        }
        days_of_pre_month--;
    }

    // Set the days of the future month
    for (var i = current_month_days; i <= 35; i++) {
        if (!$("[number=" + i + "]").html()) {
            $("[number=" + i + "]").html(days_of_future_month);
            $("[number=" + i + "]").addClass("future_month_fields");

            if (parseInt(current_month) + 1 == 13) {
                $("[number=" + i + "]").attr("date", days_of_future_month + ".01." + (parseInt(current_year) + 1));
            } else {

                if ((parseInt(current_month) + 1) < 10) {
                    var tmp_month = "0" + (parseInt(current_month) + 1);
                } else {
                    var tmp_month = (parseInt(current_month) + 1);
                }

                if (days_of_future_month < 10) {
                    var tmp_day = "0" + days_of_future_month;
                } else {
                    var tmp_day = days_of_future_month;
                }

                $("[number=" + i + "]").attr("date", tmp_day + "." + tmp_month + "." + current_year);
            }
            days_of_future_month++;
        }
    }

    // Go through all entries
    for (var i = 0; i < jsonEntryValues.length; i++) {

        // Get the date of the current entry
        var curr_entry_date = jsonEntryValues[i].entryDate;

        // Format the current entry date
        curr_entry_date = moment(curr_entry_date).format('DD.MM.YYYY');

        // Remove encoding (&amp / %5B / %5D)
        while (jsonEntryValues[i].actionLink.indexOf('%amp;') >= 0 || jsonEntryValues[i].actionLink.indexOf('%5B') >= 0 || jsonEntryValues[i].actionLink.indexOf('%5D') >= 0) {
            jsonEntryValues[i].actionLink = jsonEntryValues[i].actionLink.replace('&amp;', '&');
            jsonEntryValues[i].actionLink = jsonEntryValues[i].actionLink.replace('%5B', '[');
            jsonEntryValues[i].actionLink = jsonEntryValues[i].actionLink.replace('%5D', ']');
        }

        // Generate action links
        // Check if entry has an entry title
        if (jsonEntryValues[i].entryTitle) {

            // Create the content of the calendar fields
            var date_field = $('li[date="' + curr_entry_date + '"]');
            date_field.append('<br /> <a href="" name="' + jsonEntryValues[i].entryTitle + '">' + jsonEntryValues[i].entryTitle + '</a>');

            var entry_link = $('li[date="' + curr_entry_date + '"] > a[name="' + jsonEntryValues[i].entryTitle + '"]');
            entry_link.attr('href', jsonEntryValues[i].actionLink);
            entry_link.attr('title', 'Den Eintrag "' + jsonEntryValues[i].entryTitle + '" bearbeiten.');
        } else {

            // Create the content of the calendar fields
            var date_field = $('li[date="' + curr_entry_date + '"]');
            date_field.append('<br /> <a href="" name="' + jsonEntryValues[i].visitor + '">' + jsonEntryValues[i].visitor + '</a>');

            var entry_link = $('li[date="' + curr_entry_date + '"] > a[name="' + jsonEntryValues[i].visitor + '"]');
            entry_link.attr('href', jsonEntryValues[i].actionLink);
            entry_link.attr('title', 'Den Eintrag "' + jsonEntryValues[i].visitor + '" bearbeiten.');
        }
    }

    // Go through all events
    for (var i = 0; i < jsonEventValues.length; i++) {

        // Get the date of the current entry
        var curr_entry_date = jsonEventValues[i].eventDate;

        // Format the current entry date
        curr_entry_date = moment(curr_entry_date).format('DD.MM.YYYY');

        // Remove encoding (&amp / %5B / %5D)
        while (jsonEventValues[i].actionLink.indexOf('%amp;') >= 0 || jsonEventValues[i].actionLink.indexOf('%5B') >= 0 || jsonEventValues[i].actionLink.indexOf('%5D') >= 0) {
            jsonEventValues[i].actionLink = jsonEventValues[i].actionLink.replace('&amp;', '&');
            jsonEventValues[i].actionLink = jsonEventValues[i].actionLink.replace('%5B', '[');
            jsonEventValues[i].actionLink = jsonEventValues[i].actionLink.replace('%5D', ']');
        }

        // Generate action links
        // Set title and link for the cell
        var date_field = $('li[date="' + curr_entry_date + '"]');
        date_field.append('<br /> <a href="" name="' + jsonEventValues[i].eventTitle + '">' + jsonEventValues[i].eventTitle + '</a>');

        // Set the href attribute for the link
        var entry_link = $('li[date="' + curr_entry_date + '"] > a[name="' + jsonEventValues[i].eventTitle + '"]');
        entry_link.attr('href', jsonEventValues[i].actionLink);
        entry_link.attr('title', 'Den Eintrag "' + jsonEventValues[i].eventTitle + '" bearbeiten.');
    }
}




/*
 * Switch one month forward
 */
function addMonth() {

    var current_month = getCurrentMonth();
    var current_year = getCurrentYear();

    if (current_month == 12) {
        current_month = 1;
        current_year++;
    } else {
        current_month++;
    }

    if (current_month < 10) {
        current_month = "0" + current_month;
    }

    $("#current_month").attr("name", moment(current_year + "-" + current_month + "-01").format("M") + '_' + current_year);
    $("#current_month > h1").html(moment(current_year + "-" + current_month + "-01").format("MMMM") + " " + current_year);

    generateCurrentMonthFields(getCurrentMonth(), getCurrentYear());
}




/*
 * Switch one month back
 */
function removeMonth() {
    var current_month = getCurrentMonth();
    var current_year = getCurrentYear();

    if (current_month == 1) {
        current_month = 12;
        current_year--;
    } else {
        current_month--;
    }

    if (current_month < 10) {
        current_month = "0" + current_month;
    }

    $("#current_month").attr("name", moment(current_year + "-" + current_month + "-01").format("M") + '_' + current_year);
    $("#current_month > h1").html(moment(current_year + "-" + current_month + "-01").format("MMMM") + " " + current_year);

    generateCurrentMonthFields(getCurrentMonth(), getCurrentYear());
}




/*
/ Switch to the month of the current day
*/
function goToToday() {
    generateCurrentMonthFields(moment().format("M"), moment().format("YYYY"));
    $("#current_month").attr("name", moment().format("M") + '_' + moment().format("YYYY"));
    $("#current_month > h1").html(moment().format("MMMM") + " " + moment().format("YYYY"));
}





/*
 * Create the calendar week navigation fields
 */
function calendarWeekNav() {

    var weeks_in_current_year = moment(getCurrentYear() + "-01-01").weeksInYear();

    for (var i = 1; i <= weeks_in_current_year; i++) {
        $("#calendar_week_nav > ul").html($("#calendar_week_nav > ul").html() + "<li><button class='btn btn-default cw_buttons' cw=" + i + ">" + i + "</button></li>");
    }
}





/*
 * Switch to the month of the selected calendar week
 */
function switchToCalendarWeek(cw) {

    // Get the current year
    var current_year = getCurrentYear();

    // Get the month of the selected calendar week
    var month = parseInt(moment().year(current_year).day("Monday").week(cw).format("M"));

    // Check if the calendar week is in the next or the previous year
    if (parseInt(moment().year(current_year).day("Monday").week(cw).format("YYYY")) == (current_year - 1)) {

        // Go 1 year back
        current_year--;
        month = 12;
    } else if (parseInt(moment().year(current_year).day("Monday").week(cw).format("YYYY")) == (current_year + 1)) {

        // Go 1 year further
        current_year++;
        month = 1;
    }





    // Generate the calendar fields
    generateCurrentMonthFields(month, current_year);

    // Moment.js adjustment
    if (month < 10) {
        month = "0" + month;
    }

    // GUI finishing
    $("#current_month").attr("name", moment(current_year + "-" + month + "-01").format("M") + '_' + current_year);
    $("#current_month > h1").html(moment(current_year + "-" + month + "-01").format("MMMM") + " " + current_year);
}




function yearMonthSelector() {

    var month_selector_val = $("[name='month_selector']").val();
    var year_input_field_val = $("[name='year_input_field']").val();

    if (month_selector_val !== null && year_input_field_val.length == 4) {

        generateCurrentMonthFields(month_selector_val, year_input_field_val);

        // Moment.js adjustment
        if (month_selector_val < 10) {
            month_selector_val = "0" + month_selector_val;
        }

        $("#current_month").attr("name", moment(year_input_field_val + "-" + month_selector_val + "-01").format("M") + '_' + year_input_field_val);
        $("#current_month > h1").html(moment(year_input_field_val + "-" + month_selector_val + "-01").format("MMMM") + " " + year_input_field_val);
    }
}


/**
 * Get the current selected month
 */
function getCurrentMonth() {
    if ($('#current_month').length > 0) {
        return parseInt($("#current_month").attr("name").split("_")[0]);
    }
}

/**
 * Get the current selected year
 */
function getCurrentYear() {
    if ($('#current_month').length > 0) {
        return parseInt($("#current_month").attr("name").split("_")[1]);
    }
}

function markCurrentDay() {

    var current_day = moment().format('DD');
    var current_month = moment().format('MM');
    var current_year = moment().format('YYYY');

    // Check if day, month and year are not empty
    try {
        if (!current_day || !current_month || !current_year) {
            throw ('Current day, month or year could not be found.');
        }
    } catch (e) {
        throw new Error(e);
        return;
    }

    // Check if the calendar field was found
    try {
        var current_day_field = $('[date="' + current_day + '.' + current_month + '.' + current_year + '"]');
        if (current_day_field.length === 0) {
            throw ('Calendar field from today could not be found.');
        }
    } catch (e) {
        throw new Error(e);
        return;
    }

    // Change font color of day number
    current_day_field.css('color', '#F64300');
}
