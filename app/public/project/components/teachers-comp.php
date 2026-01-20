<?php
// Usage: make a
$teachers = [
  ["name" => "Dr. Smith", "lesson" => "Web Development", "email" => "dr.smith@university.edu", "active" => true],
  ["name" => "Prof. Johnson", "lesson" => "Database Systems", "email" => "prof.johnson@university.edu", "active" => true],
  ["name" => "Dr. Williams", "lesson" => "Software Engineering", "email" => "dr.williams@university.edu", "active" => false],
];
// include 'teachers.php';
?>
<div class="teachers-panel-box">
    <div class="teachers-panel-header">  
        <span class="teachers-panel-title">Teachers (<?php echo isset($teachers) ? count($teachers) : 0; ?>)</span>
    </div>
    <div class="teachers-panel-cards">
        <?php if (isset($teachers) && is_array($teachers)): ?>
            <?php foreach ($teachers as $teacher): ?>
                <div class="teachers-panel-card">
                    <div class="teachers-panel-card-content">
                        <div class="teachers-panel-card-title"><?php echo htmlspecialchars($teacher['name']); ?></div>
                        <div class="teachers-panel-card-lesson"><?php echo htmlspecialchars($teacher['lesson']); ?></div>
                        <div class="teachers-panel-card-meta">
                            <span class="teachers-panel-card-status <?php echo $teacher['active'] ? 'active' : 'inactive'; ?>">
                                <?php echo $teacher['active'] ? 'Active' : 'Inactive'; ?>
                            </span>
                            <div class="teachers-panel-card-contact" onclick="alert('Email: <?php echo htmlspecialchars($teacher['email']); ?>')" title="Click to get email">
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
            <div>No teachers found.</div>
        <?php endif; ?>
    </div>
</div>

<style>
.teachers-panel-box {
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
.teachers-panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}
.teachers-panel-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin: 0;
    color: #222;
}
.teachers-panel-arrows {
    display: none;
}
.teachers-panel-arrows .panel-arrow {
    display: none;
}
.teachers-panel-cards {
    display: flex;
    flex-direction: column;
    gap: 0;
    width: 100%;
    overflow: visible;
    margin: 0;
    box-sizing: border-box;
}
.teachers-panel-card {
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

.teachers-panel-card-content {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    flex-grow: 1;
}
.teachers-panel-card-title {
    font-size: 0.95rem;
    font-weight: 700;
    margin-bottom: 2px;
    text-align: left;
    color: #222;
}
.teachers-panel-card-lesson {
    font-size: 0.8rem;
    color: #555;
    margin-bottom: 6px;
    text-align: left;
    font-style: italic;
}
.teachers-panel-card-meta {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    width: 100%;
}
.teachers-panel-card-status {
    font-size: 0.75rem;
    padding: 3px 10px;
    border-radius: 12px;
    font-weight: 600;
}
.teachers-panel-card-status.active {
    background-color: #d4edda;
    color: #155724;
}
.teachers-panel-card-status.inactive {
    background-color: #f8d7da;
    color: #721c24;
}
.teachers-panel-card-contact {
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
.teachers-panel-card-contact:hover {
    background-color: #2980b9;
    transform: scale(1.1);
}
.teachers-panel-card-contact svg {
    width: 16px;
    height: 16px;
}
</style>
