<?php partial('common/footer', ['title' => 'Home Test Page']) ?>
<div class="container">
    <h1>Welcome, <?php __($name) ?></h1>

    <ul>
        <?php foreach ($items as $item): ?>
            <li><?php __($item); ?></li>
        <?php endforeach; ?>
    </ul>

    <p>Current Time: <?php __(date('Y-m-d H:i:s')) ?></p>
</div>
<?php partial('common/footer') ?>