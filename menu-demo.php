<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Menu</title>
    <style>
        #menu{
            display:flex;
            width: 100%;
            background: black;
        }
        #menu a {
            box-sizing: border-box;
            width: 100%;
            padding: 10px;
            color: white !important;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav id="menu"><?php
//GET MENU ITEMS
require "menu.php";

//DRAW MENU ITEMS
foreach ($items as $i) {
    echo "<a href='" . $i['item_link'] . "'>";
    echo $i['item_text'];
    echo "</a>";
}
?></nav>
</body>
</html>
