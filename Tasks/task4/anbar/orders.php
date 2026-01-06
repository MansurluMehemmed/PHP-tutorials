<?php

include "nav.php";

$product = mysqli_query($con, "SELECT p.id,
                                      p.product,
                                      p.amount,
                                      b.brand
                               FROM products p
                               JOIN brands b
                               ON b.id = p.brand_id");

$customer = mysqli_query($con, "SELECT * FROM customers");

print_r($_POST);


if (isset($_POST['gonder'])) {

    if (
        !empty($_POST['product_id']) &&
        !empty($_POST['customer_id']) &&
        !empty($_POST['amount'])
    ) {

        $product_id = $_POST['product_id'];

        $pro = mysqli_query($con, "SELECT amount FROM products WHERE id = $product_id");
        $amount = mysqli_fetch_assoc($pro);

        if ($_POST['amount'] <= $amount['amount']) {

            $x = $amount['amount'] - $_POST['amount'];

            $gonder = mysqli_query(
                $con,
                "INSERT INTO orders (product_id, customer_id, amount)
                 VALUES (
                    '" . $_POST['product_id'] . "',
                    " . $_POST['customer_id'] . ",
                    " . $_POST['amount'] . "
                 )"
            );

            $update = mysqli_query(
                $con,
                "UPDATE products
                 SET amount = '" . $x . "'
                 WHERE id = '" . $_POST['product_id'] . "'"
            );

            echo $gonder ? 'Ugurlu' : ('Ugursuz' . mysqli_error($con));

        } else {
            echo 'Stokdan cox ola bilmez';
        }

    } else {
        echo 'Melumatlar tam deyil';
    }
}



    $product = mysqli_query($con, "SELECT p.id, p.product, p.amount, b.brand
                                   FROM products p
                                   JOIN brands b ON b.id = p.brand_id");

    $customer = mysqli_query($con, "SELECT * FROM customers");

    echo '<form method="post">
        Product:<br>
        <select name="product_id">
            <option>--Mehsulu sec--</option>';

    while ($pro = mysqli_fetch_assoc($product)) {
        echo '<option value="' . $pro['id'] . '">' . $pro['brand'] . ' ' . $pro['product'] . ' (' . $pro['amount'] . ')</option>';
    }

    echo '</select><br>

    Alici:<br>
    <select name="customer_id">
        <option>--Alicini sec--</option>';

    while ($a = mysqli_fetch_assoc($customer)) {
        echo '<option value="' . $a['id'] . '">' . $a['name'] . ' ' . $a['surname'] . '</option>';
    }

    echo '</select><br>

        Miqdar:<br>
        <input type="number" name="amount"><br><br>

        <input type="submit" name="gonder" value="Gonder">
    </form><hr>';




echo '<ul style="list-style: none; padding-inline-start: 10px">';

$row = mysqli_query(
    $con,
    "SELECT
        o.id,
        o.product_id,
        o.customer_id,
        o.amount,
        o.tarix,
        p.product,
        c.name,
        c.surname
     FROM orders o
     JOIN products p ON o.product_id = p.id
     JOIN customers c ON o.customer_id = c.id"
);

while ($q = $row->fetch_assoc()) {

    echo '<li>Mehsul: ' . $q['product'] . '</li>';
    echo '<li>Alici: ' . $q['name'] . ' ' . $q['surname'] . '</li>';
    echo '<li>Miqdar: ' . $q['amount'] . '</li>';
    echo '<li>Elave edilme tarixi: ' . $q['tarix'] . '</li><br>';

    echo '<li>
        <form method="post">
            <input type="hidden" name="id" value="' . $q['id'] . '">
            <input type="submit" name="sil" value="Sil">
            <input type="submit" name="edit" value="Edit">
        </form>
    </li><hr>';
}

echo '</ul>';

?>
