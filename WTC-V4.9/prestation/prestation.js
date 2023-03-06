/*********************************************************************/
/*********************************************************************/


$(document).ready(function () {
    $("input[id=start], input[id=pause]").click(function () {
        var bouton = $(this).attr("id");
        $.ajax({
            type: "POST",
            url: "chrono_processus.php",
            data: { fonction: bouton }
        });
    });

    $("input[id=stop]").click(function () {
        $.ajax({
            type: "POST",
            url: "chrono_processus.php",
            data: { fonction: "stop" }
        }).done(function (tempsChrono) {
            $("#chrono").val(tempsChrono);
        });
    });
});


/*********************************************************************/
/*********************************************************************/


let hour = 0;
let minute = 0;
let second = 0;
let count = 0;

$(document).ready(function () {
    var startBtn = document.getElementById("start");
    var pauseBtn = document.getElementById("pause");
    var stopBtn = document.getElementById("stop");

    startBtn.addEventListener('click', startTimer);
    pauseBtn.addEventListener('click', pauseTimer);
    stopBtn.addEventListener('click', stopTimer);
});


function startTimer() {
    timer = true;
    stopWatch();
}

function pauseTimer() {
    timer = false;
}

function stopTimer() {
    timer = false;
    hour = 0;
    minute = 0;
    second = 0;
    count = 0;
    document.getElementById('hr').innerHTML = "00";
    document.getElementById('min').innerHTML = "00";
    document.getElementById('sec').innerHTML = "00";
}

function stopWatch() {
    if (timer) {
        count++;

        if (count == 100) {
            second++;
            count = 0;
        }

        if (second == 60) {
            minute++;
            second = 0;
        }

        if (minute == 60) {
            hour++;
            minute = 0;
            second = 0;
        }

        let hrString = hour;
        let minString = minute;
        let secString = second;
        let countString = count;

        if (hour < 10) {
            hrString = "0" + hrString;
        }

        if (minute < 10) {
            minString = "0" + minString;
        }

        if (second < 10) {
            secString = "0" + secString;
        }

        if (count < 10) {
            countString = "0" + countString;
        }

        document.getElementById('hr').innerHTML = hrString;
        document.getElementById('min').innerHTML = minString;
        document.getElementById('sec').innerHTML = secString;
        setTimeout(stopWatch, 10);
    }
}


/*********************************************************************/
/*********************************************************************/


function confirmSuppression(id) {
    if (confirm("Êtes-vous sûr de vouloir supprimer ce client ?")) {
        window.location.href = "supprimerClient.php?id=" + id;
    }
}


/*********************************************************************/
/*********************************************************************/


$(document).ready(function () {
    var startButton = $("#start");
    var pauseButton = $("#pause");
    var stopButton = $("#stop");
    var submitButton = $("button[type='submit']");

    pauseButton.prop("disabled", true);
    stopButton.prop("disabled", true);
    submitButton.prop("disabled", true);

    startButton.click(function () {
        startButton.prop("disabled", true);
        pauseButton.prop("disabled", false);
        stopButton.prop("disabled", false);
    });

    pauseButton.click(function () {
        startButton.prop("disabled", false);
        pauseButton.prop("disabled", true);
        stopButton.prop("disabled", false);
    });

    stopButton.click(function () {
        startButton.prop("disabled", true);
        pauseButton.prop("disabled", true);
        stopButton.prop("disabled", true);
        submitButton.prop("disabled", false);
    });
});