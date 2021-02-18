@extends('website.backend.layouts.main')

@section('content')
<canvas id="myChart" width="400" height="200"></canvas>
<script src="{{ asset('bower_components/components-font-awesome/chart.js/dist/Chart.js') }}"></script>

<script>
    var updateChart = function () {
        $.ajax({
            url: "chart",
            type: "GET",
            success: function (data) {
                let dataChart = [];
                let dataMonth = Object.keys(data.posts);
                dataOfMonth = dataMonth.map(function (item) {
                    return parseInt(item);
                })
                let valuePost = Object.values(data.posts);
                let months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
                let count = 0;
                for (let index = 0; index < months.length; index++) {
                    if (dataOfMonth.includes(index + 1)) {
                        dataChart.push(valuePost[dataOfMonth.indexOf(index + 1)]);
                        count++;
                    } else {
                        dataChart.push(0);
                    }
                }
                console.log(dataChart);
                var ctx = document.getElementById('myChart');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['January', 'Ferbuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        datasets: [{
                            label: '# of Posts',
                            data: dataChart,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        });
    }
    updateChart();
</script>
@endsection
