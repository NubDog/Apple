@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Stats Section -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-title">Total Sales</div>
            <div class="stat-value">${{ number_format($totalSales, 2) }}</div>
            <div class="stat-change">
                <i class="bi bi-arrow-up-short"></i> 13.2% from last month
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-title">Total Orders</div>
            <div class="stat-value">{{ $totalOrders }}</div>
            <div class="stat-change">
                <i class="bi bi-arrow-up-short"></i> 8.9% from last month
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-title">Total Products</div>
            <div class="stat-value">{{ $totalProducts }}</div>
            <div class="stat-change">
                <i class="bi bi-arrow-up-short"></i> 5.1% from last month
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-title">Total Customers</div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-change">
                <i class="bi bi-arrow-up-short"></i> 12.4% from last month
            </div>
        </div>
    </div>
    
    <!-- Activities & Analytics Section -->
    <div class="card">
        <div class="card-title">
            Activities
            <div class="actions">
                <a href="#" class="invite-btn">
                    <i class="bi bi-plus-circle"></i> Invite Members
                </a>
            </div>
        </div>
        
        <div class="tab-container">
            <div class="tab-nav">
                <button class="tab-btn active" data-tab="all">All</button>
                <button class="tab-btn" data-tab="completed">Completed</button>
                <button class="tab-btn" data-tab="inprogress">In Progress</button>
            </div>
            
            <div class="tab-content">
                <div class="tab-pane active" id="all">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="chart-container">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="analytics-section">
                                <h3>Analytics</h3>
                                <div class="analytics-legend">
                                    <div class="legend-item">
                                        <span class="legend-color" style="background-color: #7262fd;"></span>
                                        <span>Present Month</span>
                                    </div>
                                    <div class="legend-item">
                                        <span class="legend-color" style="background-color: #c1b7fd;"></span>
                                        <span>Past Month</span>
                                    </div>
                                </div>
                                <div class="chart-container">
                                    <canvas id="weeklyChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Course Statistics & Tasks Section -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-title">
                    Car Sales Statistics
                    <div class="actions">
                        <a href="#"><i class="bi bi-three-dots"></i></a>
                    </div>
                </div>
                
                <div class="legend-container">
                    <div class="legend-item">
                        <span class="dot" style="background-color: #7262fd;"></span>
                        <span>Finished</span>
                    </div>
                    <div class="legend-item">
                        <span class="dot" style="background-color: #f87171;"></span>
                        <span>Pending</span>
                    </div>
                </div>
                
                <div class="chart-container">
                    <canvas id="salesStatChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-title">
                    Tasks
                    <div class="date-filter">
                        <button class="date-nav-btn"><i class="bi bi-chevron-left"></i></button>
                        <span>{{ now()->format('F Y') }}</span>
                        <button class="date-nav-btn"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>
                
                <div class="tasks-chart-container">
                    <canvas id="tasksChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Calendar Section -->
    <div class="card">
        <div class="card-title">
            August 2023
            <div class="calendar-nav">
                <button class="calendar-nav-btn"><i class="bi bi-chevron-left"></i></button>
                <button class="calendar-nav-btn"><i class="bi bi-chevron-right"></i></button>
            </div>
        </div>
        
        <div class="calendar-container">
            <div class="calendar-header">
                <div class="calendar-day-header">MON</div>
                <div class="calendar-day-header">TUE</div>
                <div class="calendar-day-header">WED</div>
                <div class="calendar-day-header">THU</div>
                <div class="calendar-day-header">FRI</div>
                <div class="calendar-day-header">SAT</div>
                <div class="calendar-day-header">SUN</div>
            </div>
            
            <div class="calendar-grid">
                <!-- Calendar Days - First Row -->
                <div class="calendar-day other-month">28</div>
                <div class="calendar-day">1</div>
                <div class="calendar-day">2</div>
                <div class="calendar-day">3</div>
                <div class="calendar-day">4</div>
                <div class="calendar-day">5</div>
                <div class="calendar-day">6</div>
                
                <!-- Calendar Days - Second Row -->
                <div class="calendar-day">7</div>
                <div class="calendar-day">8</div>
                <div class="calendar-day">9</div>
                <div class="calendar-day">10</div>
                <div class="calendar-day">11</div>
                <div class="calendar-day">12</div>
                <div class="calendar-day">13</div>
                
                <!-- Calendar Days - Third Row -->
                <div class="calendar-day">14</div>
                <div class="calendar-day">15</div>
                <div class="calendar-day">16</div>
                <div class="calendar-day current">17</div>
                <div class="calendar-day">18</div>
                <div class="calendar-day">19</div>
                <div class="calendar-day">20</div>
                
                <!-- Calendar Days - Fourth Row -->
                <div class="calendar-day">21</div>
                <div class="calendar-day">22</div>
                <div class="calendar-day">23</div>
                <div class="calendar-day">24</div>
                <div class="calendar-day">25</div>
                <div class="calendar-day">26</div>
                <div class="calendar-day">27</div>
                
                <!-- Calendar Days - Fifth Row -->
                <div class="calendar-day">28</div>
                <div class="calendar-day">29</div>
                <div class="calendar-day">30</div>
                <div class="calendar-day">31</div>
                <div class="calendar-day other-month">1</div>
                <div class="calendar-day other-month">2</div>
                <div class="calendar-day other-month">3</div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .dashboard-container {
        width: 100%;
    }
    
    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -15px;
    }
    
    .col-md-4 {
        width: 33.3333%;
        padding: 0 15px;
    }
    
    .col-md-8 {
        width: 66.6667%;
        padding: 0 15px;
    }
    
    @media (max-width: 768px) {
        .col-md-4, .col-md-8 {
            width: 100%;
        }
    }
    
    .analytics-section {
        padding: 20px;
    }
    
    .analytics-section h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
    }
    
    .analytics-legend {
        display: flex;
        margin-bottom: 20px;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        margin-right: 20px;
    }
    
    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 5px;
    }
    
    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }
    
    .legend-container {
        display: flex;
        margin-bottom: 15px;
    }
    
    .date-filter {
        display: flex;
        align-items: center;
    }
    
    .date-nav-btn, .calendar-nav-btn {
        background: none;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    
    .calendar-header {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
        margin-bottom: 10px;
    }
    
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
    }
    
    .calendar-container {
        padding: 20px 0;
    }
    
    .invite-btn {
        color: var(--primary);
        text-decoration: none;
        display: flex;
        align-items: center;
        font-weight: 500;
    }
    
    .invite-btn i {
        margin-right: 5px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Sales Chart
        const salesChartCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesChartCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                datasets: [
                    {
                        label: 'Present Month',
                        data: [40, 45, 60, 35, 45, 65, 70, 60, 50],
                        borderColor: '#7262fd',
                        backgroundColor: 'rgba(114, 98, 253, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Past Month',
                        data: [20, 30, 40, 25, 10, 35, 55, 45, 40],
                        borderColor: '#c1b7fd',
                        backgroundColor: 'rgba(193, 183, 253, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    }
                ]
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
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            stepSize: 20
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // Weekly Chart
        const weeklyChartCtx = document.getElementById('weeklyChart').getContext('2d');
        const weeklyChart = new Chart(weeklyChartCtx, {
            type: 'bar',
            data: {
                labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                datasets: [
                    {
                        label: 'Present Month',
                        data: [45, 60, 30, 70, 20, 80],
                        backgroundColor: '#7262fd'
                    },
                    {
                        label: 'Past Month',
                        data: [35, 40, 50, 25, 45, 30],
                        backgroundColor: '#c1b7fd'
                    }
                ]
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
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // Sales Statistics Chart
        const salesStatChartCtx = document.getElementById('salesStatChart').getContext('2d');
        const salesStatChart = new Chart(salesStatChartCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [
                    {
                        label: 'Sales',
                        data: [20, 30, 25, 40, 35],
                        borderColor: '#7262fd',
                        backgroundColor: 'rgba(114, 98, 253, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    }
                ]
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
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // Tasks Chart
        const tasksChartCtx = document.getElementById('tasksChart').getContext('2d');
        const tasksChart = new Chart(tasksChartCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'Tasks',
                        data: [15, 30, 20, 40, 25, 35],
                        backgroundColor: '#7262fd'
                    }
                ]
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
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // Tab Functionality
        $('.tab-btn').on('click', function() {
            const tabId = $(this).data('tab');
            $('.tab-btn').removeClass('active');
            $(this).addClass('active');
            $('.tab-pane').removeClass('active');
            $(`#${tabId}`).addClass('active');
        });
    });
</script>
@endpush
@endsection 