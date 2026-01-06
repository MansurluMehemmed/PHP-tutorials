<?php



$data = require_once './data/data.php';
$id = $_GET['id'];
$name = $_POST['product_name'];
$price = $_POST['product_price'];
$index= -1;
foreach($data as $item){
    
    $index++;
    if($item['id']==$id){
        break;
    }
}

$data[$index] = [
    'id'    => (int) $id,
    'name'  => $name,
    'price' => $price
];

file_put_contents(
    './data/data.php',
    "<?php\nreturn " . var_export($data, true) . ";\n"
);
header('Location: index.php');
exit;