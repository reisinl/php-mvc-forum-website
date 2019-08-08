<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $title ?></title>

    <link rel="stylesheet" type="text/css" href="/static/css/jquery-confirm.css">
    <link rel="stylesheet" type="text/css" href="/static/css/bundled.css">
    <link type="text/css" rel="styleSheet" href="/static/css/main.css">
    <link rel="stylesheet" type="text/css" href="/static/css/forum.css">
    <link rel="stylesheet" type="text/css" href="/static/css/jquery.atwho.css">
    <script src="/static/js/jquery-3.4.1.min.js"></script>
    <script src="/static/js/jquery-confirm.js"></script>
    <script src="/static/js/forum.js"></script>
    <script type="text/javascript" src="/static/js/jquery.caret.js"></script>
    <script type="text/javascript" src="/static/js/jquery.atwho.js"></script>
</head>
<?php
    $language = "eng";
    if(isset($_SESSION["language"])) {
        if (strcmp($_SESSION["language"], '') != 0 ) {
            $language = $_SESSION["language"];
        }
    }
    if(isset($_SESSION['ini_array'])) {
        $ini_array = $_SESSION['ini_array'];
    }
