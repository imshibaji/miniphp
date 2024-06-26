<?php view('common/head') ?>
<?php 
$menus = [
  ['label' => 'Home', 'url' => '/'],
  ['label' => 'About', 'url' => '/about'],
  ['label' => 'Services', 'url' => '/services', 'children' => [
    ['label' => 'Service 1', 'url' => '#'],
    ['label' => 'Service 2', 'url' => '#'],
    ['label' => 'Service 3', 'url' => '#'],
  ]],
  ['label' => 'Contact', 'url' => '/contact'],
];
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="/"><?php __($siteTitle ?? APP['name'] ?? 'Header Part') ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if(isset($menus)): ?>
        <?php foreach ($menus as $menu): ?>
            <?php if (isset($menu['children'])): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php __($menu['label']) ?>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($menu['children'] as $child): ?>
                            <li><a class="dropdown-item" href="<?php __($child['url']) ?>"><?php __($child['label']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link <?php active($menu['url']) ?>" href="<?php __($menu['url']) ?>"><?php __($menu['label']) ?></a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php endif; ?>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>