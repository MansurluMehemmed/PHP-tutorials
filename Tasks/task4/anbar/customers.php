<?php

include "nav.php";


if (isset($_POST['gonder'])) {

    if (
        !empty($_POST['name']) &&
        !empty($_POST['surname']) &&
        !empty($_POST['telephone']) &&
        !empty($_POST['email']) &&
        !empty($_POST['company'])
    ) {

        $gonder = mysqli_query(
            $con,
            "INSERT INTO customers (name, surname, telephone, email, company)
             VALUE (
                '" . $_POST['name'] . "',
                '" . $_POST['surname'] . "',
                '" . $_POST['telephone'] . "',
                '" . $_POST['email'] . "',
                '" . $_POST['company'] . "'
             )"
        );

        echo $gonder ? 'Ugurlu' : ('Ugursuz' . mysqli_error($con));

    } else {
        echo 'Melumatlar tam deyil';
    }
}



if (isset($_POST['sil'])) {

    $id = $_POST['id'];

    $stmt = mysqli_prepare($con, "DELETE FROM customers WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    $ok = mysqli_stmt_execute($stmt);

    echo $ok ? "Ugurlu" : ("Ugursuz: " . mysqli_error($con));

    mysqli_stmt_close($stmt);
}



if (isset($_POST['edit'])) {

    $id = $_POST['id'];

    $sec = mysqli_query($con, "SELECT * FROM customers WHERE id = $id");
    $edit = mysqli_fetch_assoc($sec);

    if ($edit) {

        echo '
        <h3>Musteri edit</h3>

        <form method="post">
            <input type="hidden" name="id" value="' . $edit['id'] . '">

            Ad:<br>
            <input type="text" name="name" value="' . $edit['name'] . '"><br>

            Soyad:<br>
            <input type="text" name="surname" value="' . $edit['surname'] . '"><br>

            Telefon:<br>
            <input type="text" name="telephone" value="' . $edit['telephone'] . '"><br>

            Email:<br>
            <input type="text" name="email" value="' . $edit['email'] . '"><br>

            Sirket:<br>
            <input type="text" name="company" value="' . $edit['company'] . '"><br><br>

            <input type="submit" name="update" value="Yadda saxla">
        </form>
        <hr>';

    } else {
        echo "Bu ID tapılmadı.<br>";
    }
}



if (isset($_POST['update'])) {

    $id = $_POST['id'];

    if (
        $id &&
        !empty($_POST['name']) &&
        !empty($_POST['surname']) &&
        !empty($_POST['telephone']) &&
        !empty($_POST['email']) &&
        !empty($_POST['company'])
    ) {

        $update = mysqli_query(
            $con,
            "UPDATE customers
             SET
                name = '" . $_POST['name'] . "',
                surname = '" . $_POST['surname'] . "',
                telephone = '" . $_POST['telephone'] . "',
                email = '" . $_POST['email'] . "',
                company = '" . $_POST['company'] . "'
             WHERE id = $id"
        );

        echo $update ? "Ugurlu<br>" : ("Ugursuz: " . mysqli_error($con) . "<br>");

    } else {
        echo "Melumatlar tam deyil.<br>";
    }
}


if (!isset($_POST['edit'])) {

    echo '
    <form method="post">
        Ad:<br>
        <input type="text" name="name"><br>

        Soyad:<br>
        <input type="text" name="surname"><br>

        Telefon:<br>
        <input type="text" name="telephone"><br>

        Email:<br>
        <input type="text" name="email"><br>

        Sirket:<br>
        <input type="text" name="company"><br>

        <input type="submit" name="gonder" value="Gonder">
    </form>
    <hr>';
}



echo '<ul style="list-style: none; padding-inline-start: 10px">';

$row = mysqli_query($con, "SELECT * FROM customers");

while ($q = $row->fetch_assoc()) {

    echo '<li>Ad: ' . $q['name'] . '</li>';
    echo '<li>Soyad: ' . $q['surname'] . '</li>';
    echo '<li>Telefon: ' . $q['telephone'] . '</li>';
    echo '<li>Email: ' . $q['email'] . '</li>';
    echo '<li>Sirket: ' . $q['company'] . '</li>';

    echo '
    <li>
        <form method="post">
            <input type="hidden" name="id" value="' . $q['id'] . '">
            <input type="submit" name="sil" value="Sil">
            <input type="submit" name="edit" value="Edit">
        </form>
        <br><hr>
    </li>';
}

echo '</ul>';

?>
