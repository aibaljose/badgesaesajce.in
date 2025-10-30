<?php
    date_default_timezone_set('Asia/Kolkata');
    require_once("APIMethods.php");
    define("KEY_AUTH", 'username');
    $methods = new APIMethods();

    function mCall($fn, $params = null) {
        global $methods;
        if (method_exists($methods, $fn)) {
            return $methods->$fn($params);
        } else {
            return "Method not exists!";
        }
    }

    define('__authUser', $methods->authUser());
    define('__isAuth', isset(__authUser[KEY_AUTH]));
    define('__authRole', isset(__authUser[KEY_AUTH]) ? __authUser[KEY_AUTH] : 0);

    function enc($_msg, $_static = false) {
        global $methods;
        return $methods->enc($_msg, $_static);
    }

    function dec($_msg, $_static = false) {
        global $methods;
        return $methods->dec($_msg, $_static);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            $response = mCall($_POST['action'], $_POST);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }
?>