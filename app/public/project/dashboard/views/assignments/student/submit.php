<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Assignment - Student Dashboard</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/project/css/styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/project/css/navbar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/project/css/sidebar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/project/css/top-bar.css">
</head>
<body>
    <?php include BASE_PATH . '/../components/sidebar-stud.php'; ?>
    <?php include BASE_PATH . '/../components/top-bar.php'; ?>
    
    <main class="dashboard-main">
        <div class="submit-container">
            <div class="submit-header">
                <a href="<?= BASE_URL ?>/project/student/dashboard/assignments" class="back-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Back to Assignments
                </a>
            </div>

            <div class="submit-content">
                <div class="submit-form-section">
                    <div class="assignment-details">
                        <h2 class="submit-title">Submit Assignment 1</h2>
                        <p class="submit-description">Create a PHP form with validation</p>
                        <div class="assignment-meta">
                            <div class="meta-item">
                                <span class="meta-label">Course:</span>
                                <span class="meta-value">Web Development - Dr. Smith</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Due Date:</span>
                                <span class="meta-value">January 20, 2026</span>
                            </div>
                        </div>
                    </div>

                    <form method="POST" enctype="multipart/form-data" class="submission-form">
                        <div class="form-group">
                            <label for="submission-text" class="form-label">Submission Notes (Optional)</label>
                            <textarea 
                                id="submission-text" 
                                name="submission_text" 
                                class="form-textarea"
                                placeholder="Add any notes about your submission here..."
                                rows="6"
                            ></textarea>
                            <p class="form-hint">You can include explanations, comments, or additional information about your assignment.</p>
                        </div>

                        <div class="form-group">
                            <label for="file-upload" class="form-label">Upload File</label>
                            <div class="file-upload-wrapper">
                                <input 
                                    type="file" 
                                    id="file-upload" 
                                    name="submission_file" 
                                    class="file-input"
                                    required
                                    accept=".pdf,.doc,.docx,.txt,.zip,.rar,.jpg,.png,.jpeg"
                                >
                                <div class="file-upload-area">
                                    <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="17 8 12 3 7 8"></polyline>
                                        <line x1="12" y1="3" x2="12" y2="15"></line>
                                    </svg>
                                    <p class="upload-text">Click to upload or drag and drop</p>
                                    <p class="upload-hint">PDF, DOC, DOCX, TXT, ZIP, JPG, PNG (Max 50MB)</p>
                                </div>
                            </div>
                            <div id="file-name" class="file-name"></div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="cancel-btn" onclick="window.history.back()">
                                Cancel
                            </button>
                            <button type="submit" class="submit-btn-large">
                                Submit Assignment
                            </button>
                        </div>
                    </form>
                </div>

                <div class="submit-info-section">
                    <div class="info-card">
                        <h3 class="info-title">Guidelines</h3>
                        <ul class="info-list">
                            <li>Submit your completed work as a single file</li>
                            <li>Make sure your file is not corrupted before uploading</li>
                            <li>Include your student ID in the filename if required</li>
                            <li>You can resubmit before the due date</li>
                            <li>Late submissions may not be accepted</li>
                        </ul>
                    </div>

                    <div class="info-card">
                        <h3 class="info-title">Accepted Formats</h3>
                        <div class="format-list">
                            <span class="format-badge">PDF</span>
                            <span class="format-badge">DOC/DOCX</span>
                            <span class="format-badge">TXT</span>
                            <span class="format-badge">ZIP</span>
                            <span class="format-badge">JPG/PNG</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        .dashboard-main {
            margin-left: 290px;
            padding: 100px 20px 20px 20px;
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        .submit-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .submit-header {
            margin-bottom: 30px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #5B5FFF;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .back-btn:hover {
            gap: 12px;
        }

        .back-btn svg {
            width: 20px;
            height: 20px;
        }

        .submit-content {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
        }

        .submit-form-section {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .assignment-details {
            margin-bottom: 32px;
            padding-bottom: 32px;
            border-bottom: 2px solid #e5e7eb;
        }

        .submit-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 8px 0;
        }

        .submit-description {
            font-size: 1.1rem;
            color: #666;
            margin: 0 0 20px 0;
        }

        .assignment-meta {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .meta-label {
            font-weight: 600;
            color: #666;
            min-width: 100px;
        }

        .meta-value {
            color: #1a1a1a;
        }

        .form-group {
            margin-bottom: 28px;
        }

        .form-label {
            display: block;
            font-size: 0.95rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 12px;
        }

        .form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.95rem;
            color: #1a1a1a;
            resize: vertical;
            transition: all 0.2s ease;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #5B5FFF;
            box-shadow: 0 0 0 3px rgba(91, 95, 255, 0.1);
        }

        .form-hint {
            font-size: 0.85rem;
            color: #999;
            margin-top: 8px;
        }

        .file-upload-wrapper {
            position: relative;
        }

        .file-input {
            display: none;
        }

        .file-upload-area {
            border: 2px dashed #5B5FFF;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #f8f9ff;
        }

        .file-upload-area:hover {
            border-color: #764ba2;
            background: #f0f2ff;
        }

        .file-input:focus + .file-upload-area {
            border-color: #764ba2;
            background: #f0f2ff;
        }

        .upload-icon {
            width: 48px;
            height: 48px;
            color: #5B5FFF;
            margin-bottom: 12px;
        }

        .upload-text {
            font-size: 1rem;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0 0 8px 0;
        }

        .upload-hint {
            font-size: 0.85rem;
            color: #999;
            margin: 0;
        }

        .file-name {
            margin-top: 12px;
            padding: 12px 16px;
            background: #d4edda;
            color: #155724;
            border-radius: 8px;
            font-weight: 600;
            display: none;
        }

        .file-name.show {
            display: block;
        }

        .form-actions {
            display: flex;
            gap: 16px;
            justify-content: flex-end;
            padding-top: 32px;
            border-top: 1px solid #e5e7eb;
        }

        .cancel-btn {
            padding: 12px 28px;
            background: #f0f0f0;
            color: #1a1a1a;
            border: 1px solid #d0d0d0;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .cancel-btn:hover {
            background: #e0e0e0;
        }

        .submit-btn-large {
            padding: 12px 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .submit-btn-large:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .submit-info-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .info-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .info-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 16px 0;
        }

        .info-list {
            margin: 0;
            padding-left: 20px;
            list-style: none;
        }

        .info-list li {
            margin-bottom: 10px;
            color: #666;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .info-list li:before {
            content: "✓ ";
            color: #5B5FFF;
            font-weight: 600;
            margin-right: 8px;
        }

        .format-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .format-badge {
            padding: 8px 12px;
            background: #f0f2ff;
            color: #5B5FFF;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.85rem;
            text-align: center;
        }

        @media (max-width: 1024px) {
            .dashboard-main {
                margin-left: 200px;
                padding: 90px 15px 15px 15px;
            }

            .submit-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .dashboard-main {
                margin-left: 180px;
                padding: 80px 10px 10px 10px;
            }

            .submit-form-section {
                padding: 20px;
            }

            .submit-title {
                font-size: 1.4rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .cancel-btn,
            .submit-btn-large {
                width: 100%;
            }
        }
    </style>

    <script>
        // Handle file upload preview
        document.getElementById('file-upload').addEventListener('change', function(e) {
            const fileName = document.getElementById('file-name');
            if (this.files.length > 0) {
                const file = this.files[0];
                fileName.textContent = '✓ ' + file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
                fileName.classList.add('show');
            } else {
                fileName.classList.remove('show');
            }
        });

        // Handle drag and drop
        const fileUploadArea = document.querySelector('.file-upload-area');
        fileUploadArea.addEventListener('click', function() {
            document.getElementById('file-upload').click();
        });

        fileUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#764ba2';
            this.style.background = '#f0f2ff';
        });

        fileUploadArea.addEventListener('dragleave', function() {
            this.style.borderColor = '#5B5FFF';
            this.style.background = '#f8f9ff';
        });

        fileUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '#5B5FFF';
            this.style.background = '#f8f9ff';
            
            if (e.dataTransfer.files.length > 0) {
                document.getElementById('file-upload').files = e.dataTransfer.files;
                const event = new Event('change', { bubbles: true });
                document.getElementById('file-upload').dispatchEvent(event);
            }
        });
    </script>
</body>
</html>