<?php

$id = (int) $_GET['id'];
$data = require "./data/data.php";

$data = array_filter($data, function ($item)  {
    global $id;
    return $item['id'] != $id;
});
// indexləri düzəlt (vacib deyil amma tövsiyə olunur)
$data = array_values($data);

// data.php faylına yaz
$content = "<?php\nreturn " . var_export($data, true) . ";\n";

file_put_contents("./data/data.php", $content);
header('Location: index.php');

