@extends('layouts.base')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-3">
                <div class="card mb-4">
                    <h5 class="card-header">Pick a day</h5>
                    <div class="card-body">
                        <label for="html5-date-input" class="col-md-2 col-form-label">Date</label>
                        <div class="col-md-10">
                            <input class="form-control" type="date" id="selectedDay" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-4">
                    <h5 class="card-header">Line chart</h5>
                    <div class="card-body">
                        <canvas id="chart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('custom-scripts')
    <script>
        const ctx = document.getElementById('chart');

        let lightChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [00, 01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false
                    }
                },
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            getDataByDate();
            selectedDay.addEventListener("change", getDataByDate);
        }, false);


        const getDataByDate = () => {
            axios.get('/price-by-date', {
                params: {
                    date: document.getElementById('selectedDay').value
                }
            })
            .then(function(response) {
                removeDatasets(lightChart);
                addDataset(lightChart, response.data);
            })
            .catch(function(error) {
            })
            .finally(function() {
            });
        }


        const removeDatasets = (chart) => {
            chart.data.datasets.pop();
            chart.update();
        }

        const addDataset = (chart, resData) => {
            const data = chart.data;
            const dsColor = colors[chart.data.datasets.length] ?? randomColor();

            const newDataset = {
                label: resData.label,
                backgroundColor: dsColor,
                borderColor: addOpacityColor(dsColor),
                data: resData.prices,
                borderWidth: 1
            };
            chart.data.datasets.push(newDataset);
            chart.update();
        }

        const randomColor = () => {
            var o = Math.round, r = Math.random, s = 255;
            return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ')';
        }

        const addOpacityColor = (color) => {
            color = color.replace(/rgb/i, "rgba");
            return color.replace(/\)/i,',0.5)');
        }

        const colors = [
            'rgb(54, 162, 235)',
            'rgb(255, 99, 132)',
            'rgb(75, 192, 192)',
            'rgb(255, 159, 64)',
            'rgb(153, 102, 255)',
            'rgb(255, 205, 86)',
            'rgb(201, 203, 207)',
        ];
    </script>
@endpush
