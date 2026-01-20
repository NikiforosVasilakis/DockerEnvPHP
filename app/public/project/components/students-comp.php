<?php
// Usage: make a
$students = [
  ["name" => "Dr. Smith", "lesson" => "Web Development", "email" => "dr.smith@university.edu", "active" => true],
  ["name" => "Prof. Johnson", "lesson" => "Database Systems", "email" => "prof.johnson@university.edu", "active" => true],
  ["name" => "Dr. Williams", "lesson" => "Software Engineering", "email" => "dr.williams@university.edu", "active" => false],
];
// include 'students.php';
?>
<div class="students-panel-box">
    <div class="students-panel-header">  
        <span class="students-panel-title">Students (<?php echo isset($students) ? count($students) : 0; ?>)</span>
    </div>
    <div class="students-panel-cards">
        <?php if (isset($students) && is_array($students)): ?>
            <?php foreach ($students as $student): ?>
                <div class="students-panel-card">
                    <div class="students-panel-card-content">
                        <div class="students-panel-card-title"><?php echo htmlspecialchars($student['name']); ?></div>
                        <div class="students-panel-card-lesson"><?php echo htmlspecialchars($student['lesson']); ?></div>
                        <div class="students-panel-card-meta">
                            <span class="students-panel-card-status <?php echo $student['active'] ? 'active' : 'inactive'; ?>">
                                <?php echo $student['active'] ? 'Active' : 'Inactive'; ?>
                            </span>
                            <div class="students-panel-card-contact" onclick="alert('Email: <?php echo htmlspecialchars($student['email']); ?>')" title="Click to get email">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div>No students found.</div>
        <?php endif; ?>
    </div>
</div>

<style>
.students-panel-box {
    /* Align with course panel */
    background: transparent;
    border-radius: 18px;
    padding: 28px 18px 24px 18px;
    margin: 80px 15px 0 auto;
    max-width: 950px;
    width: 100%;
    display: block;
    float: right;
}
.students-panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}
.students-panel-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin: 0;
    color: #222;
}
.students-panel-arrows {
    display: none;
}
.students-panel-arrows .panel-arrow {
    display: none;
}
.students-panel-cards {
    display: flex;
    flex-direction: column;
    gap: 0;
    width: 100%;
    overflow: visible;
    margin: 0;
    box-sizing: border-box;
}
.students-panel-card {
    background: transparent;
    border-radius: 0;
    width: 100%;
    box-shadow: none;
    display: flex;
    flex-direction: row;
    align-items: flex-end;
    justify-content: space-between;
    padding: 8px 10px;
    transition: background 0.2s;
    position: relative;
    border-bottom: 1px solid #ddd;
    box-sizing: border-box;
}

.students-panel-card-content {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    flex-grow: 1;
}
.students-panel-card-title {
    font-size: 0.95rem;
    font-weight: 700;
    margin-bottom: 2px;
    text-align: left;
    color: #222;
}
.students-panel-card-lesson {
    font-size: 0.8rem;
    color: #555;
    margin-bottom: 6px;
    text-align: left;
    font-style: italic;
}
.students-panel-card-meta {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    width: 100%;
}
.students-panel-card-status {
    font-size: 0.75rem;
    padding: 3px 10px;
    border-radius: 12px;
    font-weight: 600;
}
.students-panel-card-status.active {
    background-color: #d4edda;
    color: #155724;
}
.students-panel-card-status.inactive {
    background-color: #f8d7da;
    color: #721c24;
}
.students-panel-card-contact {
    cursor: pointer;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: #3498db;
    color: white;
    transition: background-color 0.2s, transform 0.2s;
}
.students-panel-card-contact:hover {
    background-color: #2980b9;
    transform: scale(1.1);
}
.students-panel-card-contact svg {
    width: 16px;
    height: 16px;
}
</style>
