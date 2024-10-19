$(document).ready(function() {
    $.get("action/get_main_info.php", {async: false}, function(data, status) {
        console.log("Received data: " + data);
        if (data.startsWith("dbconn")) {
            $("#errorMsg").text("Could not connect to database!");
        } else if (data.startsWith("gotosettings")) {
            window.location.replace("settings.php");
        } else if (data.startsWith("{")) {
            var output = $.parseJSON(data);
            let ratio_complete = output.ratio_complete*100;
            $("#monthProgress").progressbar({
                value: ratio_complete
            });
            let utilAmount = output.settings.util;
            let foodAmount = output.settings.food;
            let supplyAmount = output.settings.supply;
            let travelAmount = output.settings.travel;
            let softwareAmount = output.settings.software;
            let luxuryAmount = output.settings.luxury;
            let googleChartEnabled = output.settings.googleChart == "yes";
            if (googleChartEnabled) {
                google.charts.load('current', {'packages': ['corechart']});
                google.charts.setOnLoadCallback(drawPieChart);
                function drawPieChart() {
                    var data1 = google.visualization.arrayToDataTable([
                        ['Budget', 'Category'],
                        ['Rent/Utilities', utilAmount],
                        ['Food', foodAmount],
                        ['Household Supply', supplyAmount],
                        ['Travel', travelAmount],
                        ['Software', softwareAmount],
                        ['Luxury', luxuryAmount]
                    ]);

                    var options = {
                        title: 'Budget by Category'
                    }
                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                    chart.draw(data1, options);
                }
            }
        }
    });
});