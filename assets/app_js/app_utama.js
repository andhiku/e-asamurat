// Diagram Batang (Indeks Dokumen)
//$(document).ready(function () {
//    $.ajax({
//        type: 'GET',
//        url: base_domain + '/utama/get_document',
//        success: function (data) {
////            new Chart(document.getElementById("line-charta")).Line(data);
//            new Chart(document.getElementById("canvas").getContext("2d")).Bar(data);
//        }
//    });
//});

// linechart
//$(document).ready(function () {
//    $.ajax({
//        url: base_domain + '/utama/get_surat',
//        method: "GET",
//        success: function (data) {
//            console.log(data);
//            var player = [];
//            var score = [];
//
//            for (var i in data) {
//                player.push("Player " + data[i].playerid);
//                score.push(data[i].score);
//            }
//
//            var chartdata = {
//                labels: player,
//                datasets: [
//                    {
//                        label: 'Player Score',
//                        backgroundColor: 'rgba(200, 200, 200, 0.75)',
//                        borderColor: 'rgba(200, 200, 200, 0.75)',
//                        hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
//                        hoverBorderColor: 'rgba(200, 200, 200, 1)',
//                        data: score
//                    }
//                ]
//            };
//
//            var ctx = $("#mycanvas");
//
//            var barGraph = new Chart(ctx, {
//                type: 'bar',
//                data: chartdata
//            });
//        },
//        error: function (data) {
//            console.log(data);
//        }
//    });
//});

function formatNumber(number, decimalsLength, decimalSeparator, thousandSeparator) {
    var n = number,
            decimalsLength = isNaN(decimalsLength = Math.abs(decimalsLength)) ? 2 : decimalsLength,
            decimalSeparator = decimalSeparator == undefined ? "," : decimalSeparator,
            thousandSeparator = thousandSeparator == undefined ? "." : thousandSeparator,
            sign = n < 0 ? "-" : "",
            i = parseInt(n = Math.abs(+n || 0).toFixed(decimalsLength)) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;

    return sign +
            (j ? i.substr(0, j) + thousandSeparator : "") +
            i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousandSeparator) +
            (decimalsLength ? decimalSeparator + Math.abs(n - i).toFixed(decimalsLength).slice(2) : "");
}

