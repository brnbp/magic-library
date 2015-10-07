<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset="utf-8">
    <!--<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">-->
    <!--<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="foundation/css/foundation.min.css">
    <link rel="stylesheet" href="../foundation/css/foundation.min.css">
    <!--<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">-->
    <!--<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">-->
    <script src="js/jquery.js"></script> 
    <script src="../js/jquery.js"></script> 
    <script src="foundation/js/foundation.min.js"></script>
    <script src="../foundation/js/foundation.min.js"></script>
    <script src="foundation/js/foundation/foundation.offcanvas.js"></script>
    <script src="../foundation/js/foundation/foundation.offcanvas.js"></script>
    <script src="js/plus.js"></script>
    <script src="../js/plus.js"></script>
    <script src="js/ajax.js"></script>
    <script src="../js/ajax.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Magic - The Gathering</title>
</head>
<body>

<?php
$template->loads('main/menu', array(
    'menu' => array(
        'Player' => 'user',
        'Grimorio' => 'user/grimorio',
        'Wishlist' => 'user/wishlist'        
    )
));
require_once('../app/bootstrap.php');

?>
