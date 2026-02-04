<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Document</title>
</head>
<body>
    <header class="header">
        <div class="header-container">
            <div class="logo-section">
                <a href="../landing/index.php" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: white;">
                    <img src="../assets/nyu-logo.png" alt="NYU Logo" class="logo-icon">
                    <span class="logo-text">NEW YORK UNIVERSITY</span>
                </a>
            </div>
            <nav class="main-nav">
                <div class="nav-groups-wrapper">
                    <div class="nav-group nav-group-1">
                        <a href="../landing/about.php" class="nav-link">About</a>
                        <a href="../landing/research.php" class="nav-link">Research</a>
                        <a href="../landing/admissions.php" class="nav-link">Admissions</a>
                        <a href="../landing/news.php" class="nav-link">News</a>
                        <a href="../landing/academics.php" class="nav-link">Academics</a>
                        <a href="../landing/campus_life.php" class="nav-link">Campus Life</a>
                        <div class="search-container">
                            <input type="text" placeholder="Search..." class="search-input">
                            <button class="search-btn" aria-label="Search"></button>
                        </div>
                    </div>
                </div>
            </nav>
            <?php if ($user): ?>
            <div class="header-actions">
                <div class="user-wrap">
                    <div id="userDropdown" class="user-dropdown" aria-hidden="true">
                        <div class="user-info">
                            <div class="user-name"><?= htmlspecialchars(($user['username'] ?? '') . ' ' . ($user['username'] ?? '')) ?></div>
                            <div class="user-email"><?= htmlspecialchars($user['email'] ?? '') ?></div>
                            <div class="user-role"><?= htmlspecialchars($user['role_name'] ?? ($user['role_id'] ?? 'role_id')) ?></div>
                        </div>
                        <div class="user-actions">
                            <a href="../auth/logout.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="header-actions">
                <a href="../auth/login.php" class="login-btn" target="_blank">e-class</a>
            </div>
            <?php endif; ?>
        </div>
    </header>
</body>
</html>