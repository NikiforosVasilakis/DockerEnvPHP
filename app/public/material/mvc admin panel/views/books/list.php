<section id="books-list" class="card">
    <h1><?= htmlspecialchars($title) ?></h1>
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Author</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($books as $index => $book): ?>
            <tr>
                <td><?= htmlspecialchars(($currentPage - 1) * $itemsPerPage + $index + 1) ?></td>
                <td>
                    <!-- Link to Book Details -->
                    <a href="index.php?route=bookcontroller/details&id=<?= htmlspecialchars($book['id']) ?>">
                        <?= htmlspecialchars($book['title']) ?>
                    </a>
                </td>
                <td><?= htmlspecialchars($book['author']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3">Showing <?= count($books) ?> of <?= $totalBooks ?> books</td>
        </tr>
        </tfoot>
    </table>

    <!-- Include Pagination Component -->
    <?php
    $baseRoute = '?route=bookcontroller/list';
    include __DIR__ . '/../components/pagination.php';
    ?>
</section>