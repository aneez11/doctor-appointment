function readURL(input) {
    let id = $(input).attr("target");
    console.log(id);
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            $("#" + id).attr("src", e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function () {
    $("#table_id").DataTable();
});

//time difference
function timeDiff(start, end) {
    start = start.split(":");
    end = end.split(":");
    var startDate = new Date(0, 0, 0, start[0], start[1], 0);
    var endDate = new Date(0, 0, 0, end[0], end[1], 0);
    var diff = endDate.getTime() - startDate.getTime();
    var hours = Math.floor(diff / 1000 / 60 / 60);
    diff -= hours * 1000 * 60 * 60;
    var minutes = Math.floor(diff / 1000 / 60);

    return (
        (hours < 9 ? "0" : "") +
        hours +
        ":" +
        (minutes < 9 ? "0" : "") +
        minutes
    );
}

//time Divider
function timeDivide(time, divider) {
    let allSecond = toSeconds(time);
    let division = allSecond / divider;

    return division;
}

//to seconds
function toSeconds(time) {
    time = time.split(":");
    h = time[0];
    m = time[1];
    s = 0;

    return h * 3600 + m * 60 + s;
}
//backTotime
function toTime(seconds) {
    let NewTime = [];
    NewTime[0] = Math.floor(seconds / 3600);
    s = Math.floor((seconds % 3600) / 60);
    if (s == 0) {
        NewTime[1] = "00";
    }
    if (s < 10) {
        NewTime[1] = "0" + s;
    } else NewTime[1] = s;
    // NewTime[2] = Math.floor(seconds % 3600) %60;
    return NewTime.join(":");
}
