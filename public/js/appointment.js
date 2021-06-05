// $("#date,#date2").change(function () {
//     let startTime = $("option:selected", this).attr("start-time");
//     let endTime = $("option:selected", this).attr("end-time");
//     let maxPatients = $("option:selected", this).attr("max");
//     let timeDifference = timeDiff(startTime, endTime);
//     let scheduleTimes = [];
//     $(".timeSlot").html("");
//     $(".timeSlot").append(timeSlot(startTime));
//     quotation = timeDivide(timeDifference, maxPatients);
//     startTimeInSeconds = toSeconds(startTime);
//     for (let i = 1; i < maxPatients; i++) {
//         startTimeInSeconds = startTimeInSeconds + quotation;
//         nextTime = toTime(startTimeInSeconds);
//         $(".timeSlot").append(timeSlot(nextTime));
//     }
// });
$(document).ready(function () {

})
function ajaxcall(url, callback) {
    $.ajax({
        url: url, // server url
        type: 'GET', //POST or GET
        datatype: 'json',
        beforeSend: function() {
            console.log('sending data');
            // do some loading options
        },
        success: function(data) {
            callback(data); // return data in callback
        },

        complete: function() {
            console.log('ajax call complete');
            // success alerts
        },

        error: function(xhr, status, error) {
            console.log(xhr.responseText); // error occur
        }

    });
}
let date = '2021-06-07';

function setTime( startTime, endTime, maxPatients,date) {
    let timeArray = [];

    let root = $('body').attr('url');
    let chekDate = root + '/api/check/' +date;

    ajaxcall(chekDate,function (output){
        console.log('output ',output)
        let timeDifference = timeDiff(startTime, endTime);
        $(".timeSlot").html("");
        if (output.includes(startTime)){
            $(".timeSlot").append(timeSlotInactive(startTime));
        }
        else{
            $(".timeSlot").append(timeSlot(startTime));
        }

        quotation = timeDivide(timeDifference, maxPatients);
        startTimeInSeconds = toSeconds(startTime);
        for (let i = 1; i < maxPatients; i++) {
            startTimeInSeconds = startTimeInSeconds + quotation;
            nextTime = toTime(startTimeInSeconds);
            console.log('check ',output.includes(nextTime))
            if (output.includes(nextTime)){
                $(".timeSlot").append(timeSlotInactive(nextTime));
            }
        else{
                $(".timeSlot").append(timeSlot(nextTime));
            }

        }
    })



}

function timeSlot(time) {
    return (
        `<div class="form-check">
           <input class="form-check-input" value="` +
        time +
        `" type="radio" name="time"><label class="form-check-label" required="required"> ` +
        time +
        ` </label></div>`
    );
}
function timeSlotInactive(time) {
    return (
        `<div class="form-check">
           <input class="form-check-input" value="` +
        time +
        `" type="radio" name="time"  disabled="disabled"><label class="form-check-label text-danger" disabled="disabled"> ` +
        time +
        ` </label></div>`
    );
}

function schedules(id, route) {

    let dates = [];
    $.get(route, function (schedules) {
        schedules.map(function (schedule) {
            dates.push(schedule.date)
        })
        console.log(dates)
    })
    console.log(dates)
    return dates;
}

function setCalendar(schs) {
    $('.date').datepicker("destroy");
    $('.date').datepicker({
        minDate: 0,
        dateFormat: 'yy-mm-dd',
        beforeShowDay: function (date) {
            let f = $.datepicker.formatDate('yy-mm-dd', date)
            if ($.inArray(f, schs) > -1) {
                return [true];
            } else {
                return [false];
            }
        }
    });
}

$('#type').change(function () {
    let type = $(this).val();
    console.log(type)
    if (type == 'Video') {
        $('.meeting_link').css('display', 'unset');
        $('.meeting_link').find('input').attr('required', 'required');
    } else {
        $('.meeting_link').css('display', 'none');
    }
})
