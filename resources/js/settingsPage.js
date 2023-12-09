function checkValue(text) {
    let regex = /^[0-9]+\.?[0-9]?[0-9]?$/i
    return regex.test(text);
}

function submitSetting(setting, value) {
    if (checkValue(value)) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === 4) {
                var data = this.response;
                if (data.startsWith("noinfo")) {
                    $("#errorMsg").text("Could not get proper info!");
                } else if (data.startsWith("invalid setting")) {
                    $("#errorMsg").text("Setting does not exist! Please contact frank@infotoast.org if you see this error.");
                } else if (data.startsWith("dbconn")) {
                    $("#errorMsg").text("Error connecting to database! Please contact frank@infotoast.org if you see this error.");
                } else if (data.startsWith("success")) {

                }
            }
        }
        xhr.open("GET", "action/settings_set.php?setting=" + setting + "&value=" + value, false);
        xhr.send();
        return true;
    }
    return false;
}

function onSettingsSubmit() {
    let incomeValue = $("#incomeBox").val();
    let utilValue = $("#utilBox").val();
    let foodValue = $("#foodBox").val();
    let supplyValue = $("#supplyBox").val();
    let travelValue = $("#travelBox").val();
    let softwareValue = $("#softwareBox").val();
    let luxuryValue = $("#luxuryBox").val();
    if (checkValue(incomeValue) && checkValue(utilValue) && checkValue(foodValue) && checkValue(supplyValue) && checkValue(travelValue) && checkValue(softwareValue) && checkValue(luxuryValue)) {
        let incomeGood = submitSetting("income", incomeValue);
        let utilGood = submitSetting("util", utilValue);
        let foodGood = submitSetting("food", foodValue);
        let supplyGood = submitSetting("supply", supplyValue);
        let travelGood = submitSetting("travel", travelValue);
        let softwareGood = submitSetting("software", softwareValue);
        let luxuryGood = submitSetting("luxury", luxuryValue);
        if (incomeGood && utilGood && foodGood && supplyGood && travelGood && softwareGood && luxuryGood) {
            window.location.replace("index.php");
        } else {
            $("#errorMsg").text("Please make sure you write your values in the form of a decimal, with no more than two numbers after the .");
        }
    } else {
        $("#errorMsg").text("Please fill out every box.");
    }
}

$(document).ready(function() {
    $.get("action/get_main_info.php", function(data, status) {
        console.log("Recieved data: " + data);
        if (data.startsWith("dbconn")) {
            $("#errorMsg").text("Could not establish database connection!");
        } else if (data.startsWith("{")) {
            var output = $.parseJSON(data);
            let incomeAmount = output.income;
            let utilAmount = output.settings.util;
            let foodAmount = output.settings.food;
            let supplyAmount = output.settings.supply;
            let travelAmount = output.settings.travel;
            let softwareAmount = output.settings.software;
            let luxuryAmount = output.settings.luxury;
            $("#incomeBox").val(incomeAmount);
            $("#utilBox").val(utilAmount);
            $("#foodBox").val(foodAmount);
            $("#supplyBox").val(supplyAmount);
            $("#travelBox").val(travelAmount);
            $("#softwareBox").val(softwareAmount);
            $("#luxuryBox").val(luxuryAmount);
        }
    });
});