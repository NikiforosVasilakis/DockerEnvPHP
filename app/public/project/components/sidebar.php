<aside class="admin-sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="logo-circle">
                <!-- make the pic of the user -->
            </div>
            <span class="sidebar-logo-text">Dashboard</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <a href="dashboard.php" class="sidebar-link">
            <svg class="sidebar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            <span>Dashboard</span>
        </a>
        <a href="students.php" class="sidebar-link">
            <svg class="sidebar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Students</span>
        </a>
        <a href="courses.php" class="sidebar-link">
            <svg class="sidebar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
            </svg>
            <span>Courses</span>
        </a>
        <a href="teachers.php" class="sidebar-link">
            <svg class="sidebar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Teachers</span>
        </a>
        <a href="attendance.php" class="sidebar-link">
            <svg class="sidebar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <span>Attendance</span>
        </a>
        <a href="payment.php" class="sidebar-link">
            <svg class="sidebar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
            <span>Payment</span>
        </a>
        <a href="settings.php" class="sidebar-link">
            <svg class="sidebar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="3"></circle>
                <path d="M12 1v6m0 6v6m-7.07-7.07l4.24 4.24m2.83 0l4.24 4.24M1 12h6m6 0h6m-7.07 7.07l4.24-4.24m2.83-2.83l4.24-4.24"></path>
            </svg>
            <span>Settings</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <p>&copy; <?= date('Y') ?> Admin Panel.<br>All rights reserved.</p>
    </div>
</aside>

<style>
.admin-sidebar {
    width: 240px;
    height: 100vh;
    background: #5B5FFF;
    color: white;
    position: fixed;
    left: 0;
    top: 0;
    display: flex;
    flex-direction: column;
    box-shadow: 2px 0 12px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
    padding: 1.5rem;
}

.admin-sidebar::-webkit-scrollbar {
    display: none;
}

.sidebar-header {
    margin-bottom: 2rem;
}

.sidebar-logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.logo-circle {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px;
}

.sidebar-logo-icon {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.sidebar-logo-text {
    font-size: 1.1rem;
    font-weight: 600;
    letter-spacing: 0.3px;
}

.sidebar-nav {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    overflow-y: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.sidebar-nav::-webkit-scrollbar {
    display: none;
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1rem;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 500;
    transition: all 0.2s ease;
    border-radius: 8px;
}

.sidebar-link:hover {
    background-color: rgba(255, 255, 255, 0.15);
    color: white;
}

.sidebar-link.active {
    background-color: rgba(255, 255, 255, 0.2);
    color: white;
}

.sidebar-icon {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
}


.sidebar-footer {
    margin-top: 0;
    padding-top: 0;
    text-align: center;
}

.sidebar-footer p {
    margin: 0;
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
    line-height: 1.4;
}



@media (max-width: 1024px) {
    .admin-sidebar {
        width: 200px;
        padding: 1rem;
    }

    .sidebar-logo-text {
        font-size: 1rem;
    }

    .sidebar-link {
        font-size: 0.9rem;
        padding: 0.75rem 0.875rem;
    }
}

@media (max-width: 768px) {
    .admin-sidebar {
        width: 180px;
        padding: 0.875rem;
    }

    .admin-request-card {
        padding: 1rem;
    }
}
</style>
