<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?= $title; ?></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php foreach ($menus as $menu): ?>
                    <?php if (!isset($menu["items"])): ?>
                        <li id="<?= $menu["nav_id"]; ?>" <?= isset($menu["selected"]) && $menu["selected"] ? "class=\"active\"" : ""; ?>>
                            <a href="<?= $menu["ref"]; ?>"><?= $menu["title"]; ?></a>
                        </li>
                    <?php else: ?>
                        <li id="<?= $menu["nav_id"]; ?>" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?= $menu["title"]." "; ?>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <?php foreach ($menu["items"] as $item): ?>
                                    <?php if (!empty($item)): ?>
                                        <li><a href="<?= $item["ref"]; ?>"><?= $item["title"]; ?></a></li>
                                    <?php else: ?>
                                        <li class="divider"></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>