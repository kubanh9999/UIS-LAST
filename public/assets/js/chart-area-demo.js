google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawLineChart);

function drawLineChart() {
    var data = google.visualization.arrayToDataTable([
        ['Ngày', 'Giá trị'],
        ['01', 120],
        ['02', 150],
        ['03', 170],
        ['04', 130],
        ['05', 200],
        ['06', 180],
        ['07', 190],
        ['08', 220],
        ['09', 210],
        ['10', 250],
        ['11', 300],
        ['12', 280],
        ['13', 240],
        ['14', 300],
        ['15', 320],
        ['16', 350],
        ['17', 370],
        ['18', 400],
        ['19', 380],
        ['20', 360],
        ['21', 340],
        ['22', 320],
        ['23', 310],
        ['24', 300],
        ['25', 290],
        ['26', 270],
        ['27', 260],
        ['28', 250],
        ['29', 240],
        ['30', 230]
    ]);

    var options = {
        title: 'Biểu đồ đường theo ngày trong tháng',
        curveType: 'function',
        legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
    chart.draw(data, options);
}
