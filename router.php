<?php
$routes = array();
function route($action,$callback){
    global $routes;
    $action = trim($action, '/');
    $priority = substr_count($action, '/');
    $action = preg_replace('/{[^}]+}/','(.+)',$action);
    array_push($routes,array("path"=>$action,"priority"=>$priority,"action"=>$callback));
}
function dispatch($action){
    global $routes;

    // FIX: Remove query string like ?status=approved
    $action = parse_url($action, PHP_URL_PATH);
    $action = trim($action, '/');

    $callback = null;
    usort($routes, function ($item1, $item2) {
        return $item2['priority'] <=> $item1['priority'];
    });

    foreach ($routes as $route) {
        if (preg_match("%^{$route['path']}$%", $action, $matches) === 1) {
            $callback = $route['action'];
            unset($matches[0]);
            $params = $matches;
            break;
        }
    }

    if (!$callback || !is_callable($callback)) {
        ?><script>window.location.href='/';</script><?php
        exit;
    } else {
        echo call_user_func($callback, ...$params);
    }
}
