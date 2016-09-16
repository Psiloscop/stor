<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Authorization page">
    <meta name="author" content="Filipovich S.P.">
<!--    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">-->

    <title>StoR: Авторизация</title>

    <script src="<?= base_url('libraries/jquery-1.12.4.min.js'); ?>"></script>
    <script src="<?= base_url('libraries/bootstrap-3.3.6/js/bootstrap.min.js'); ?>"></script>
    <link href="<?= base_url('libraries/bootstrap-3.3.6/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- Custom styles and scripts for this template -->
    <link href="<?= base_url('assets/css/auth.css'); ?>" rel="stylesheet">
    <script src="<?= base_url('assets/js/auth.js'); ?>"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="container">
    <h2 class="signin-heading">Система конвертации студентов в читателей САБ ИРБИС64 (StoR)</h2>

    <form id="auth_form" action="<?= site_url('Login'); ?>" method="post" class="form-signin" role="form">
        <div id="auth_error" class="alert alert-danger fade">
            <button type="button" class="close">&times;</button>
            <b>.</b>
        </div>
        <input type="text" name="username" class="form-control" placeholder="Имя пользователя" required autofocus />
        <input type="password" name="password" class="form-control" placeholder="Пароль" required />

        <button class="btn btn-lg btn-primary btn-block" type="submit">Войти в систему</button>
    </form>
</div>
</body>
</html>