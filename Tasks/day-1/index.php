<?php


$data = require './data/data.php';

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Document</title>
</head>
<body>
    <h1>Products</h1>
    <form action="/create.php" method="post">
        <input type="text" placeholder='name' name="product_name">
        <input type="text" placeholder='price' name="product_price">
        <button>Create</button>
    </form>
    <table>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th></th>
        </tr>
        <?php foreach($data as $item){  ?>
        <tr >
            <td><?= $item['name'] ?></td>
            <td><?= $item['price'] ?></td>
            <td>
                 <a class='edit' href="./update.php?id=<?= $item['id'] ?>">edit</a>
            </td>
            <td>
                <a class='delete' href="./delete.php?id=<?= $item['id'] ?>">delete</a>
            </td>
        </tr>
    <?php } ?>
    </table>
   
</body>
</html>



