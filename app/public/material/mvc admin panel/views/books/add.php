<!-- Book Add Section -->
<section id="book-add" class="card">
    <h1><?= htmlspecialchars($title) ?></h1>
    <form action="index.php?route=books/add" method="post">
        <!-- Book Title Field -->
        <div class="form-group">
            <label for="title">Book Title <span class="required">*</span>:</label>
            <input type="text" id="title" name="title" placeholder="Enter the book title" required>
        </div>

        <!-- Author Field -->
        <div class="form-group">
            <label for="author">Author <span class="required">*</span>:</label>
            <input type="text" id="author" name="author" placeholder="Enter the author's name" required>
        </div>

        <!-- Description Field -->
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Enter a brief description of the book"></textarea>
        </div>

        <!-- Submit Button -->
        <button type="submit">Add Book</button>
    </form>
</section>
