<?php view('common/header') ?>
<div class="container">
    <h1>Welcome <?php __($name ?? 'Guest') ?></h1>

    <p>Current Time: <?php __(date('Y-m-d H:i:s')) ?></p>
</div>
<?php view('common/footer') ?>