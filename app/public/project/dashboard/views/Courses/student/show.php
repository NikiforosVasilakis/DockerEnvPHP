<?php
// $course and $contents are provided by controller
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo htmlspecialchars($course['title']); ?> - Course</title>
	<link rel="stylesheet" href="../../../css/styles.css">
	<style>
		body {
			margin: 0;
			padding: 0;
			background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
		}

		.main-wrapper {
			display: flex;
			min-height: 100vh;
			background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
		}

		.main-content {
			margin-left: 240px;
			margin-top: 70px;
			flex: 1;
			padding: 2.5rem;
		}

		.course-shell {
			max-width: 1100px;
			margin: 0 auto;
		}

		.alert {
			padding: 1rem 1.25rem;
			border-radius: 12px;
			margin-bottom: 1.5rem;
			font-weight: 600;
			box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
			border-left: 4px solid;
		}

		.alert-success { background: #e6fffa; color: #0c6f5c; border-color: #38b2ac; }
		.alert-error { background: #ffe6e6; color: #9b1c1c; border-color: #e53e3e; }

		.back-link {
			display: inline-flex;
			align-items: center;
			gap: 0.5rem;
			color: #667eea;
			text-decoration: none;
			font-weight: 600;
			margin-bottom: 1.5rem;
			padding-bottom: 0.35rem;
			border-bottom: 2px solid transparent;
			transition: all 0.3s ease;
		}

		.back-link:hover { color: #764ba2; border-bottom-color: #764ba2; }

		.card {
			background: #fff;
			border-radius: 16px;
			padding: 2rem;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
			margin-bottom: 2rem;
			border: 1px solid rgba(102, 126, 234, 0.12);
		}

		.header-top { display: flex; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
		.badge { display: inline-block; padding: 0.5rem 1rem; border-radius: 10px; font-weight: 700; font-size: 0.85rem; }
		.badge-code { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; }
		.badge-pub { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: #fff; }

		.course-title { margin: 1.2rem 0 0.8rem; font-size: 2rem; color: #1a202c; }
		.meta { color: #4a5568; font-weight: 600; margin-bottom: 0.5rem; }

		.section-title { font-size: 1.3rem; font-weight: 800; color: #2d3748; margin: 0 0 1rem; display: flex; align-items: center; gap: 0.5rem; }
		.content-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; }
		.content-card { padding: 1.25rem; background: linear-gradient(145deg, #ffffff 0%, #f8f9fd 100%); border-radius: 12px; border: 1px solid rgba(102, 126, 234, 0.12); box-shadow: 0 6px 18px rgba(0,0,0,0.05); }
		.content-type { display: inline-block; padding: 0.35rem 0.75rem; border-radius: 8px; font-size: 0.8rem; font-weight: 800; color: #fff; margin-bottom: 0.5rem; }
		.type-text { background: #667eea; }
		.type-video { background: #f5576c; }
		.type-link { background: #4facfe; }
		.type-file { background: #38b2ac; }
		.content-title { margin: 0 0 0.5rem; color: #2d3748; font-size: 1.05rem; }
		.content-body { color: #4a5568; font-size: 0.95rem; line-height: 1.6; white-space: pre-wrap; }

		.empty { padding: 2rem; text-align: center; background: rgba(102, 126, 234, 0.05); border: 2px dashed rgba(102, 126, 234, 0.2); border-radius: 12px; color: #718096; }

		@media (max-width: 768px) {
			.main-content { margin-left: 0; padding: 1.25rem; }
			.header-top { flex-direction: column; align-items: flex-start; }
		}
	</style>
</head>
<body>
    <div class="main-wrapper">
        <?php include_once __DIR__ . '/../../../../components/sidebar.php'; ?>
        <div style="flex: 1;">
            <?php include_once __DIR__ . '/../../../../components/top-bar.php'; ?>
            <div class="main-content">
                <div class="course-shell">
                    <a class="back-link" href="<?php echo BASE_URL; ?>/project/student/dashboard/courses">
                        ← Back to Courses
                    </a>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-error">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="header-top">
                            <div class="badge badge-code"><?php echo htmlspecialchars($course['course_code']); ?></div>
                            <div class="badge badge-pub">Published</div>
                        </div>
                        <h1 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h1>
                        <div class="meta">Instructor: <?php echo htmlspecialchars($course['teacher_name']); ?></div>
                        <div class="meta">Created: <?php echo date('M j, Y', strtotime($course['created_at'])); ?></div>
                        <?php if (!empty($course['description'])): ?>
                            <p class="content-body" style="margin-top: 1rem;">
                                <?php echo htmlspecialchars($course['description']); ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="card">
                        <div class="section-title">📚 Course Content</div>
                        <?php if (!empty($contents)): ?>
                            <div class="content-grid">
                                <?php foreach ($contents as $content): ?>
                                    <?php
                                        $typeClass = strtolower($content['content_type']);
                                    ?>
                                    <div class="content-card">
                                        <div class="content-type type-<?php echo $typeClass; ?>"><?php echo htmlspecialchars($content['content_type']); ?></div>
                                        <div class="content-title"><?php echo htmlspecialchars($content['title']); ?></div>
                                        <?php if ($content['content_type'] === 'TEXT'): ?>
                                            <div class="content-body"><?php echo nl2br(htmlspecialchars($content['body'])); ?></div>
                                        <?php elseif ($content['content_type'] === 'VIDEO' || $content['content_type'] === 'LINK'): ?>
                                            <a href="<?php echo htmlspecialchars($content['url']); ?>" target="_blank" style="color: #667eea; font-weight: 700; text-decoration: none;">Open link →</a>
                                        <?php elseif ($content['content_type'] === 'FILE'): ?>
                                            <div class="content-body">File available from instructor.</div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty">No content yet. Check back soon.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>