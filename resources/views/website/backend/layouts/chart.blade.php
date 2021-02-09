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
                console.log(data);
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
                            backgroundColor: 'purple',
                            borderColor: 'purple',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    stepSize : 3,
                                },

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
