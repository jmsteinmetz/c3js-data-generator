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
    function UniqueRandomNumbersWithinRange($min, $max, $quantity, $key) {
        $numbers = range($min, $max);
        shuffle($numbers);
        $numArrays = array_slice($numbers, 0, $quantity);
        if ($key != '') {
          array_unshift($numArrays, $key);  
      };
        
    return $numArrays;
}

    $items = $_GET["items"];
    $values = $_GET["values"];
    $min = $_GET["min"];
    $max = $_GET["max"];
    $trend = $_GET["trend"];
    $shape = $_GET["shape"];

    $callback = isset($_GET['callback']) ? preg_replace('/[^a-z0-9$_]/si', '', $_GET['callback']) : false;
    header('Content-Type: ' . ($callback ? 'application/javascript' : 'application/json') . ';charset=UTF-8');

    $rows = array(); 

    if(isset($_GET['names'])) {
        $names = $_GET['names'];
        $keys = explode(',', $names);

        for ($k = 0 ; $k < $items; $k++){ 
            if ($shape == 'standard') {
                $key = '';
                $rows[$keys[$k]] = UniqueRandomNumbersWithinRange($min,$max,$values,$key);
            };
            if ($shape == 'stackedbar' || $shape == 'pie') {
                $key = $keys[$k];
                array_push($rows, UniqueRandomNumbersWithinRange($min,$max,$values,$key));
            }  
        }

    } else {
        for ($k = 0 ; $k < $items; $k++){ 
            if ($shape == 'standard') {
                $key = '';
                $rows["data".$k] = UniqueRandomNumbersWithinRange($min,$max,$values,$key);
            };
            if ($shape == 'stackedbar' || $shape == 'pie') {
                $key = "data".$k;
                array_push($rows, UniqueRandomNumbersWithinRange($min,$max,$values,$key));
            }  
        
        }
    }

    

    echo ($callback ? $callback . '(' : '') . json_encode($rows) . ($callback ? ')' : '');

 ?>