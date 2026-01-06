<?php

$data = require './data/data.php';

$name  = $_POST['product_name'];
$price = $_POST['product_price'];

// yeni id (son id + 1)
$lastId = !empty($data) ? end($data)['id'] : 0;

$data[] = [
    'id'    => $lastId + 1,
    'name'  => $name,
    'price' => $price
];

// fayla array kimi yaz
file_put_contents(
    './data/data.php',
    "<?php\nreturn " . var_export($data, true) . ";\n"
);

header('Location: index.php');
exit;
