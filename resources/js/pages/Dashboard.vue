<script setup lang="ts">
import StrikingDashLayout from '@/layouts/StrikingDashLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';

onMounted(() => {
    // Initialize any required JavaScript after component mounts
    setTimeout(() => {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
        
        // Initialize charts
        initializeCharts();
    }, 100);
});

const initializeCharts = () => {
    if (typeof Chart === 'undefined') return;
    
    // Chart 1 - Line Chart One
    const ctx1 = document.getElementById('lineChartOne');
    if (ctx1) {
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Engaged Users',
                    data: [12000, 15000, 18000, 22000, 20000, 25845],
                    borderColor: '#5f63f2',
                    backgroundColor: 'rgba(95, 99, 242, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    
    // Chart 2 - Line Chart Two
    const ctx2 = document.getElementById('lineChartTwo');
    if (ctx2) {
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Page Impressions',
                    data: [1500, 1800, 2000, 2200, 2100, 2534],
                    borderColor: '#1cc88a',
                    backgroundColor: 'rgba(28, 200, 138, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    
    // Chart 3 - Line Chart Three
    const ctx3 = document.getElementById('lineChartThree');
    if (ctx3) {
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Total Page Likes',
                    data: [1800, 1900, 2000, 1950, 2000, 2142],
                    borderColor: '#ff4d4f',
                    backgroundColor: 'rgba(255, 77, 79, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    
    // Chart 4 - Line Chart Four
    const ctx4 = document.getElementById('lineChartFour');
    if (ctx4) {
        new Chart(ctx4, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'New Page Like',
                    data: [800, 900, 1000, 950, 1000, 1132],
                    borderColor: '#1cc88a',
                    backgroundColor: 'rgba(28, 200, 138, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    
    // YouTube Chart
    const youtubeCtx = document.getElementById('youtubeChart');
    if (youtubeCtx) {
        new Chart(youtubeCtx, {
            type: 'doughnut',
            data: {
                labels: ['Subscribers', 'Others'],
                datasets: [{
                    data: [2142, 1000],
                    backgroundColor: ['#5f63f2', '#f1f2f6'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '70%'
            }
        });
    }
    
    // Additional charts for other tabs
    const chartConfigs = [
        { id: 'lineChartFive', data: [25000, 30000, 35000, 40000, 42000, 45845], color: '#5f63f2' },
        { id: 'lineChartSix', data: [2000, 2500, 3000, 3500, 4000, 4534], color: '#1cc88a' },
        { id: 'lineChartSeven', data: [3000, 3200, 3500, 3800, 3900, 4142], color: '#ff4d4f' },
        { id: 'lineChartEight', data: [1500, 1600, 1700, 1800, 1900, 2132], color: '#1cc88a' },
        { id: 'lineChartNine', data: [40000, 45000, 50000, 55000, 60000, 65845], color: '#5f63f2' },
        { id: 'lineChartTen', data: [3000, 3500, 4000, 4500, 5000, 6534], color: '#1cc88a' },
        { id: 'lineChartEleven', data: [4000, 4200, 4500, 4800, 5000, 6142], color: '#ff4d4f' },
        { id: 'lineChartTwelve', data: [2000, 2200, 2400, 2600, 2800, 3132], color: '#1cc88a' },
        { id: 'lineChartThirteen', data: [50000, 55000, 60000, 65000, 70000, 75845], color: '#5f63f2' },
        { id: 'lineChartFourteen', data: [4000, 4500, 5000, 5500, 6000, 7534], color: '#1cc88a' },
        { id: 'lineChartFifteen', data: [5000, 5200, 5500, 5800, 6000, 7142], color: '#ff4d4f' },
        { id: 'lineChartSixteen', data: [2500, 2700, 2900, 3100, 3300, 4132], color: '#1cc88a' }
    ];
    
    chartConfigs.forEach(config => {
        const ctx = document.getElementById(config.id);
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Data',
                        data: config.data,
                        borderColor: config.color,
                        backgroundColor: config.color + '20',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            },
                            ticks: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    });
};
</script>

<template>
    <Head title="Dashboard" />

            <StrikingDashLayout>
            <div class="container-fluid">
                <div class="social-dash-wrap">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb-main">
                                <h4 class="text-capitalize breadcrumb-title">Social Media Dashboard</h4>
                                <div class="breadcrumb-action justify-content-center flex-wrap">
                                    <div class="action-btn">
                                        <div class="form-group mb-0">
                                            <div class="input-container icon-left position-relative">
                                                <span class="input-icon icon-left">
                                                    <span data-feather="calendar"></span>
                                                </span>
                                                <input type="text" class="form-control form-control-default date-ranger" name="date-ranger" placeholder="Oct 30, 2019 - Nov 30, 2019">
                                                <span class="input-icon icon-right">
                                                    <span data-feather="chevron-down"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Overview -->
                    <div class="row">
                        <div class="col-lg-4 mb-25">
                            <div class="social-overview-wrap">
                                <div class="card border-0">
                                    <div class="card-header">
                                        <h6>Social Media Overview</h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="social-overview">
                                            <li>
                                                <div class="social-box bg-facebook">
                                                    <span class="la la-facebook"></span>
                                                </div>
                                                <h3>5,461</h3>
                                                <p>Likes</p>
                                            </li>
                                            <li>
                                                <div class="social-box bg-twitter">
                                                    <span class="la la-twitter"></span>
                                                </div>
                                                <h3>5,461</h3>
                                                <p>Followers</p>
                                            </li>
                                            <li>
                                                <div class="social-box gradientInstragram">
                                                    <span class="la la-instagram"></span>
                                                </div>
                                                <h3>5,461</h3>
                                                <p>Followers</p>
                                            </li>
                                            <li>
                                                <div class="social-box bg-youtube">
                                                    <span class="la la-youtube"></span>
                                                </div>
                                                <h3>5,461</h3>
                                                <p>Subscribers</p>
                                            </li>
                                            <li>
                                                <div class="social-box bg-pinterest">
                                                    <span class="la la-pinterest"></span>
                                                </div>
                                                <h3>5,461</h3>
                                                <p>Followers</p>
                                            </li>
                                            <li>
                                                <div class="social-box bg-linkedin">
                                                    <span class="la la-linkedin"></span>
                                                </div>
                                                <h3>5,461</h3>
                                                <p>Followers</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Facebook Overview -->
                        <div class="col-lg-8 mb-25">
                            <div class="card card-overview border-0">
                                <div class="card-header">
                                    <h6>Facebook Overview</h6>
                                    <div class="card-extra">
                                        <div class="card-tab btn-group nav nav-tabs">
                                            <a class="btn btn-xs btn-white active border-light" id="f_today-tab" data-bs-toggle="tab" href="#f_overview-today" role="tab" area-controls="f_overview" aria-selected="true">Today</a>
                                            <a class="btn btn-xs btn-white border-light" id="f_week-tab" data-bs-toggle="tab" href="#f_overview-week" role="tab" area-controls="f_overview" aria-selected="false">Week</a>
                                            <a class="btn btn-xs btn-white border-light" id="f_month-tab" data-bs-toggle="tab" href="#f_overview-month" role="tab" area-controls="f_overview" aria-selected="false">Month</a>
                                            <a class="btn btn-xs btn-white border-light" id="f_year-tab" data-bs-toggle="tab" href="#f_overview-year" role="tab" area-controls="f_overview" aria-selected="false">Year</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0 pb-0">
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="f_overview-today" role="" aria-labelledby="f_overview-tab">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="card-overview__left">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-12 col-md-6">
                                                                <div class="overview-single">
                                                                    <div class="overview-content">
                                                                        <h1>25,845</h1>
                                                                        <p>Engaged Users</p>
                                                                        <div>
                                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                                <strong>25%</strong></span>
                                                                            <small>20,641 (prev)</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overview-single__chart">
                                                                        <div class="parentContainer">
                                                                            <div>
                                                                                <canvas id="lineChartOne"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-12 col-md-6 br-1">
                                                                <div class="overview-single">
                                                                    <div class="overview-content">
                                                                        <h1>2,534</h1>
                                                                        <p>Page Impressions</p>
                                                                        <div>
                                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                                <strong>40%</strong></span>
                                                                            <small>20,641 (prev)</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overview-single__chart">
                                                                        <div class="parentContainer">
                                                                            <div>
                                                                                <canvas id="lineChartTwo"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="card-overview__right">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-12 col-md-6">
                                                                <div class="overview-single">
                                                                    <div class="overview-content">
                                                                        <h1>2,142</h1>
                                                                        <p>Total Page Likes</p>
                                                                        <div>
                                                                            <span class="color-danger"><i data-feather="trending-down"></i>
                                                                                <strong>15%</strong></span>
                                                                            <small>20,641 (prev)</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overview-single__chart">
                                                                        <div class="parentContainer">
                                                                            <div>
                                                                                <canvas id="lineChartThree"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-12 col-md-6 co-last">
                                                                <div class="overview-single">
                                                                    <div class="overview-content">
                                                                        <h1>1,132</h1>
                                                                        <p>New Page Like</p>
                                                                        <div>
                                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                                <strong>13%</strong></span>
                                                                            <small>20,641 (prev)</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overview-single__chart">
                                                                        <div class="parentContainer">
                                                                            <div>
                                                                                <canvas id="lineChartFour"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Week Tab -->
                                        <div class="tab-pane fade" id="f_overview-week" role="" aria-labelledby="f_overview-tab">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="card-overview__left">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-12 col-md-6">
                                                                <div class="overview-single">
                                                                    <div class="overview-content">
                                                                        <h1>45,845</h1>
                                                                        <p>Engaged Users</p>
                                                                        <div>
                                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                                <strong>35%</strong></span>
                                                                            <small>40,641 (prev)</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overview-single__chart">
                                                                        <div class="parentContainer">
                                                                            <div>
                                                                                <canvas id="lineChartFive"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-12 col-md-6 br-1">
                                                                <div class="overview-single">
                                                                    <div class="overview-content">
                                                                        <h1>4,534</h1>
                                                                        <p>Page Impressions</p>
                                                                        <div>
                                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                                <strong>50%</strong></span>
                                                                            <small>30,641 (prev)</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overview-single__chart">
                                                                        <div class="parentContainer">
                                                                            <div>
                                                                                <canvas id="lineChartSix"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="card-overview__right">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-12 col-md-6">
                                                                <div class="overview-single">
                                                                    <div class="overview-content">
                                                                        <h1>4,142</h1>
                                                                        <p>Total Page Likes</p>
                                                                        <div>
                                                                            <span class="color-danger"><i data-feather="trending-down"></i>
                                                                                <strong>25%</strong></span>
                                                                            <small>30,641 (prev)</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overview-single__chart">
                                                                        <div class="parentContainer">
                                                                            <div>
                                                                                <canvas id="lineChartSeven"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-12 col-md-6 co-last">
                                                                <div class="overview-single">
                                                                    <div class="overview-content">
                                                                        <h1>2,132</h1>
                                                                        <p>New Page Like</p>
                                                                        <div>
                                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                                <strong>23%</strong></span>
                                                                            <small>30,641 (prev)</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overview-single__chart">
                                                                        <div class="parentContainer">
                                                                            <div>
                                                                                <canvas id="lineChartEight"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Month Tab -->
                                        <div class="tab-pane fade" id="f_overview-month" role="" aria-labelledby="f_overview-tab">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="card-overview__left">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-12 col-md-6">
                                                                <div class="overview-single">
                                                                    <div class="overview-content">
                                                                        <h1>65,845</h1>
                                                                        <p>Engaged Users</p>
                                                                        <div>
                                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                                <strong>45%</strong></span>
                                                                            <small>50,641 (prev)</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overview-single__chart">
                                                                        <div class="parentContainer">
                                                                            <div>
                                                                                <canvas id="lineChartNine"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-12 col-md-6 br-1">
                                                                <div class="overview-single">
                                                                    <div class="overview-content">
                                                                        <h1>6,534</h1>
                                                                        <p>Page Impressions</p>
                                                                        <div>
                                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                                <strong>60%</strong></span>
                                                                            <small>40,641 (prev)</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overview-single__chart">
                                                                        <div class="parentContainer">
                                                                            <div>
                                                                                <canvas id="lineChartTen"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="card-overview__right">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-12 col-md-6">
                                                                <div class="overview-single">
                                                                    <div class="overview-content">
                                                                        <h1>6,142</h1>
                                                                        <p>Total Page Likes</p>
                                                                        <div>
                                                                            <span class="color-danger"><i data-feather="trending-down"></i>
                                                                                <strong>35%</strong></span>
                                                                            <small>40,641 (prev)</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overview-single__chart">
                                                                        <div class="parentContainer">
                                                                            <div>
                                                                                <canvas id="lineChartEleven"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-12 col-md-6 co-last">
                                                                <div class="overview-single">
                                                                    <div class="overview-content">
                                                                        <h1>3,132</h1>
                                                                        <p>New Page Like</p>
                                                                        <div>
                                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                                <strong>33%</strong></span>
                                                                            <small>40,641 (prev)</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overview-single__chart">
                                                                        <div class="parentContainer">
                                                                            <div>
                                                                                <canvas id="lineChartTwelve"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Year Tab -->
                                        <div class="tab-pane fade" id="f_overview-year" role="" aria-labelledby="f_overview-tab">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="card-overview__left">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-12 col-md-6">
                                                                <div class="overview-single">
                                                                    <div class="overview-content">
                                                                        <h1>85,845</h1>
                                                                        <p>Engaged Users</p>
                                                                        <div>
                                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                                <strong>55%</strong></span>
                                                                            <small>60,641 (prev)</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overview-single__chart">
                                                                        <div class="parentContainer">
                                                                            <div>
                                                                                <canvas id="lineChartThirteen"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-12 col-md-6 br-1">
                                                                <div class="overview-single">
                                                                    <div class="overview-content">
                                                                        <h1>8,534</h1>
                                                                        <p>Page Impressions</p>
                                                                        <div>
                                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                                <strong>70%</strong></span>
                                                                            <small>50,641 (prev)</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overview-single__chart">
                                                                        <div class="parentContainer">
                                                                            <div>
                                                                                <canvas id="lineChartFourteen"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="card-overview__right">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-12 col-md-6">
                                                                <div class="overview-single">
                                                                    <div class="overview-content">
                                                                        <h1>8,142</h1>
                                                                        <p>Total Page Likes</p>
                                                                        <div>
                                                                            <span class="color-danger"><i data-feather="trending-down"></i>
                                                                                <strong>45%</strong></span>
                                                                            <small>50,641 (prev)</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overview-single__chart">
                                                                        <div class="parentContainer">
                                                                            <div>
                                                                                <canvas id="lineChartFifteen"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-12 col-md-6 co-last">
                                                                <div class="overview-single">
                                                                    <div class="overview-content">
                                                                        <h1>4,132</h1>
                                                                        <p>New Page Like</p>
                                                                        <div>
                                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                                <strong>43%</strong></span>
                                                                            <small>50,641 (prev)</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overview-single__chart">
                                                                        <div class="parentContainer">
                                                                            <div>
                                                                                <canvas id="lineChartSixteen"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- YouTube Subscribers -->
                    <div class="row">
                        <div class="col-lg-4 mb-25">
                            <div class="card border-0">
                                <div class="card-header">
                                    <h6>YouTube Subscribers</h6>
                                </div>
                                <div class="card-body">
                                    <div class="youtube-subscriber-wrap">
                                        <div class="youtube-subscriber-content">
                                            <h1>2,142</h1>
                                            <p>Total Subscribers</p>
                                            <div>
                                                <span class="color-success"><i data-feather="trending-up"></i>
                                                    <strong>15%</strong></span>
                                                <small>20,641 (prev)</small>
                                            </div>
                                        </div>
                                        <div class="youtube-subscriber-chart">
                                            <div class="parentContainer">
                                                <div>
                                                    <canvas id="youtubeChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Twitter Overview -->
                        <div class="col-lg-4 mb-25">
                            <div class="card border-0">
                                <div class="card-header">
                                    <h6>Twitter Overview</h6>
                                </div>
                                <div class="card-body">
                                    <div class="twitter-overview-wrap">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="twitter-overview-single">
                                                    <div class="twitter-overview-content">
                                                        <h1>1,234</h1>
                                                        <p>Tweets</p>
                                                        <div>
                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                <strong>12%</strong></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="twitter-overview-single">
                                                    <div class="twitter-overview-content">
                                                        <h1>567</h1>
                                                        <p>Retweets</p>
                                                        <div>
                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                <strong>8%</strong></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="twitter-overview-single">
                                                    <div class="twitter-overview-content">
                                                        <h1>2,345</h1>
                                                        <p>Likes</p>
                                                        <div>
                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                <strong>15%</strong></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="twitter-overview-single">
                                                    <div class="twitter-overview-content">
                                                        <h1>89</h1>
                                                        <p>Mentions</p>
                                                        <div>
                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                <strong>6%</strong></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Instagram Overview -->
                        <div class="col-lg-4 mb-25">
                            <div class="card border-0">
                                <div class="card-header">
                                    <h6>Instagram Overview</h6>
                                </div>
                                <div class="card-body">
                                    <div class="instagram-overview-wrap">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="instagram-overview-single">
                                                    <div class="instagram-overview-content">
                                                        <h1>156</h1>
                                                        <p>Posts</p>
                                                        <div>
                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                <strong>12%</strong></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="instagram-overview-single">
                                                    <div class="instagram-overview-content">
                                                        <h1>89</h1>
                                                        <p>Stories</p>
                                                        <div>
                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                <strong>8%</strong></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="instagram-overview-single">
                                                    <div class="instagram-overview-content">
                                                        <h1>34</h1>
                                                        <p>Reels</p>
                                                        <div>
                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                <strong>15%</strong></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="instagram-overview-single">
                                                    <div class="instagram-overview-content">
                                                        <h1>12</h1>
                                                        <p>IGTV</p>
                                                        <div>
                                                            <span class="color-success"><i data-feather="trending-up"></i>
                                                                <strong>6%</strong></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </StrikingDashLayout>
</template>
