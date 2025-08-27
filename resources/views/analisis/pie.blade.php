<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Temuan</title>

    <!-- Bootstrap CSS for Pagination -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Custom & FontAwesome -->
    <link rel="stylesheet" href="{{ asset('argon/css/dashboard-custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <style>
        body {
            background-color: #032E3D;
            color: #fff;
        }

        .content-wrapper {
            padding: 40px;
        }

        .table-container {
            background-color: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            margin-bottom: 40px;
        }

        table th {
            background-color: #032E3D;
            color: #fff;
            text-align: center;
            font-weight: bold;
            padding: 10px;
        }

        table td {
            text-align: center;
            padding: 10px;
            background-color: #f9f9f9;
            color: #032E3D;
        }

        .btn-primary {
            background-color: #0A2B33;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            font-size: 0.85rem;
        }

        .btn-primary:hover {
            background-color: #145c73;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #0098be;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .pagination .page-link {
            color: #0d6efd;
        }

        .pagination .active .page-link {
            background-color: #0d6efd;
            color: #fff;
        }

        .button-detail {
            background-color: #032E3D !important;
            color: #ffff !important;
            padding: 5px 12px;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 10px;
            display: inline-block;
            min-width: 90px;
            text-align: center;
        }

        canvas {
            display: block;
            margin: 20px auto;
        }

        .canvasgraph2 {
            max-width: 400px;
            max-height: 400px;
            margin: 40 px;
            display: block;
        }

        .chart-row {
            display: flex;
            flex-wrap: wrap;
            /* responsif jika layar kecil */
            justify-content: center;
            /* tengah-tengah */
            gap: 40px;
            /* jarak antar chart */
            margin-top: 30px;
        }

        .chart-box {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
            flex: 1;
        }

        .fullwidth-bar-container {
            background-color: white;
            width: 100%;
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }

        .fullwidth-bar {
            width: 100%;
            max-width: unset;
            /* Boleh diperbesar sesuai ukuran layar */
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        #barChartByArea {
            width: 100% !important;
            height: 400px !important;
        }

        #filterForm select,
        #filterForm input,
        #filterForm button {
            min-width: 120px;
        }

        #filterForm button {
            font-weight: 600;
            border: none;
            transition: background 0.2s ease;
        }

        #filterForm button:hover {
            background-color: #00b3dc;
        }

        #lineJenisTemuanChart {
            width: 100% !important;
            height: 500px !important;
        }

        .fullwidth-barTrend {
            width: 100%;
            max-width: unset;
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    @include('layouts.header')

    <div class="content-wrapper">
        <a href="{{ route('admin.dashboard') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        {{-- Grafik Safety Observation --}}
        <div class="table-container">
            <h3 style="color:#032E3D; font-weight:bold;">Grafik Kategori Safety Observation</h3>
            <form id="filterForm" class="d-flex align-items-center flex-wrap gap-2 mb-3" style="max-width: 700px;">

                <!-- Filter Mode -->
                <select id="filterMode" name="filterMode" class="form-select form-select-sm" style="width: 140px;">
                    <option value="all">Semua Data</option>
                    <option value="single">Per Tanggal</option>
                    <option value="range">Range Tanggal</option>
                </select>

                <!-- Tanggal Tunggal -->
                <input type="date" id="singleDate" name="singleDate" class="form-control form-control-sm"
                    style="width: 150px; display: none;">

                <!-- Tanggal Range -->
                <input type="date" id="startDate" name="startDate" class="form-control form-control-sm"
                    style="width: 150px; display: none;">

                <span id="dateSeparator" style="display: none; color: #032E3D; font-weight: bold;">s/d</span>

                <input type="date" id="endDate" name="endDate" class="form-control form-control-sm"
                    style="width: 150px; display: none;">

                <!-- Tombol Filter -->
                <button type="submit" class="btn btn-sm"
                    style="background-color: #00CFFF; color: black; font-weight: bold; padding: 4px 12px;">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </form>


            <div class = 'chart-row'>
                <div class ='chart-box'>
                    <canvas id="safetyPie" width="400" height="400"></canvas>
                </div>
                <div class ='chart-box'>
                    <canvas id="statusPie" width="400" height="400"></canvas>
                </div>
                <div class="chart-box">
                    <canvas id="seksiPieChart" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="fullwidth-bar-container">
                <div class="fullwidth-bar">
                    <canvas id="barChartByArea" height="500"></canvas>
                </div>
            </div>
        </div>

        {{-- Grafik trend --}}
        <div class="table-container">
            <h3 style="color:#032E3D; font-weight:bold;">Trend Temuan Safety Observation</h3>
            <form id="filterLineChart" class="d-flex align-items-center flex-wrap gap-2 mb-3" style="max-width: 800px;">
                <!-- Mode Tanggal -->
                <select id="lineFilterMode" name="lineFilterMode" class="form-select form-select-sm"
                    style="width: 150px;">
                    <option value="all">Semua Tanggal</option>
                    <option value="single">Tanggal Tertentu</option>
                    <option value="range">Range Tanggal</option>
                </select>

                <!-- Tanggal Tunggal -->
                <input type="date" id="lineSingleDate" class="form-control form-control-sm"
                    style="width: 150px; display: none;" />

                <!-- Range Tanggal -->
                <input type="date" id="lineStartDate" class="form-control form-control-sm"
                    style="width: 150px; display: none;" />
                <span id="lineDateSeparator" style="display: none; color: #032E3D; font-weight: bold;">s/d</span>
                <input type="date" id="lineEndDate" class="form-control form-control-sm"
                    style="width: 150px; display: none;" />

                <!-- Area (Seksi) -->
                <select id="lineAreaId" name="lineAreaId" class="form-select form-select-sm" style="width: 180px;">
                    <option value="all">Semua Seksi</option>
                    @foreach (App\Models\Area::all() as $area)
                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                    @endforeach
                </select>

                <!-- Tombol -->
                <button type="submit" class="btn btn-sm"
                    style="background-color: #00CFFF; color: black; font-weight: bold; padding: 4px 12px;">
                    <i class="fas fa-filter"></i> Tampilkan Grafik
                </button>
            </form>

            <div class="fullwidth-bar-container">
                <div class="fullwidth-barTrend">
                    <canvas id="lineJenisTemuanChart" height="450"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
        //keterangan status SO
        const statusDescriptions = {
            'Closed': 'Temuan sudah selesai ditindaklanjuti',
            'Waiting': 'Menunggu konfirmasi atau persetujuan',
            'Open': 'Temuan baru masuk dan belum diproses',
            'On Progress': 'Sedang dalam proses tindak lanjut',
            'Pending': 'Tertunda karena alasan tertentu'
        };
        // ========================== TAMBAHAN: Filter Tanggal ==========================
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const mode = document.getElementById('filterMode').value;
            let queryParams = "";

            if (mode === 'single') {
                const date = document.getElementById('singleDate').value;
                queryParams = `?filterMode=single&singleDate=${date}`;
            } else if (mode === 'range') {
                const start = document.getElementById('startDate').value;
                const end = document.getElementById('endDate').value;
                queryParams = `?filterMode=range&startDate=${start}&endDate=${end}`;
            }

            fetchChartData(queryParams);
        });

        // Inisialisasi pertama kali (tanpa filter)
        fetchChartData("");

        function fetchChartData(query) {
            // Pie: Unsafe Condition vs Unsafe Action
            fetch("{{ url('/chart/data/pie') }}" + query)
                .then(response => response.json())
                .then(result => {
                    const ctx = document.getElementById('safetyPie').getContext('2d');
                    if (window.safetyChart) window.safetyChart.destroy(); // refresh chart
                    window.safetyChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: result.labels,
                            datasets: [{
                                data: result.data,
                                backgroundColor: ['#ff6384', '#36a2eb'],
                                hoverOffset: 10
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                title: {
                                    display: true,
                                    text: 'Jumlah Unsafe Condition dan Unsafe Action'
                                },
                                datalabels: {
                                    color: '#fff',
                                    formatter: (value, context) => {
                                        const total = context.chart._metasets[0].total;
                                        const percent = (value / total * 100).toFixed(1) + '%';
                                        return `${value} (${percent})`;
                                    }
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                });

            // Pie: Status
            fetch("{{ url('/chart/data/pieStatus') }}" + query)
                .then(response => response.json())
                .then(result => {
                    const ctx = document.getElementById('statusPie').getContext('2d');
                    if (window.statusChart) window.statusChart.destroy();
                    window.statusChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: result.labels,
                            datasets: [{
                                data: result.data,
                                backgroundColor: ['#4CAF50', '#42A5F5', '#5C6BC0', '#FFC107',
                                    '#EF5350'
                                ],
                                hoverOffset: 10
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.raw || 0;
                                            const description = statusDescriptions[label] || '';

                                            return [
                                                `Status: ${label}`,
                                                `Deskripsi: ${description}`,
                                                `Jumlah: ${value}`
                                            ];
                                        }
                                    }
                                },
                                legend: {
                                    position: 'bottom'
                                },
                                title: {
                                    display: true,
                                    text: 'Grafik persentase status Safety Observation'
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                });

            // Pie: Per Seksi
            fetch("{{ url('/chart/data/pie-seksi') }}" + query)
                .then(response => response.json())
                .then(result => {
                    const ctx = document.getElementById('seksiPieChart').getContext('2d');
                    if (window.seksiChart) window.seksiChart.destroy();
                    window.seksiChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: result.labels,
                            datasets: [{
                                data: result.data,
                                backgroundColor: [
                                    '#4CAF50', '#2196F3', '#FF9800', '#9C27B0', '#F44336',
                                    '#00BCD4', '#8BC34A', '#FFC107', '#3F51B5', '#E91E63',
                                    '#795548', '#607D8B', '#00E676', '#FF5722', '#673AB7', '#B2EBF2'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                title: {
                                    display: true,
                                    text: 'Jumlah Laporan Safety Observation per Seksi'
                                },
                                datalabels: {
                                    color: '#fff',
                                    formatter: (value, context) => {
                                        const total = context.chart._metasets[0].total;
                                        const percent = (value / total * 100).toFixed(1) + '%';
                                        return `${value} (${percent})`;
                                    }
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                });

            // Bar per Area
            fetch("{{ url('/chart/data/bar-area') }}" + query)
                .then(res => res.json())
                .then(data => {
                    const ctx = document.getElementById('barChartByArea').getContext('2d');
                    if (window.barChartArea) window.barChartArea.destroy();
                    window.barChartArea = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                    label: 'Unsafe Action',
                                    data: data.unsafeActions,
                                    backgroundColor: '#ff6384'
                                },
                                {
                                    label: 'Unsafe Condition',
                                    data: data.unsafeConditions,
                                    backgroundColor: '#2b4a5f'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                title: {
                                    display: true,
                                    text: 'Grafik Jumlah Safety Observation tiap Seksi'
                                }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    ticks: {
                                        autoSkip: false,
                                        maxRotation: 45,
                                        minRotation: 45
                                    },
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true
                                }
                            },
                            layout: {
                                padding: 30
                            },
                            categoryPercentage: 0.5,
                            barPercentage: 1
                        }
                    });
                });
        }
        // ======================== AKHIR TAMBAHAN ==========================
        document.getElementById('filterMode').addEventListener('change', function() {
            const mode = this.value;
            document.getElementById('singleDate').style.display = (mode === 'single') ? 'inline-block' : 'none';
            document.getElementById('startDate').style.display = (mode === 'range') ? 'inline-block' : 'none';
            document.getElementById('endDate').style.display = (mode === 'range') ? 'inline-block' : 'none';
            document.getElementById('dateSeparator').style.display = (mode === 'range') ? 'inline-block' : 'none';
        });


        // ==================================GRAFIK TREND========================
        // ==================================GRAFIK TREND========================
        // ==================================GRAFIK TREND========================
        // ==================================GRAFIK TREND========================
        // Grafik Trend
        document.getElementById('filterLineChart').addEventListener('submit', function(e) {
            e.preventDefault();

            const mode = document.getElementById('lineFilterMode').value;
            const areaId = document.getElementById('lineAreaId').value;
            let query = `?filterMode=${mode}&area_id=${areaId}`;

            if (mode === 'single') {
                const date = document.getElementById('lineSingleDate').value;
                query += `&singleDate=${date}`;
            } else if (mode === 'range') {
                const start = document.getElementById('lineStartDate').value;
                const end = document.getElementById('lineEndDate').value;
                query += `&startDate=${start}&endDate=${end}`;
            }

            fetchLineChartData(query);
        });


        // Fungsi ambil data line chart
        function fetchLineChartData(query) {
            fetch("{{ url('/chart/data/line-temuan') }}" + query)
                .then(res => res.json())
                .then(data => {
                    const ctx = document.getElementById('lineJenisTemuanChart').getContext('2d');
                    if (window.lineChartTemuan) window.lineChartTemuan.destroy();

                    window.lineChartTemuan = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: data.datasets
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                title: {
                                    display: true,
                                    text: 'Trend Jenis Temuan Berdasarkan Waktu'
                                }
                            },
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tanggal'
                                    },
                                    ticks: {
                                        maxRotation: 60,
                                        minRotation: 45
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Jumlah Temuan'
                                    }
                                }
                            }
                        }
                    });
                });
        }
        document.getElementById('lineFilterMode').addEventListener('change', function() {
            const mode = this.value;
            document.getElementById('lineSingleDate').style.display = (mode === 'single') ? 'inline-block' :
                'none';
            document.getElementById('lineStartDate').style.display = (mode === 'range') ? 'inline-block' :
                'none';
            document.getElementById('lineEndDate').style.display = (mode === 'range') ? 'inline-block' : 'none';
            document.getElementById('lineDateSeparator').style.display = (mode === 'range') ? 'inline-block' :
                'none';
        });
        document.addEventListener("DOMContentLoaded", function() {
            // Set default nilai dropdown dan input
            document.getElementById('lineFilterMode').value = 'all';
            document.getElementById('lineAreaId').value = 'all';

            // Tampilkan grafik default (semua data, semua seksi)
            fetchLineChartData("?filterMode=all&area_id=all");
        });
    </script>
</body>


</html>
