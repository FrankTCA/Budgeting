function checkValue(text) {
    let regex = /^-?[0-9]+\.?[0-9]?[0-9]?$/i
    return regex.test(text);
}
function onPaymentSubmit() {
    let paymentName = $("#paymentNameBox").val();
    let paymentDate = $("#paymentDateBox").val();
    let paymentAmount = $("#paymentAmountBox").val();
    let paymentCategory = $("#category").val();
    if (paymentName.length > 16) {
        $("#errorMsg").text("Payment max 16 characters.");
        return;
    }
    if (!checkValue(paymentAmount)) {
        $("#errorMsg").text("Please write payment amount as a decimal with up to two decimal places.");
    }
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        var data = this.response;
        console.log(data);
        if (data.startsWith("noinfo")) {
            $("#errorMsg").text("")
        } else if (this.status === 401) {
            window.location.replace("https://infotoast.org/sso/");
        } else if (data.startsWith("invalid setting")) {
            $("#errorMsg").text("Setting was invalid!");
        } else if (data.startsWith("success")) {
            refreshData();
        } else {
            $("#errorMsg").text(data);
        }
    }
    xhttp.open("GET", "action/payment.php?category=" + paymentCategory + "&name=" + paymentName + "&date=" + paymentDate + "&amount=" + paymentAmount);
    xhttp.send();
    $("#paymentNameBox").val("");
    $("#paymentAmountBox").val("");
}

function refreshData() {
    $("#paymentTable").empty();
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === 4) {
            var data = this.response;
            console.log(data);
            if (data.startsWith("noinfo")) {
                $("#errorMsg").text("Category was not supplied to payment log getter!");
            } else if (data.startsWith("invalidsetting")) {
                $("#errorMsg").text("Setting was invalid! Please contact frank@infotoast.org if you receive this error.");
            } else if (data.startsWith("dbconn")) {
                $("#errorMsg").text("Could not connect to database! Please contact frank@infotoast.org if you receive this error.");
            } else if (data.startsWith("{")) {
                var jsonData = $.parseJSON(data);
                var progress = jsonData.already_spent / jsonData.total_amount * 100;
                console.log("Progress: " + progress);
                if (progress > 100) {
                    progress = 100;
                }
                $("#progressbar").progressbar({
                    value: progress
                });
                for (var i = 0; i < jsonData.payments.length; i++) {
                    console.log("Payment name: " + jsonData.payments[i].name);
                    $("#paymentTable").append("<tr><td>" + jsonData.payments[i].name + "</td><td>" + jsonData.payments[i].amount + "</td><td>" + jsonData.payments[i].expense_date + "</td></tr>");
                }
                /*$.each(data.payments, function(k, v) {
                    $("#paymentTable").append("<tr><td>" + v.name + "</td><td>" + v.amount + "</td><td>" + v.expense_date + "</td></tr>");
                });*/
            } else if (data.startsWith("wrongtoken")) {
                $("#errorMsg").text("Please log in again.");
                window.location.replace("https://infotoast.org/sso/");
            } else if (this.status === 401) {
                window.location.replace("https://infotoast.org/sso/");
            }
        }
    }
    let category = $("#category").val();
    xhr.open("GET", "action/payment_log.php?category=" + category, false);
    xhr.send();
}

$(document).ready(function() {
    $("#paymentDateBox").datepicker();
    refreshData();
});

/*
$("#regemail").on('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTypingEmail, doneTypingInterval);
    });

    $("#regemail").on('keydown', function() {
        clearTimeout(typingTimer);
    })

    function doneTypingEmail() {
        let value = $("#regemail").val();
        if (!(/^[^\s]*@[a-z0-9.-]*$/.test(value) && value.length < 321)) {
            $("#regemail").attr('class', 'badtextbox');
            $(".badtextboxmsg").show().text("That is not a proper email. No spaces please. Only valid characters.");
            $("#continue").attr('class', 'disabledbtn');
            enabledbtn = false;
        } else {
            $("#regemail").attr('class', 'logintextbox');
            $(".badtextboxmsg").hide();
            $("#continue").attr('class', 'continue');
            enabledbtn = true;
        }
    }
 */

var typingTimer;
let doneTypingInterval = 2000;
$("#paymentNameBox").on('keyup', function() {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(doneTypingPaymentName, doneTypingInterval);
});

$("#paymentNameBox").on('keydown', function() {
    clearTimeout(typingTimer);
});

function doneTypingPaymentName() {
    let value = $("#paymentNameBox").val();
    if (!(value.length < 16)) {
        $("#paymentNameBox").attr('class', 'badtextbox');
        $(".badtextboxmsg").show().text("Name must be less than 16 characters.");
    } else {
        $("#paymentNameBox").attr('class', 'loginTextBox');
        $(".badtextboxmsg").hide();
    }
}

var amountTypingTimer;
let amountTypingInterval = 2000;
$("#paymentAmountBox").on('keyup', function() {
    clearTimeout(amountTypingTimer);
    amountTypingTimer = setTimeout(doneTypingPaymentAmount, amountTypingInterval);
});

$("#paymentAmountBox").on('keydown', function() {
    clearTimeout(amountTypingTimer);
});

function doneTypingPaymentAmount() {
    let value = $("#paymentAmountBox").val();
    if (!checkValue(value)) {
        $("#paymentAmountBox").attr('class', 'badtextbox');
        $(".badtextboxmsg").show().text("Payment amount must be a decimal number with no more than two characters past the decimal.");
    } else {
        $("#paymentAmountBox").attr('class', 'loginTextBox');
        $(".badtextboxmsg").hide();
    }
}