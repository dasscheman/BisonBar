<x-body-layout :title="$title">
    <div class="card card-body shadow-blur mx-6 mt-custom opacity-9">
        @include('components.alert')
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
            <div class="container-fluid py-4">
                <livewire:components.header-totals />

                <div class="row my-4">
                    <livewire:components.year-totals />
                    @include('components.expenses-list', compact('expenses'))
                </div>
                <div class="row">
                    <div class="col-md-4 mt-4">
                        @include('components.payments-list', compact('payments'))
                    </div>
                    <div class="col-md-4 mt-4">
                        <div class="card h-100 mb-4">
                            <div class="card-header pb-0 px-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-0">Your Transaction's</h6>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                                        <i class="far fa-calendar-alt me-2"></i>
                                        <small>23 - 30 March 2020</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-4 p-3">
                                <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Newest</h6>
                                <ul class="list-group">
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <button
                                                class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i
                                                    class="fas fa-arrow-down"></i></button>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Netflix</h6>
                                                <span class="text-xs">27 March 2020, at 12:30 PM</span>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                                            - $ 2,500
                                        </div>
                                    </li>
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <button
                                                class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i
                                                    class="fas fa-arrow-up"></i></button>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Apple</h6>
                                                <span class="text-xs">27 March 2020, at 04:30 AM</span>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                            + $ 2,000
                                        </div>
                                    </li>
                                </ul>
                                <h6 class="text-uppercase text-body text-xs font-weight-bolder my-3">Yesterday</h6>
                                <ul class="list-group">
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <button
                                                class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i
                                                    class="fas fa-arrow-up"></i></button>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Stripe</h6>
                                                <span class="text-xs">26 March 2020, at 13:45 PM</span>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                            + $ 750
                                        </div>
                                    </li>
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <button
                                                class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i
                                                    class="fas fa-arrow-up"></i></button>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">HubSpot</h6>
                                                <span class="text-xs">26 March 2020, at 12:30 PM</span>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                            + $ 1,000
                                        </div>
                                    </li>
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <button
                                                class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i
                                                    class="fas fa-arrow-up"></i></button>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Creative Tim</h6>
                                                <span class="text-xs">26 March 2020, at 08:30 AM</span>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                            + $ 2,500
                                        </div>
                                    </li>
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <button
                                                class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i
                                                    class="fas fa-exclamation"></i></button>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Webflow</h6>
                                                <span class="text-xs">26 March 2020, at 05:00 AM</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                            Pending
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mt-4">
                        <div class="card h-100">
                            <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-md-6 d-flex align-items-center">
                                        <h6 class="mb-0">Invoices</h6>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button class="btn btn-outline-primary btn-sm mb-0">View All</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3 pb-0">
                                <ul class="list-group">
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark font-weight-bold text-sm">March, 01, 2020</h6>
                                            <span class="text-xs">#CC-214589</span>
                                        </div>
                                        <div class="d-flex align-items-center text-sm">
                                            $350
                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                                    class="fas fa-file-pdf text-lg me-1"></i> PDF</button>
                                        </div>
                                    </li>
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <h6 class="text-dark mb-1 font-weight-bold text-sm">April, 05, 2020</h6>
                                            <span class="text-xs">#FB-212562</span>
                                        </div>
                                        <div class="d-flex align-items-center text-sm">
                                            $560
                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                                    class="fas fa-file-pdf text-lg me-1"></i> PDF</button>
                                        </div>
                                    </li>
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <h6 class="text-dark mb-1 font-weight-bold text-sm">June, 25, 2019</h6>
                                            <span class="text-xs">#QW-103578</span>
                                        </div>
                                        <div class="d-flex align-items-center text-sm">
                                            $120
                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                                    class="fas fa-file-pdf text-lg me-1"></i> PDF</button>
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <h6 class="text-dark mb-1 font-weight-bold text-sm">March, 01, 2019</h6>
                                            <span class="text-xs">#AR-803481</span>
                                        </div>
                                        <div class="d-flex align-items-center text-sm">
                                            $300
                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                                    class="fas fa-file-pdf text-lg me-1"></i> PDF</button>
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <h6 class="text-dark mb-1 font-weight-bold text-sm">March, 01, 2019</h6>
                                            <span class="text-xs">#ST-451897</span>
                                        </div>
                                        <div class="d-flex align-items-center text-sm">
                                            $275
                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i
                                                    class="fas fa-file-pdf text-lg me-1"></i> PDF</button>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
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
