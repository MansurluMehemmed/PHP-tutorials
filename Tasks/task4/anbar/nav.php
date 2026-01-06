<?php

$con = mysqli_connect("localhost", "admin", "12345", "anbar");

echo '<h2 style="text-align:center; font-size:30px; font-family: arial">Anbar</h2>';

echo '<ul style="display:flex; list-style:none;padding-inline-start: 10px;">
            <li style="padding-right: 10px"><a href="brands.php">Brendler</a></li>
            <li style="padding: 0 10px"><a href="products.php">Mehsullar</a></li>
            <li style="padding: 0 10px"><a href="customers.php">Alici</a></li>
            <li style="padding: 0 10px"><a href="orders.php">Sifarishler</a></li>
            <br>
      </ul>';
?>