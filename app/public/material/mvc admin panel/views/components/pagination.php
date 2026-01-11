<?php
// Ensure required variables are defined
if (!isset($currentPage, $totalPages, $baseRoute)) {
    throw new RuntimeException("Pagination component requires 'currentPage', 'totalPages', and 'baseRoute' variables.");
}

// Skip rendering if there's only one page
if ($totalPages <= 1) {
    return;
}
?>
<div class="pagination">
    <!-- Previous Button -->
    <?php if ($currentPage > 1): ?>
        <a href="<?= htmlspecialchars($baseRoute . '&page=' . ($currentPage - 1)) ?>">Previous</a>
    <?php else: ?>
        <a class="disabled">Previous</a>
    <?php endif; ?>

    <!-- Page Links -->
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="<?= htmlspecialchars($baseRoute . '&page=' . $i) ?>" class="<?= $i === $currentPage ? 'active' : '' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <!-- Next Button -->
    <?php if ($currentPage < $totalPages): ?>
        <a href="<?= htmlspecialchars($baseRoute . '&page=' . ($currentPage + 1)) ?>">Next</a>
    <?php else: ?>
        <a class="disabled">Next</a>
    <?php endif; ?>
</div>
