<script setup lang="ts">
import StrikingDashLayout from '@/layouts/StrikingDashLayout.vue';
import { Head } from '@inertiajs/vue3';

// Sample data for demonstration
const socialMediaData = [
    { platform: 'Facebook', icon: 'facebook', count: '5,461', label: 'Likes' },
    { platform: 'Twitter', icon: 'twitter', count: '5,461', label: 'Followers' },
    { platform: 'Instagram', icon: 'instagram', count: '5,461', label: 'Followers' },
    { platform: 'YouTube', icon: 'youtube', count: '5,461', label: 'Subscribers' },
    { platform: 'Pinterest', icon: 'pinterest', count: '5,461', label: 'Followers' },
    { platform: 'LinkedIn', icon: 'linkedin', count: '5,461', label: 'Followers' }
];

const facebookMetrics = [
    { title: 'Engaged Users', value: '25,845', change: '+25%', trend: 'up', prev: '20,641', color: 'green' },
    { title: 'Page Impressions', value: '2,534', change: '+40%', trend: 'up', prev: '20,641', color: 'pink' },
    { title: 'Total Page Likes', value: '2,142', change: '-15%', trend: 'down', prev: '20,641', color: 'blue' },
    { title: 'New Page Like', value: '1,132', change: '+13%', trend: 'up', prev: '20,641', color: 'orange' }
];

const youtubeData = {
    title: 'Youtube Subscribers',
    value: '25,472',
    change: '+25%',
    trend: 'up'
};

const twitterMetrics = [
    { title: 'Tweets', value: '278', change: '+14%', trend: 'up', color: 'green' },
    { title: 'Tweet Impressions', value: '78.8k', change: '+14%', trend: 'up', color: 'green' },
    { title: 'New Followers', value: '3,015', change: '-14%', trend: 'down', color: 'red' },
    { title: 'Engagement Rates', value: '', change: '', trend: 'up', color: 'green' }
];

const instagramMetrics = [
    { title: 'Likes', value: '278', change: '+14%', trend: 'up', color: 'green' },
    { title: 'Comments', value: '78.8k', change: '+14%', trend: 'up', color: 'green' },
    { title: 'New Followers', value: '3,015', change: '-14%', trend: 'down', color: 'red' },
    { title: 'Engagement Rates', value: '', change: '', trend: 'up', color: 'green' }
];
</script>

<template>
    <Head title="Social Media Dashboard" />
    
    <StrikingDashLayout>
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <h4 class="mb-0">Social Media Dashboard</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="date-range-selector">
                        <i class="fas fa-calendar-alt me-2"></i>
                        <span>Oct 30, 2019 - Nov 30, 2019</span>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </div>
                    <button class="btn btn-outline-secondary">
                        <i class="fas fa-download me-2"></i>Export
                    </button>
                    <button class="btn btn-outline-secondary">
                        <i class="fas fa-share me-2"></i>Share
                    </button>
                    <button class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New
                    </button>
                </div>
            </div>
        </div>

        <!-- Social Media Overview -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card social-overview-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Social Media Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div 
                                v-for="item in socialMediaData" 
                                :key="item.platform"
                                class="col-md-2 col-sm-4 col-6 mb-3"
                            >
                                <div class="social-media-item text-center">
                                    <div class="social-icon mb-3">
                                        <i :class="`fab fa-${item.icon}`"></i>
                                    </div>
                                    <h3 class="mb-1">{{ item.count }}</h3>
                                    <p class="text-muted mb-0">{{ item.label }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Facebook Overview -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Facebook Overview</h5>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary active">Today</button>
                            <button type="button" class="btn btn-sm btn-outline-primary">Week</button>
                            <button type="button" class="btn btn-sm btn-outline-primary">Month</button>
                            <button type="button" class="btn btn-sm btn-outline-primary">Year</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div 
                                v-for="metric in facebookMetrics" 
                                :key="metric.title"
                                class="col-md-3 col-sm-6 mb-4"
                            >
                                <div class="metric-card">
                                    <div class="metric-header">
                                        <h6 class="text-muted mb-2">{{ metric.title }}</h6>
                                        <div class="metric-value">
                                            <h2 class="mb-1">{{ metric.value }}</h2>
                                            <div class="metric-change">
                                                <span 
                                                    :class="`badge badge-${metric.trend === 'up' ? 'success' : 'danger'} me-2`"
                                                >
                                                    <i :class="`fas fa-arrow-${metric.trend === 'up' ? 'up' : 'down'}`"></i>
                                                    {{ metric.change }}
                                                </span>
                                                <small class="text-muted">{{ metric.prev }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mini-chart mt-3">
                                        <div class="chart-line" :class="`chart-${metric.color}`"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- YouTube and Twitter Row -->
        <div class="row mb-4">
            <!-- YouTube Subscribers -->
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">{{ youtubeData.title }}</h5>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary">Week</button>
                            <button type="button" class="btn btn-sm btn-outline-primary active">Month</button>
                            <button type="button" class="btn btn-sm btn-outline-primary">Year</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h2 class="mb-1">{{ youtubeData.value }}</h2>
                                <span class="badge badge-success">
                                    <i class="fas fa-arrow-up me-1"></i>
                                    {{ youtubeData.change }}
                                </span>
                            </div>
                        </div>
                        <div class="chart-legend mb-3">
                            <div class="legend-item">
                                <span class="legend-dot gained"></span>
                                <span>Gained</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-dot lost"></span>
                                <span>Lost</span>
                            </div>
                        </div>
                        <div class="chart-container">
                            <div class="bar-chart">
                                <div class="bar gained" style="height: 60%"></div>
                                <div class="bar lost" style="height: 40%"></div>
                                <div class="bar gained" style="height: 80%"></div>
                                <div class="bar lost" style="height: 30%"></div>
                                <div class="bar gained" style="height: 70%"></div>
                                <div class="bar lost" style="height: 50%"></div>
                                <div class="bar gained" style="height: 90%"></div>
                                <div class="bar lost" style="height: 20%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Twitter Overview -->
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Twitter Overview</h5>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary">Week</button>
                            <button type="button" class="btn btn-sm btn-outline-primary active">Month</button>
                            <button type="button" class="btn btn-sm btn-outline-primary">Year</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="twitter-metrics">
                            <div 
                                v-for="metric in twitterMetrics" 
                                :key="metric.title"
                                class="twitter-metric-item"
                            >
                                <div class="metric-info">
                                    <h6 class="text-muted mb-1">{{ metric.title }}</h6>
                                    <div class="metric-value-row">
                                        <h4 class="mb-1">{{ metric.value }}</h4>
                                        <span 
                                            :class="`badge badge-${metric.trend === 'up' ? 'success' : 'danger'}`"
                                        >
                                            <i :class="`fas fa-arrow-${metric.trend === 'up' ? 'up' : 'down'}`"></i>
                                            {{ metric.change }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mini-chart">
                                    <div class="chart-line" :class="`chart-${metric.color}`"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instagram Overview -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Instagram Overview</h5>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary">Week</button>
                            <button type="button" class="btn btn-sm btn-outline-primary active">Month</button>
                            <button type="button" class="btn btn-sm btn-outline-primary">Year</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div 
                                v-for="metric in instagramMetrics" 
                                :key="metric.title"
                                class="col-md-3 col-sm-6 mb-3"
                            >
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="metric-info">
                                        <h6 class="text-muted mb-1">{{ metric.title }}</h6>
                                        <div class="metric-value-row">
                                            <h4 class="mb-1">{{ metric.value }}</h4>
                                            <span 
                                                :class="`badge badge-${metric.trend === 'up' ? 'success' : 'danger'}`"
                                            >
                                                <i :class="`fas fa-arrow-${metric.trend === 'up' ? 'up' : 'down'}`"></i>
                                                {{ metric.change }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mini-chart">
                                        <div class="chart-line" :class="`chart-${metric.color}`"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating Action Button -->
        <div class="floating-action-btn">
            <button class="btn btn-primary btn-circle">
                <i class="fas fa-cog"></i>
            </button>
        </div>
    </StrikingDashLayout>
</template>

<style scoped>
/* Page Header */
.page-header {
    margin-bottom: 2rem;
}

.date-range-selector {
    display: flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background: #f8f9fa;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    color: #6b7280;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s;
}

.date-range-selector:hover {
    background: #e9ecef;
}

/* Social Media Overview */
.social-overview-card .card-body {
    padding: 2rem;
}

.social-media-item {
    padding: 1.5rem 1rem;
    border-radius: 0.75rem;
    background: #fff;
    border: 1px solid #e5e7eb;
    transition: all 0.2s;
    height: 100%;
}

.social-media-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.social-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.social-icon .fa-facebook { color: #1877f2; }
.social-icon .fa-twitter { color: #1da1f2; }
.social-icon .fa-instagram { color: #e4405f; }
.social-icon .fa-youtube { color: #ff0000; }
.social-icon .fa-pinterest { color: #bd081c; }
.social-icon .fa-linkedin { color: #0077b5; }

/* Facebook Overview */
.metric-card {
    padding: 1.5rem;
    border-radius: 0.75rem;
    background: #fff;
    border: 1px solid #e5e7eb;
    height: 100%;
}

.metric-header h6 {
    font-size: 0.875rem;
    font-weight: 500;
    color: #6b7280;
    margin-bottom: 0.75rem;
}

.metric-value h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.5rem;
}

.metric-change {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.metric-change .badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

.metric-change small {
    font-size: 0.75rem;
    color: #6b7280;
}

.mini-chart {
    width: 100%;
    height: 40px;
    position: relative;
    margin-top: 1rem;
}

.chart-line {
    width: 100%;
    height: 3px;
    border-radius: 2px;
    position: relative;
}

.chart-line::after {
    content: '';
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.chart-green {
    background: linear-gradient(90deg, #10b981, #34d399);
}

.chart-green::after {
    background: #10b981;
}

.chart-pink {
    background: linear-gradient(90deg, #ec4899, #f472b6);
}

.chart-pink::after {
    background: #ec4899;
}

.chart-blue {
    background: linear-gradient(90deg, #3b82f6, #60a5fa);
}

.chart-blue::after {
    background: #3b82f6;
}

.chart-orange {
    background: linear-gradient(90deg, #f59e0b, #fbbf24);
}

.chart-orange::after {
    background: #f59e0b;
}

.chart-red {
    background: linear-gradient(90deg, #ef4444, #f87171);
}

.chart-red::after {
    background: #ef4444;
}

/* YouTube Chart */
.chart-legend {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #6b7280;
}

.legend-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.legend-dot.gained {
    background: #5f63f2;
}

.legend-dot.lost {
    background: #ef4444;
}

.bar-chart {
    display: flex;
    align-items: end;
    gap: 3px;
    height: 120px;
    padding: 0.5rem 0;
}

.bar {
    flex: 1;
    border-radius: 2px;
    min-height: 4px;
}

.bar.gained {
    background: #5f63f2;
}

.bar.lost {
    background: #ef4444;
}

.chart-container {
    height: 120px;
}

/* Twitter Metrics */
.twitter-metrics {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.twitter-metric-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
}

.metric-info h6 {
    font-size: 0.875rem;
    font-weight: 500;
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.metric-value-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.metric-value-row h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #111827;
    margin: 0;
}

.twitter-metric-item .mini-chart {
    width: 60px;
    height: 30px;
}

/* Instagram Metrics */
.instagram-metrics .row > div {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}

/* Button Groups */
.btn-group .btn {
    border-radius: 0.375rem;
    margin-right: 0.25rem;
    font-size: 0.875rem;
    padding: 0.375rem 0.75rem;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.btn-group .btn.active {
    background-color: #5f63f2;
    border-color: #5f63f2;
    color: white;
}

/* Floating Action Button */
.floating-action-btn {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    z-index: 1000;
}

.btn-circle {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    box-shadow: 0 4px 12px rgba(95, 99, 242, 0.3);
}

.btn-circle:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(95, 99, 242, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .social-overview-card .card-body {
        padding: 1rem;
    }
    
    .social-media-item {
        padding: 1rem 0.5rem;
    }
    
    .metric-card {
        padding: 1rem;
    }
    
    .twitter-metric-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .floating-action-btn {
        bottom: 1rem;
        right: 1rem;
    }
}
</style>
