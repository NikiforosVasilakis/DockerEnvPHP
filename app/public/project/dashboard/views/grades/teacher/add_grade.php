<?php
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

$studentName = isset($student['username']) ? $student['username'] : ($student['name'] ?? 'Selected Student');
$studentId = $student['id'] ?? ($old['student_id'] ?? 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Grade</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9edf3 100%);
            color: #1a1a1a;
        }
        .layout { display: flex; min-height: 100vh; }
        .content {
            flex: 1;
            margin-left: 240px;
            margin-top: 70px;
            padding: 3rem;
        }
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.35);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
        }
        .hero h1 { margin: 0 0 0.25rem 0; font-size: 1.9rem; }
        .hero p { margin: 0; opacity: 0.9; }
        .pill {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.75rem 1.25rem;
            border-radius: 999px;
            font-weight: 700;
            letter-spacing: 0.4px;
            text-transform: uppercase;
            font-size: 0.85rem;
        }
        .card {
            margin-top: 2rem;
            background: white;
            border-radius: 16px;
            padding: 1.75rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }
        .card h2 {
            margin: 0 0 1.25rem 0;
            font-size: 1.4rem;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .card h2::before {
            content: '';
            width: 6px;
            height: 26px;
            border-radius: 3px;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }
        .alert {
            margin: 1rem 0;
            padding: 0.9rem 1.1rem;
            border-radius: 10px;
            background: #fef2f2;
            border: 1px solid #fecdd3;
            color: #991b1b;
            font-weight: 700;
        }
        form { display: grid; gap: 1rem; }
        label { font-weight: 700; color: #374151; }
        input, select, textarea {
            width: 100%;
            padding: 0.85rem 1rem;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            font-size: 1rem;
            background: #f9fafb;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
            background: #fff;
        }
        textarea { min-height: 120px; resize: vertical; }
        .actions { display: flex; gap: 0.75rem; flex-wrap: wrap; margin-top: 0.5rem; }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.9rem 1.4rem;
            border-radius: 12px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 10px 24px rgba(102, 126, 234, 0.4);
            transition: transform 0.1s ease, box-shadow 0.15s ease;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 14px 30px rgba(102, 126, 234, 0.45); }
        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #e5e7eb;
            padding: 0.9rem 1.3rem;
            border-radius: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: background 0.15s ease, border-color 0.15s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-secondary:hover { background: #e5e7eb; border-color: #d1d5db; }
        @media (max-width: 768px) {
            .content { margin-left: 0; padding: 1.5rem; margin-top: 60px; }
            .hero { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
    <?php include_once __DIR__ . '/../../../../components/sidebar.php'; ?>
    <?php include_once __DIR__ . '/../../../../components/top-bar.php'; ?>

    <div class="layout">
        <div class="content">
            <div class="hero">
                <div>
                    <h1>Add Final Grade</h1>
                    <p>Record the final mark for <?php echo htmlspecialchars($studentName); ?>.</p>
                </div>
                <div class="pill">Teacher</div>
            </div>

            <div class="card">
                <h2>Grade Details</h2>
				<?php if (!empty($errors)): ?>
					<div class="alert">
						<?php echo htmlspecialchars(implode(' ', $errors)); ?>
					</div>
				<?php endif; ?>
				<form action="<?php echo BASE_URL; ?>/project/teacher/dashboard/grades" method="post">
					<input type="hidden" name="student_id" value="<?php echo htmlspecialchars((string) $studentId); ?>">
                    <div>
                        <label for="student">Student</label>
                        <input id="student" name="student_display" type="text" value="<?php echo htmlspecialchars($studentName); ?>" readonly>
                    </div>
                    <div>
                        <label for="course">Course / Module</label>
                        <input id="course" name="course" type="text" placeholder="e.g., Web Development" value="<?php echo htmlspecialchars($old['course'] ?? ''); ?>">
                    </div>
                    <div>
                        <label for="grade">Letter Grade</label>
                        <select id="grade" name="grade">
                            <?php
                                $gradeOptions = ['A+','A','A-','B+','B','B-','C+','C','C-','D','F'];
                                $selectedGrade = $old['grade'] ?? '';
                            ?>
                            <option value="" disabled <?php echo $selectedGrade === '' ? 'selected' : ''; ?>>Select grade</option>
                            <?php foreach ($gradeOptions as $opt): ?>
                                <option value="<?php echo $opt; ?>" <?php echo $selectedGrade === $opt ? 'selected' : ''; ?>><?php echo $opt; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="percentage">Percentage</label>
                        <input id="percentage" name="percentage" type="number" min="0" max="100" step="0.1" placeholder="e.g., 92.5" value="<?php echo htmlspecialchars($old['percentage'] ?? ''); ?>">
                    </div>
                    <div>
                        <label for="comments">Feedback</label>
                        <textarea id="comments" name="comments" placeholder="Brief feedback or notes"><?php echo htmlspecialchars($old['comments'] ?? ''); ?></textarea>
                    </div>
                    <div class="actions">
						<button class="btn-primary" type="submit">Save Grade</button>
                        <a class="btn-secondary" href="<?php echo BASE_URL; ?>/project/teacher/dashboard/grades">Back to Grades</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
