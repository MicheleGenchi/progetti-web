<?php

if (file_exists('data.json')) {
    $filename = 'data.json';
    $data = file_get_contents($filename); //data read from json file
    //print_r($data);
    $sponsors = json_decode($data);  //decode a data

    //print_r($sponsors); //array format data printing
    $message = "<h3 class='text-success'>JSON file data esiste</h3>";
    $esiste = true;
} else {
    $message = "<h3 class='text-danger'>Errore JSON file data non trovato</h3>";
    $esiste = false;
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <title>Sponsors</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="css/sponsor.css">
    <!--<link rel="icon" href="data:;base64,iVBORw0KGgo=">-->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body>
    <div class="container">
        <div class="table-container">
            <?php
            if ($esiste) {
                echo $message;
            ?>

                <h3>
                    Ci sono in totale <b><?= count($sponsors) ?></b> 'sponsor'
                </h3>
                <table id="tbstyle">
                    <tbody>
                        <tr>
                            <th>n.</th>
                            <th>Logo</th>
                            <th>Link</th>
                            <th>copia</th>
                        </tr>
                        <?php
                        $i = 1;
                        foreach ($sponsors as $sponsor) { ?>
                            <tr>
                                <td> n.<?= $i ?></td>
                                <td> <img src="<?php echo $sponsor->logo; ?>" alt="<?php echo $sponsor->logo; ?>" /> </td>
                                <td class="link"> <a href="<?= $sponsor->link; ?>"><?= $sponsor->link; ?></a> </td>
                                <td> <button onclick="copyText('<?= $sponsor->link; ?>', this)">COPIA</button>
                            </tr>
                    <?php $i++;
                        }
                    } else {
                        echo $message;
                    }
                    ?>
                    </tbody>
                </table>
        </div>
    </div>
    <script>
        $(document).ready(
            checklink()
        );

        function checklink() {
            $('#tbstyle tr').each(function() {
                /*   this sono le righe e prendo le colonne    */
                row=this;
                col=$(row).find("td.link");
                //console.log("riga= "+$(row));
                $(col).each(function() {
                    text=$(this).text().trim();
                    //console.log("text ="+text);
                    //alert("text="+text+"   lun="+text.length);
                    if (text.length<=0) {
                        $(row).css("background-color", "#E17373");
                        $(col).next().hide();
                    }
                });
            });
        }

        function copyText(testo, e) {
            navigator.clipboard.writeText(testo);
            e.style.backgroundColor = "#859161";
        }
    </script>
</body>

</html>