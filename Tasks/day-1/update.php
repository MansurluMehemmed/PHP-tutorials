<?php
$id = $_GET['id'];



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="/updater.php?id=<?=$id?>" method='post'>
        <input type="text" placeholder='name' name="product_name">
        <input type="text" placeholder='price' name="product_price">
        <button>Update</button>
    </form>
</body>
</html>