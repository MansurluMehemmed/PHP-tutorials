<?php

include "nav.php";

if (isset($_POST['gonder'])) {

    if (!empty($_POST['brand'])) {

        $gonder = mysqli_query(
            $con,
            "INSERT INTO brands (brand)
             VALUE ('" . $_POST['brand'] . "')"
        );

        echo $gonder ? 'Ugurlu' : ('Ugursuz' . mysqli_error($con));

    } else {
        echo 'Melumatlar tam deyil';
    }
}


if (isset($_POST['sil'])) {

    $id = $_POST['id'];

    $stmt = mysqli_prepare($con, "DELETE FROM brands WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    $ok = mysqli_stmt_execute($stmt);

    echo $ok ? "Ugurlu" : ("Ugursuz: " . mysqli_error($con));

    mysqli_stmt_close($stmt);
}


if (isset($_POST['edit'])) {

    $id = $_POST['id'];

    $sec = mysqli_query($con, "SELECT id, brand FROM brands WHERE id = $id");
    $edit = mysqli_fetch_assoc($sec);

    if ($edit) {

        echo '<h3>Brend edit</h3>

        <form method="post">
            <input type="hidden" name="id" value="' . $edit['id'] . '">
            <input type="text" name="brand" value="' . $edit['brand'] . '">
            <input type="submit" name="update" value="Yadda saxla">
        </form>
        <hr>';

    } else {
        echo "Bu ID tapılmadı.<br>";
    }
}


if (isset($_POST['update'])) {

    $id = $_POST['id'];

    if ($id && !empty($_POST['brand'])) {

        $update = mysqli_query(
            $con,
            "UPDATE brands
             SET brand = '" . $_POST['brand'] . "'
             WHERE id = $id"
        );

        echo $update ? "Ugurlu<br>" : ("Ugursuz: " . mysqli_error($con) . "<br>");

    } else {
        echo "Melumatlar tam deyil.<br>";
    }
}


if (!isset($_POST['edit'])) {

    echo '<form method="post">
        Brend:<br>
        <input type="text" name="brand">
        <input type="submit" name="gonder" value="Gonder">
    </form><hr>';
}


echo '<ul style="list-style: none; padding-inline-start: 10px">';

$row = mysqli_query(
    $con,
    "SELECT id, brand, DATE_FORMAT(tarix, '%d /%m /%y') AS tarix
     FROM brands"
);

while ($q = $row->fetch_assoc()) {

    echo '<li>Brend: ' . $q['brand'] . '</li>';
    echo '<li>Elave edilme tarixi: ' . $q['tarix'] . '</li><br>';

    echo '<li>
        <form method="post">
            <input type="hidden" name="id" value="' . $q['id'] . '">
            <input type="submit" name="sil" value="Sil">
            <input type="submit" name="edit" value="Edit">
        </form><br><hr>
    </li>';
}

echo '</ul>';

?>