<!-- Book details section -->
<section id="book-details" class="card">
    <div class="book-header">
        <h1><?= htmlspecialchars($book['title']) ?></h1>
        <p class="author"><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>
    </div>
    <div class="book-description">
        <h2>Description</h2>
        <p><?= htmlspecialchars($book['description']) ?></p>
    </div>
    <div class="book-actions">
        <a href="index.php?route=bookcontroller/list" class="back-button">Back to List</a>
    </div>
</section>