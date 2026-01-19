<?php
// Usage: make one array with course data and loop through it to generate cards 
$courses = [
  ["title" => "Course 1", "subtitle" => "Course 1 Subtitle", "progress" => 0],
  ["title" => "Course 2", "subtitle" => "Course 2 Subtitle", "progress" => 0],
  ["title" => "Course 3", "subtitle" => "Course 3 Subtitle", "progress" => 0],
  ["title" => "Course 3", "subtitle" => "Course 3 Subtitle", "progress" => 0],
  ["title" => "Course 3", "subtitle" => "Course 3 Subtitle", "progress" => 0],
];
// include 'course_panel.php';
?>
<div class="course-panel-box">
    <div class="course-panel-header">
        <span class="course-panel-title">In progress courses (<?php echo isset($courses) ? count($courses) : 0; ?>)</span>
        <div class="course-panel-arrows">
            <button class="panel-arrow"><b>&lt;</b></button>
            <button class="panel-arrow"><b>&gt;</b></button>
        </div>
    </div>
    <div class="course-panel-cards">
        <?php if (isset($courses) && is_array($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="course-panel-card">
                    <div class="course-panel-card-img"></div>
                    <div class="course-panel-card-content">
                        <div class="course-panel-card-title"><?php echo htmlspecialchars($course['title']); ?></div>
                        <div class="course-panel-card-subtitle"><?php echo htmlspecialchars($course['subtitle']); ?></div>
                        <div class="course-panel-card-progress"><?php echo htmlspecialchars($course['progress']); ?>% completed</div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div>No courses found.</div>
        <?php endif; ?>
    </div>
</div>

<style>
.course-panel-box {
    background: #fff;
    border-radius: 18px;
    padding: 28px 18px 24px 18px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin: 80px 15px 0 auto; /* Top and right margin, align right */
    max-width: 950px;
    width: 100%;
    display: block;
    float: right;
}
.course-panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}
.course-panel-title {
    font-size: 2rem;
    font-weight: 700;
}
.course-panel-arrows {
    display: flex;
    gap: 8px;
}
.panel-arrow {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    width: 38px;
    height: 38px;
    font-size: 1.3rem;
    cursor: pointer;
    transition: background 0.2s;
}
.panel-arrow:hover {
    background: #f2f2f2;
}
.course-panel-cards {
    display: flex;
    gap: 28px;
    width: 100%;
    overflow: hidden;
    transition: transform 0.3s ease-in-out;
}
.course-panel-card {
    background: #f7f7f7;
    border-radius: 14px;
    width: 280px;
    min-height: 260px;
    min-width: 280px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 0 18px 0;
    transition: box-shadow 0.2s;
    position: relative;
    flex-shrink: 0;
}
.course-panel-card-img {
    width: 100%;
    height: 130px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-top-left-radius: 14px;
    border-top-right-radius: 14px;
    overflow: hidden;
    background: #e6e6e6;
}
.course-panel-card-img img {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
}
.course-panel-card-content {
    width: 100%;
    padding: 20px 16px 0 16px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-left: 15px;
}
.course-panel-card-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 6px;
    text-align: left;
}
.course-panel-card-subtitle {
    color: #c0392b;
    font-size: 1rem;
    margin-bottom: 12px;
    text-align: left;
}
.course-panel-card-progress {
    color: #888;
    font-size: 0.97rem;
    text-align: left;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const arrows = document.querySelectorAll('.panel-arrow');
    const cardsContainer = document.querySelector('.course-panel-cards');
    
    if (arrows.length >= 2 && cardsContainer) {
        const leftArrow = arrows[0];
        const rightArrow = arrows[1];
        
        leftArrow.addEventListener('click', function() {
            cardsContainer.scrollBy({
                left: -300,
                behavior: 'smooth'
            });
        });
        
        rightArrow.addEventListener('click', function() {
            cardsContainer.scrollBy({
                left: 300,
                behavior: 'smooth'
            });
        });
    }
});
</script>