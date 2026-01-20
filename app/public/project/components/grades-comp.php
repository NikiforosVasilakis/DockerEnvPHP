<?php
// Usage: Pass two arrays of grades data to display
// Example:
$grades = [
   ["module_name" => "Web Development", "grade" => "A", "percentage" => "95"],
   ["module_name" => "Database Systems", "grade" => "B+", "percentage" => "87"],
   ["module_name" => "Computer Networks", "grade" => "A-", "percentage" => "90"],
];
$assignment_grades = [
   ["assignment_name" => "Project 1: Blog System", "grade" => "A", "percentage" => "92"],
   ["assignment_name" => "Quiz: Database Queries", "grade" => "B+", "percentage" => "85"],
   ["assignment_name" => "Assignment: Network Design", "grade" => "A", "percentage" => "94"],
];
// Note: percentage is optional - if not provided, only the grade will be shown
// include 'grades-comp.php';
?>
<div class="grades-panel-box">
    <!-- Module Grades Section -->
    <div class="grades-section">
        <div class="grades-panel-header">
            <span class="grades-panel-title">Module Grades</span>
            <span class="grades-panel-count"><?php echo isset($grades) ? count($grades) : 0; ?> Modules</span>
        </div>
        <div class="grades-panel-list">
            <?php if (isset($grades) && is_array($grades) && count($grades) > 0): ?>
                <?php foreach ($grades as $grade): ?>
                    <div class="grade-item">
                        <div class="grade-module-name">
                            <span><?php echo htmlspecialchars($grade['module_name']); ?></span>
                        </div>
                        <div class="grade-value <?php echo 'grade-' . strtolower(str_replace(['+', '-'], '', $grade['grade'])); ?>">
                            <?php echo htmlspecialchars($grade['grade']); ?>
                            <?php if (isset($grade['percentage'])): ?>
                                <span class="grade-percentage"><?php echo htmlspecialchars($grade['percentage']); ?>%</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-grades">No module grades available yet.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Assignment Grades Section -->
    <div class="grades-section">
        <div class="grades-panel-header">
            <span class="grades-panel-title">Assignment Grades</span>
            <span class="grades-panel-count"><?php echo isset($assignment_grades) ? count($assignment_grades) : 0; ?> Assignments</span>
        </div>
        <div class="grades-panel-list">
            <?php if (isset($assignment_grades) && is_array($assignment_grades) && count($assignment_grades) > 0): ?>
                <?php foreach ($assignment_grades as $grade): ?>
                    <div class="grade-item">
                        <div class="grade-module-name">
                            <span><?php echo htmlspecialchars($grade['assignment_name']); ?></span>
                        </div>
                        <div class="grade-value <?php echo 'grade-' . strtolower(str_replace(['+', '-'], '', $grade['grade'])); ?>">
                            <?php echo htmlspecialchars($grade['grade']); ?>
                            <?php if (isset($grade['percentage'])): ?>
                                <span class="grade-percentage"><?php echo htmlspecialchars($grade['percentage']); ?>%</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-grades">No assignment grades available yet.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.grades-panel-box {
    background: #fff;
    border-radius: 18px;
    padding: 28px 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin: 20px 15px;
    max-width: 950px;
    width: calc(100% - 30px);
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 28px;
}

.grades-section {
    display: flex;
    flex-direction: column;
}

.grades-section:last-child {
    margin-bottom: 0;
}

.grades-panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 2px solid #f0f0f0;   
}

.grades-panel-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1a1a1a;
}

.grades-panel-count {
    font-size: 1rem;
    color: #666;
    font-weight: 500;
}

.grades-panel-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.grade-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background: #f7f7f7;
    border-radius: 12px;
    transition: all 0.2s ease;
    border: 2px solid transparent;
}

.grade-item:hover {
    background: #f0f0f0;
    border-color: #e0e0e0;
    transform: translateX(5px);
}

.grade-module-name {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
}

.grade-module-name span {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
}

.grade-value {
    font-size: 1.5rem;
    font-weight: 700;
    padding: 8px 20px;
    border-radius: 10px;
    min-width: 70px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 8px;
}

.grade-percentage {
    font-size: 1rem;
    font-weight: 600;
    opacity: 0.9;
}

/* Grade color coding */
.grade-a {
    background: #7c3aed;
    color: #fff;
}

.grade-b {
    background: #ec4899;
    color: #fff;
}

.grade-c {
    background: #3b82f6;
    color: #fff;
}

.grade-d {
    background: #f59e0b;
    color: #fff;
}

.grade-f {
    background: #ef4444;
    color: #fff;
}

.no-grades {
    text-align: center;
    padding: 40px 20px;
    color: #999;
    font-size: 1.1rem;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .grades-panel-box {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}

@media (max-width: 768px) {
    .grades-panel-box {
        padding: 20px 16px;
        margin: 15px 0;
        grid-template-columns: 1fr;
    }
    
    .grades-panel-title {
        font-size: 1.5rem;
    }
    
    .grades-panel-count {
        font-size: 0.9rem;
    }
    
    .grade-item {
        padding: 12px 16px;
    }
    
    .grade-module-name span {
        font-size: 1rem;
    }
    
    .grade-value {
        font-size: 1.3rem;
        padding: 6px 16px;
        min-width: 60px;
    }
    
    .grade-percentage {
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .grades-panel-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .grade-module-name span {
        font-size: 0.95rem;
    }
    
    .grade-value {
        font-size: 1.2rem;
    }
}
</style>
