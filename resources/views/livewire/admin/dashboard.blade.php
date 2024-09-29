<x-body-layout :title="$title">
    <div class="card card-body shadow-blur mx-6 mt-custom opacity-9">
        @include('components.alert')
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
            <div class="container-fluid py-4">
{{--                <livewire:components.header-totals />--}}
                <div class="row my-4">
                    <livewire:components.year-totals :years="$years" />
                    @include('components.expenses-list', compact('expenses'))
                </div>
                <div class="row">
                    <div class="col-md-4 mt-4">
                        @include('components.payments-list', compact('payments'))
                    </div>
                    <div class="col-md-4 mt-4">
                        @include('components.tally-list', compact('tallies'))
                    </div>

                    <div class="col-md-4 mt-4">
                        @include('components.invoices-list', compact('invoices'))
                    </div>
                </div>
                <div class="row">

                </div>
            </div>
        </main> <!--   Core JS Files   -->
        <script src="/assets/js/plugins/chartjs.min.js"></script>
        <script src="/assets/js/plugins/Chart.extension.js"></script>
        <script>
            var ctx = document.getElementById("chart-bars").getContext("2d");

            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: "Sales",
                        tension: 0.4,
                        borderWidth: 0,
                        pointRadius: 0,
                        backgroundColor: "#fff",
                        data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
                        maxBarThickness: 6
                    }, ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                    },
                    tooltips: {
                        enabled: true,
                        mode: "index",
                        intersect: false,
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: false,
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 500,
                                beginAtZero: true,
                                padding: 0,
                                fontSize: 14,
                                lineHeight: 3,
                                fontColor: "#fff",
                                fontStyle: 'normal',
                                fontFamily: "Open Sans",
                            },
                        }, ],
                        xAxes: [{
                            gridLines: {
                                display: false,
                            },
                            ticks: {
                                display: false,
                                padding: 20,
                            },
                        }, ],
                    },
                },
            });

            var ctx2 = document.getElementById("chart-line").getContext("2d");

            var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

            gradientStroke1.addColorStop(1, 'rgba(253,235,173,0.4)');
            gradientStroke1.addColorStop(0.2, 'rgba(245,57,57,0.0)');
            gradientStroke1.addColorStop(0, 'rgba(255,214,61,0)'); //purple colors

            var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

            gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.4)');
            gradientStroke2.addColorStop(0.2, 'rgba(245,57,57,0.0)');
            gradientStroke2.addColorStop(0, 'rgba(255,214,61,0)'); //purple colors


            new Chart(ctx2, {
                type: "line",
                data: {
                    labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: "Mobile apps",
                        tension: 0.4,
                        borderWidth: 0,
                        pointRadius: 0,
                        borderColor: "#fbcf33",
                        borderWidth: 3,
                        backgroundColor: gradientStroke1,
                        data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                        maxBarThickness: 6

                    },
                        {
                            label: "Websites",
                            tension: 0.4,
                            borderWidth: 0,
                            pointRadius: 0,
                            borderColor: "#f53939",
                            borderWidth: 3,
                            backgroundColor: gradientStroke2,
                            data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
                            maxBarThickness: 6

                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                    },
                    tooltips: {
                        enabled: true,
                        mode: "index",
                        intersect: false,
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                borderDash: [2],
                                borderDashOffset: [2],
                                color: '#dee2e6',
                                zeroLineColor: '#dee2e6',
                                zeroLineWidth: 1,
                                zeroLineBorderDash: [2],
                                drawBorder: false,
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 500,
                                beginAtZero: true,
                                padding: 10,
                                fontSize: 11,
                                fontColor: '#adb5bd',
                                lineHeight: 3,
                                fontStyle: 'normal',
                                fontFamily: "Open Sans",
                            },
                        }, ],
                        xAxes: [{
                            gridLines: {
                                zeroLineColor: 'rgba(0,0,0,0)',
                                display: false,
                            },
                            ticks: {
                                padding: 10,
                                fontSize: 11,
                                fontColor: '#adb5bd',
                                lineHeight: 3,
                                fontStyle: 'normal',
                                fontFamily: "Open Sans",
                            },
                        }, ],
                    },
                },
            });
        </script>
    </div>
</x-body-layout>
