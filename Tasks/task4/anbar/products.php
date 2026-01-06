<?php

include "nav.php";

$brand = mysqli_query($con, "SELECT id, brand FROM brands");

print_r($_POST);

if (isset($_POST['gonder'])) {

    if (
        !empty($_POST['product']) &&
        !empty($_POST['buy']) &&
        !empty($_POST['sell']) &&
        !empty($_POST['amount']) &&
        !empty($_POST['brand_id'])
    ) {

        $gonder = mysqli_query(
            $con,
            "INSERT INTO products (product, buy, sell, amount, brand_id)
             VALUES (
                '" . $_POST['product'] . "',
                " . $_POST['buy'] . ",
                " . $_POST['sell'] . ",
                " . $_POST['amount'] . ",
                " . $_POST['brand_id'] . "
             )"
        );

        echo $gonder ? 'Ugurlu' : ('Ugursuz' . mysqli_error($con));

    } else {
        echo 'Melumatlar tam deyil';
    }
}


if (isset($_POST['sil'])) {

    $id = $_POST['id'];

    $stmt = mysqli_prepare($con, "DELETE FROM products WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    $ok = mysqli_stmt_execute($stmt);

    echo $ok ? "Ugurlu" : ("Ugursuz: " . mysqli_error($con));

    mysqli_stmt_close($stmt);
}

if(isset($_POST['edit'])) {
    $id = $_POST['id'];
    $products = mysqli_query($con, "SELECT * FROM products WHERE id = $id");
    $edit = mysqli_fetch_assoc($products);

    $brand = mysqli_query($con, "SELECT id, brand FROM brands");

    echo '<form method="post">
        Brend:<br>
        <select name="brand_id">
            <option>--Brend sec--</option>';

    while ($b = mysqli_fetch_assoc($brand)) {
        $selected = ($b['id'] == $edit['brand_id']) ? 'selected' : '';
        echo '<option value="'. $b['id'].'" '.$selected.'>' . $b['brand'] . '</option>';
    }

    echo '</select><br>
        Mehsul:<br>
        <input type="text" value="'.$edit['product'].'" name="product"><br>
        Alish:<br>
        <input type="number" value="'.$edit['buy'].'" name="buy"><br>
        Satish:<br>
        <input type="number" value="'.$edit['sell'].'" name="sell"><br>
        Miqdar:<br>
        <input type="number" value="'.$edit['amount'].'" name="amount"><br><br>

        <input type="submit" name="update" value="Yenile">
        <input type="hidden" name="id" value="' . $edit['id'] . '">
    </form><hr>';
}
else {

    $brand = mysqli_query($con, "SELECT id, brand FROM brands");

    echo '<form method="post">
        Brend:<br>
        <select name="brand_id">
            <option>--Brend sec--</option>';

    while ($b = mysqli_fetch_assoc($brand)) {
        echo '<option value="' . $b['id'] . '">' . $b['brand'] . '</option>';
    }

    echo '</select><br>
        Mehsul:<br>
        <input type="text" name="product"><br>
        Alish:<br>
        <input type="number" name="buy"><br>
        Satish:<br>
        <input type="number" name="sell"><br>
        Miqdar:<br>
        <input type="number" name="amount"><br><br>

        <input type="submit" name="gonder" value="Gonder">
    </form><hr>';
}

if (isset($_POST['update'])) {

    $id = $_POST['id'];

    if (
        $id &&
        !empty($_POST['product']) &&
        !empty($_POST['buy']) &&
        !empty($_POST['sell']) &&
        !empty($_POST['amount']) &&
        !empty($_POST['brand_id'])
    ) {

        $update = mysqli_query(
            $con,
            "UPDATE products
             SET
                product = '" . $_POST['product'] . "',
                buy = " . $_POST['buy'] . ",
                sell = " . $_POST['sell'] . ",
                amount = " . $_POST['amount'] . ",
                brand_id = " . $_POST['brand_id'] . "
             WHERE id = $id"
        );

        echo $update ? 'Ugurlu' : ('Ugursuz' . mysqli_error($con));

    } else {
        echo 'Melumatlar tam deyil';
    }
}







echo '<ul style="list-style: none; padding-inline-start: 10px">';

$row = mysqli_query(
    $con,
    "SELECT
        p.id,
        p.product,
        p.buy,
        p.sell,
        p.amount,
        b.brand,
        DATE_FORMAT(p.tarix, '%d /%m /%y') AS tarix
     FROM products p
     JOIN brands b ON p.brand_id = b.id"
);

while ($q = $row->fetch_assoc()) {

    echo '<li>Brend: ' . $q['brand'] . '</li>';
    echo '<li>Mehsul: ' . $q['product'] . '</li>';
    echo '<li>Alish: ' . $q['buy'] . '</li>';
    echo '<li>Satish: ' . $q['sell'] . '</li>';
    echo '<li>Migdar: ' . $q['amount'] . '</li>';
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
