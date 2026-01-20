<?php
$user = $_SESSION['user'] ?? [];
$userName = htmlspecialchars($user['username'] ?? 'Student');
$userEmail = htmlspecialchars($user['email'] ?? 'student@example.com');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f6fa;
            color: #1a1a1a;
        }
        .main-container {
            margin-left: 240px;
            margin-top: 70px;
            padding: 2rem;
            min-height: calc(100vh - 70px);
        }
        .settings-header {
            background: linear-gradient(135deg, #5B5FFF 0%, #764ba2 100%);
            color: #fff;
            padding: 1.75rem;
            border-radius: 18px;
            box-shadow: 0 4px 12px rgba(91, 95, 255, 0.18);
            margin-bottom: 1.5rem;
        }
        .settings-header h1 {
            margin: 0 0 0.35rem 0;
            font-size: 1.9rem;
        }
        .settings-header p {
            margin: 0;
            opacity: 0.9;
        }
        .settings-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border: 1px solid #eef0f4;
        }
        .card h2 {
            margin: 0 0 1rem 0;
            font-size: 1.2rem;
            color: #1f2937;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            margin-bottom: 1rem;
        }
        label {
            font-size: 0.95rem;
            color: #374151;
            font-weight: 600;
        }
        input, select, textarea {
            padding: 0.75rem 0.85rem;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.95rem;
            background: #f9fafb;
            transition: border-color 0.2s ease, background 0.2s ease;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #5B5FFF;
            background: #fff;
        }
        .btn-row {
            display: flex;
            gap: 0.75rem;
            margin-top: 0.5rem;
        }
        .btn-primary {
            background: #5B5FFF;
            color: #fff;
            border: none;
            padding: 0.75rem 1.2rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 16px rgba(91, 95, 255, 0.25);
        }
        .btn-secondary {
            background: #eef0f4;
            color: #1f2937;
            border: none;
            padding: 0.75rem 1.2rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }
        .divider {
            height: 1px;
            background: #eef0f4;
            margin: 1rem 0 1.25rem 0;
        }
        .toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #eef0f4;
        }
        .toggle-row:last-child { border-bottom: none; }
        .toggle-row span { color: #374151; font-weight: 600; }
        .switch {
            position: relative;
            display: inline-block;
            width: 42px;
            height: 24px;
        }
        .switch input { display: none; }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background: #d1d5db;
            transition: .2s;
            border-radius: 34px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 18px; width: 18px;
            left: 3px; bottom: 3px;
            background: white;
            transition: .2s;
            border-radius: 50%;
        }
        input:checked + .slider { background: #5B5FFF; }
        input:checked + .slider:before { transform: translateX(18px); }
        @media (max-width: 1024px) { .settings-grid { grid-template-columns: 1fr; } }
        @media (max-width: 768px) {
            .main-container { margin-left: 180px; padding: 1.5rem; }
            .settings-header h1 { font-size: 1.6rem; }
        }
    </style>
</head>
<body>
    <?php include BASE_PATH . '../components/sidebar.php'; ?>
    <?php include BASE_PATH . '/../../../components/top-bar.php'; ?>

    <div class="main-container">
        <div class="settings-header">
            <h1>Settings</h1>
            <p>Update your profile, password, and preferences</p>
        </div>

        <div class="settings-grid">
            <div class="card">
                <h2>Profile</h2>
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input id="name" name="name" type="text" value="<?php echo $userName; ?>" autocomplete="name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="<?php echo $userEmail; ?>" autocomplete="email">
                </div>
                <div class="btn-row">
                    <button class="btn-primary" type="button">Save Profile</button>
                    <button class="btn-secondary" type="button">Cancel</button>
                </div>
            </div>

            <div class="card">
                <h2>Password</h2>
                <div class="form-group">
                    <label for="current-password">Current Password</label>
                    <input id="current-password" name="current-password" type="password" autocomplete="current-password" placeholder="••••••••">
                </div>
                <div class="form-group">
                    <label for="new-password">New Password</label>
                    <input id="new-password" name="new-password" type="password" autocomplete="new-password" placeholder="••••••••">
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input id="confirm-password" name="confirm-password" type="password" autocomplete="new-password" placeholder="••••••••">
                </div>
                <div class="btn-row">
                    <button class="btn-primary" type="button">Update Password</button>
                </div>
            </div>

            <div class="card">
                <h2>Notifications</h2>
                <div class="toggle-row">
                    <span>Course updates</span>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="toggle-row">
                    <span>Assignment reminders</span>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="toggle-row">
                    <span>Grade alerts</span>
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="card">
                <h2>Preferences</h2>
                <div class="form-group">
                    <label for="timezone">Timezone</label>
                    <select id="timezone" name="timezone">
                        <option value="utc">UTC</option>
                        <option value="est">Eastern Time (EST)</option>
                        <option value="pst">Pacific Time (PST)</option>
                        <option value="gmt">Greenwich Mean Time (GMT)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea id="bio" name="bio" rows="4" placeholder="Add a short bio..." style="resize: vertical;"></textarea>
                </div>
                <div class="btn-row">
                    <button class="btn-primary" type="button">Save Preferences</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
