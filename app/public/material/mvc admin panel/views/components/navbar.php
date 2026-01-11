<?php

// Load the menu configuration
$menu = include __DIR__ . '/../../routes/menu.php';

// Get the current page from the query string
$currentRoute = $_GET['route'] ?? 'dashboard'; // Renamed to $currentRoute

?>
<nav class="menu">
    <?php foreach ($menu as $item): ?>
        <?php
        // Unpack the controller, method, and optional label
        [$controller, $method, $label] = array_pad($item, 3, null);

        // Generate the route path (controller/method)
        $normalizedPath = strtolower((new \ReflectionClass($controller))->getShortName()) . '/' . $method;

        // Determine the menu label (fallback to method if no label is provided)
        $menuLabel = $label ?? ucfirst($method);
        ?>
        <a href="index.php?route=<?= htmlspecialchars($normalizedPath) ?>" class="<?= $currentRoute === $normalizedPath ? 'active' : '' ?>">
            <?= htmlspecialchars($menuLabel) ?>
        </a>
    <?php endforeach; ?>
</nav>
