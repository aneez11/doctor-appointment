$("#date").change(function () {
    let startTime = $("option:selected", this).attr("start-time");
    let endTime = $("option:selected", this).attr("end-time");
    let maxPatients = $("option:selected", this).attr("max");
    let timeDifference = timeDiff(startTime, endTime);
    let scheduleTimes = [];
    $(".timeSlot").html("");
    $(".timeSlot").append(timeSlot(startTime));
    quotation = timeDivide(timeDifference, maxPatients);
    startTimeInSeconds = toSeconds(startTime);
    for (let i = 1; i < maxPatients; i++) {
        startTimeInSeconds = startTimeInSeconds + quotation;
        nextTime = toTime(startTimeInSeconds);
        $(".timeSlot").append(timeSlot(nextTime));
    }
});

function timeSlot(time) {
    return (
        `<div class="form-check">
                                <input class="form-check-input" value="` +
        time +
        `" type="radio" name="time">
                                <label class="form-check-label">
                                    ` +
        time +
        `
                                </label>
                            </div>`
    );
}
