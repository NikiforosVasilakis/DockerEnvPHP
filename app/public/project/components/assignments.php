<?php
// Usage: make a
$assignments = [
  ["title" => "Assignment 1", "description" => "Create a PHP form", "teacher" => "Dr. Smith", "due_date" => "2026-01-20", "submitted" => true],
  ["title" => "Assignment 2", "description" => "Database queries practice", "teacher" => "Prof. Johnson", "due_date" => "2026-01-25", "submitted" => false],
  ["title" => "Assignment 3", "description" => "Build a web application", "teacher" => "Dr. Williams", "due_date" => "2026-02-01", "submitted" => false],
];
// include 'assignments.php';
?>
<div class="assignments-panel-box">
    <div class="assignments-panel-header">  
        <span class="assignments-panel-title">Assignments (<?php echo isset($assignments) ? count($assignments) : 0; ?>)</span>
    </div>
    <div class="assignments-panel-cards">
        <?php if (isset($assignments) && is_array($assignments)): ?>
            <?php foreach ($assignments as $assignment): ?>
                <div class="assignments-panel-card">
                    <div class="assignments-panel-card-content">
                        <div class="assignments-panel-card-title"><?php echo htmlspecialchars($assignment['title']); ?></div>
                        <div class="assignments-panel-card-description"><?php echo htmlspecialchars($assignment['description']); ?></div>
                        <div class="assignments-panel-card-meta">
                            <span class="assignments-panel-card-due">Due: <?php echo htmlspecialchars($assignment['due_date']); ?></span>
                            <span class="assignments-panel-card-status <?php echo $assignment['submitted'] ? 'submitted' : 'not-submitted'; ?>">
                                <?php echo $assignment['submitted'] ? 'Submitted' : 'Not Submitted'; ?>
                            </span>
                            <div class="assignments-panel-card-teacher">By <?php echo htmlspecialchars($assignment['teacher']); ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div>No assignments found.</div>
        <?php endif; ?>
    </div>
</div>

<style>
.assignments-panel-box {
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
.assignments-panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}
.assignments-panel-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin: 0;
    color: #222;
}
.assignments-panel-arrows {
    display: none;
}
.assignments-panel-arrows .panel-arrow {
    display: none;
}
.assignments-panel-cards {
    display: flex;
    flex-direction: column;
    gap: 0;
    width: 100%;
    overflow: visible;
    margin: 0;
    box-sizing: border-box;
}
.assignments-panel-card {
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

.assignments-panel-card-content {
    width: auto;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    flex-grow: 1;
}
.assignments-panel-card-title {
    font-size: 0.85rem;
    font-weight: 700;
    margin-bottom: 2px;
    text-align: left;
}
.assignments-panel-card-description {
    font-size: 0.75rem;
    color: #555;
    margin-bottom: 4px;
    text-align: left;
}
.assignments-panel-card-meta {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 2px;
    width: 100%;
}
.assignments-panel-card-due {
    color: #888;
    font-size: 0.7rem;
    text-align: left;
}
.assignments-panel-card-teacher {
    color: #c0392b;
    font-size: 0.8rem;
    text-align: right;
    font-weight: 600;
    white-space: nowrap;
    margin-left: auto;
    margin-right: 20px;
}
</style>
