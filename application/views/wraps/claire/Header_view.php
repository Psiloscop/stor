<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Main page">
    <meta name="author" content="Filipovich S.P.">
    <!--    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">-->

    <title><?= $title ?></title>

    <script src="<?= base_url('libraries/jquery-1.12.4.min.js'); ?>"></script>
    <script src="<?= base_url('libraries/bootstrap-3.3.6/js/bootstrap.min.js'); ?>"></script>
    <link href="<?= base_url('libraries/bootstrap-3.3.6/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <script src="<?= base_url('libraries/jquery-impromptu-6.2.2/jquery-impromptu.min.js'); ?>"></script>
    <link href="<?= base_url('libraries/jquery-impromptu-6.2.2/jquery-impromptu.min.css'); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!--    <link href="--><? //= base_url('assets/css/bootstrap-theme-cerulean.min.css'); ?><!--" rel="stylesheet">-->
    <link href="<?= base_url('assets/css/sticky-footer-navbar.css'); ?>" rel="stylesheet">

    <?php if (isset($js_files)): ?>
        <?php foreach ($js_files as $js_file): ?>
            <script src="<?= $js_file; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (isset($css_files)): ?>
        <?php foreach ($css_files as $css_file): ?>
            <link href="<?= $css_file; ?>" rel="stylesheet">
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>