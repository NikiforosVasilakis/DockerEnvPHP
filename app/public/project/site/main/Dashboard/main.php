<?php 
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$role_name = isset($user['role_name']) ? strtoupper($user['role_name']) : 'USER';
?>

<?php include '../../components/sidebar.php';?>
<?php include '../../components/top-bar.php';?>

<div class="main-content">
    <link rel="stylesheet" href="styles.css">
    
    <?php if ($user): ?>
    <div class="welcome-text">
        HELLO <?php echo htmlspecialchars($role_name); ?>
    </div>
    <?php endif; ?>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #EEF2FF;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#5B5FFF" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-info">
                <h3>Total Students</h3>
                <p class="stat-number">1,234</p>
                <span class="stat-change positive">+12% from last month</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #FEF3C7;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                </svg>
            </div>
            <div class="stat-info">
                <h3>Total Teachers</h3>
                <p class="stat-number">87</p>
                <span class="stat-change positive">+3 new this month</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #DBEAFE;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#3B82F6" stroke-width="2">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                </svg>
            </div>
            <div class="stat-info">
                <h3>Total Courses</h3>
                <p class="stat-number">42</p>
                <span class="stat-change positive">+5 this semester</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #D1FAE5;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
            </div>
            <div class="stat-info">
                <h3>Avg Attendance</h3>
                <p class="stat-number">92%</p>
                <span class="stat-change positive">+2% from last week</span>
            </div>
        </div>
    </div>

    <div class="charts-section">
        <div class="card chart-card">
            <div class="card-header">
                <h2>Student Enrollment Trend</h2>
                <select class="chart-filter">
                    <option>Last 6 Months</option>
                    <option>Last Year</option>
                </select>
            </div>
            <div class="chart-container">
                <svg class="line-chart" viewBox="0 0 600 250">
                    <defs>
                        <linearGradient id="lineGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#5B5FFF;stop-opacity:0.3" />
                            <stop offset="100%" style="stop-color:#5B5FFF;stop-opacity:0" />
                        </linearGradient>
                    </defs>
                    <polyline 
                        fill="url(#lineGradient)" 
                        stroke="none"
                        points="50,180 100,160 150,140 200,150 250,120 300,100 350,90 400,110 450,85 500,70 550,60 550,200 50,200" 
                    />
                    <polyline 
                        fill="none" 
                        stroke="#5B5FFF" 
                        stroke-width="3"
                        points="50,180 100,160 150,140 200,150 250,120 300,100 350,90 400,110 450,85 500,70 550,60" 
                    />
                    <circle cx="50" cy="180" r="4" fill="#5B5FFF" />
                    <circle cx="100" cy="160" r="4" fill="#5B5FFF" />
                    <circle cx="150" cy="140" r="4" fill="#5B5FFF" />
                    <circle cx="200" cy="150" r="4" fill="#5B5FFF" />
                    <circle cx="250" cy="120" r="4" fill="#5B5FFF" />
                    <circle cx="300" cy="100" r="4" fill="#5B5FFF" />
                    <circle cx="350" cy="90" r="4" fill="#5B5FFF" />
                    <circle cx="400" cy="110" r="4" fill="#5B5FFF" />
                    <circle cx="450" cy="85" r="4" fill="#5B5FFF" />
                    <circle cx="500" cy="70" r="4" fill="#5B5FFF" />
                    <circle cx="550" cy="60" r="4" fill="#5B5FFF" />
                    <text x="50" y="220" font-size="12" fill="#6b7280" text-anchor="middle">Jan</text>
                    <text x="150" y="220" font-size="12" fill="#6b7280" text-anchor="middle">Feb</text>
                    <text x="250" y="220" font-size="12" fill="#6b7280" text-anchor="middle">Mar</text>
                    <text x="350" y="220" font-size="12" fill="#6b7280" text-anchor="middle">Apr</text>
                    <text x="450" y="220" font-size="12" fill="#6b7280" text-anchor="middle">May</text>
                    <text x="550" y="220" font-size="12" fill="#6b7280" text-anchor="middle">Jun</text>
                </svg>
            </div>
        </div>

        <div class="card chart-card">
            <div class="card-header">
                <h2>Course Distribution</h2>
            </div>
            <div class="chart-container">
                <div class="donut-chart">
                    <svg viewBox="0 0 200 200">
                        <circle cx="100" cy="100" r="80" fill="none" stroke="#5B5FFF" stroke-width="40" stroke-dasharray="157 314" transform="rotate(-90 100 100)" />
                        <circle cx="100" cy="100" r="80" fill="none" stroke="#3B82F6" stroke-width="40" stroke-dasharray="94 377" stroke-dashoffset="-157" transform="rotate(-90 100 100)" />
                        <circle cx="100" cy="100" r="80" fill="none" stroke="#F59E0B" stroke-width="40" stroke-dasharray="63 408" stroke-dashoffset="-251" transform="rotate(-90 100 100)" />
                        <text x="100" y="95" font-size="28" font-weight="700" fill="#1a1a1a" text-anchor="middle">42</text>
                        <text x="100" y="115" font-size="14" fill="#6b7280" text-anchor="middle">Courses</text>
                    </svg>
                </div>
                <div class="chart-legend">
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #5B5FFF;"></span>
                        <span class="legend-label">Computer Science</span>
                        <span class="legend-value">18</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #3B82F6;"></span>
                        <span class="legend-label">Mathematics</span>
                        <span class="legend-value">12</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #F59E0B;"></span>
                        <span class="legend-label">Physics</span>
                        <span class="legend-value">12</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="card">
            <div class="card-header">
                <h2>Weekly Attendance</h2>
            </div>
            <div class="chart-container">
                <div class="bar-chart">
                    <div class="bar-item">
                        <div class="bar-wrapper">
                            <div class="bar" style="height: 85%; background: #5B5FFF;"></div>
                        </div>
                        <span class="bar-label">Mon</span>
                        <span class="bar-value">85%</span>
                    </div>
                    <div class="bar-item">
                        <div class="bar-wrapper">
                            <div class="bar" style="height: 92%; background: #5B5FFF;"></div>
                        </div>
                        <span class="bar-label">Tue</span>
                        <span class="bar-value">92%</span>
                    </div>
                    <div class="bar-item">
                        <div class="bar-wrapper">
                            <div class="bar" style="height: 88%; background: #5B5FFF;"></div>
                        </div>
                        <span class="bar-label">Wed</span>
                        <span class="bar-value">88%</span>
                    </div>
                    <div class="bar-item">
                        <div class="bar-wrapper">
                            <div class="bar" style="height: 94%; background: #5B5FFF;"></div>
                        </div>
                        <span class="bar-label">Thu</span>
                        <span class="bar-value">94%</span>
                    </div>
                    <div class="bar-item">
                        <div class="bar-wrapper">
                            <div class="bar" style="height: 78%; background: #5B5FFF;"></div>
                        </div>
                        <span class="bar-label">Fri</span>
                        <span class="bar-value">78%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card recent-activity">
            <div class="card-header">
                <h2>Recent Activity</h2>
                <button class="view-all-btn">View All</button>
            </div>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon" style="background: #EEF2FF; color: #5B5FFF;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <polyline points="17 11 19 13 23 9"></polyline>
                        </svg>
                    </div>
                    <div class="activity-details">
                        <p class="activity-text"><strong>John Smith</strong> enrolled in Computer Science 101</p>
                        <span class="activity-time">2 minutes ago</span>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon" style="background: #FEF3C7; color: #F59E0B;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                    <div class="activity-details">
                        <p class="activity-text"><strong>Dr. Sarah Johnson</strong> uploaded new course material</p>
                        <span class="activity-time">15 minutes ago</span>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon" style="background: #DBEAFE; color: #3B82F6;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                        </svg>
                    </div>
                    <div class="activity-details">
                        <p class="activity-text"><strong>Emma Davis</strong> submitted assignment for Math 201</p>
                        <span class="activity-time">1 hour ago</span>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon" style="background: #FCE7F3; color: #EC4899;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div class="activity-details">
                        <p class="activity-text">New exam scheduled for <strong>Physics 301</strong></p>
                        <span class="activity-time">3 hours ago</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-grid" style="margin-top: 2rem;">
        <div class="card upcoming-classes">
            <div class="card-header">
                <h2>Upcoming Classes</h2>
                <button class="view-all-btn">View Schedule</button>
            </div>
            <div class="class-list">
                <div class="class-item">
                    <div class="class-time">
                        <span class="time">9:00 AM</span>
                        <span class="duration">1h 30m</span>
                    </div>
                    <div class="class-details">
                        <h4>Computer Science 101</h4>
                        <p>Dr. Michael Brown</p>
                        <span class="room">Room 304, Building A</span>
                    </div>
                </div>

                <div class="class-item">
                    <div class="class-time">
                        <span class="time">11:00 AM</span>
                        <span class="duration">2h</span>
                    </div>
                    <div class="class-details">
                        <h4>Mathematics 201</h4>
                        <p>Dr. Sarah Johnson</p>
                        <span class="room">Room 212, Building B</span>
                    </div>
                </div>

                <div class="class-item">
                    <div class="class-time">
                        <span class="time">2:00 PM</span>
                        <span class="duration">1h 45m</span>
                    </div>
                    <div class="class-details">
                        <h4>Physics 301</h4>
                        <p>Dr. Robert Wilson</p>
                        <span class="room">Lab 101, Building C</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Top Performing Students</h2>
            </div>
            <div class="student-list">
                <div class="student-item">
                    <div class="student-rank">1</div>
                    <div class="student-info">
                        <h4>Emily Chen</h4>
                        <p>Computer Science</p>
                    </div>
                    <div class="student-score">98.5%</div>
                </div>
                <div class="student-item">
                    <div class="student-rank">2</div>
                    <div class="student-info">
                        <h4>Michael Johnson</h4>
                        <p>Mathematics</p>
                    </div>
                    <div class="student-score">97.2%</div>
                </div>
                <div class="student-item">
                    <div class="student-rank">3</div>
                    <div class="student-info">
                        <h4>Sarah Williams</h4>
                        <p>Physics</p>
                    </div>
                    <div class="student-score">96.8%</div>
                </div>
                <div class="student-item">
                    <div class="student-rank">4</div>
                    <div class="student-info">
                        <h4>David Martinez</h4>
                        <p>Computer Science</p>
                    </div>
                    <div class="student-score">95.9%</div>
                </div>
            </div>
        </div>
    </div>
</div>

