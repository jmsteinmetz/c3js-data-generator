<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    //test URL: http://loc.recycle/data/carts/list.php?days=365&completed=0

    // {
    //     data1: [30, 20, 50, 40, 60, 50],
    //     data2: [200, 130, 90, 240, 130, 220],
    //     data3: [300, 200, 160, 400, 250, 250]
    // }

    // rand(10,100)
    function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}

    $items = $_GET["items"];
    $values = $_GET["values"];
    $min = $_GET["min"];
    $max = $_GET["max"];
    $trend = $_GET["trend"];
    //$names = $_GET["names"];

    $callback = isset($_GET['callback']) ? preg_replace('/[^a-z0-9$_]/si', '', $_GET['callback']) : false;
    header('Content-Type: ' . ($callback ? 'application/javascript' : 'application/json') . ';charset=UTF-8');

    $rows = array(); 

    if(isset($_GET['names'])) {
        $names = $_GET['names'];
        $keys = explode(',', $names);

        for ($k = 0 ; $k < $items; $k++){ 
            $rows[$keys[$k]] = UniqueRandomNumbersWithinRange($min,$max,$values);
        }

    } else {
        for ($k = 0 ; $k < $items; $k++){ 
            $rows["data".$k] = UniqueRandomNumbersWithinRange($min,$max,$values);
        }
    };    

    echo ($callback ? $callback . '(' : '') . json_encode($rows) . ($callback ? ')' : '');

 ?>