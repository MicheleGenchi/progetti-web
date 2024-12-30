<?php
    $image=$_GET["image"];
    $width=$_GET["width"];
    $height=$_GET["height"];
    $percent=$_GET["percent"];
?>
<html>
    <head>
        <title>
            processo di ridimensione
        </title>
        <link rel="stylesheet" type="text/css" href="styles.css" />
        <link href="favicon.png" rel="icon" />
    </head>
    <body>
        <h1 class="title">Process your image</h1>
        <p>image=<?=$image?></p>    
        <p>width=<?=$width?></p>    
        <p>height=<?=$height?></p>    
        <p>percent=<?=$percent?>%</p>
        <image src='<?=$image?>' />
        <image src='<?=$image?>' width="<?=$width?>" height="<?=$height?>" />
        <image src='<?=$image?>' resize="<?=$percent?>" />
    </body>
</html>

