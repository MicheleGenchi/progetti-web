<?php

if (file_exists('data.json')) {
    $filename = 'data.json';
    $data = file_get_contents($filename); //data read from json file
    //print_r($data);
    $domains = json_decode($data);  //decode a data

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
    <title>Elenco domini siteground</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
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
                    Ci sono in totale <b><?= count($domains) ?></b> 'domini'
                </h3>
                <table id="tbstyle">
                    <thead>
                        <tr>
                            <th>n.</th>
                            <th>id</th>
                            <th>domain</th>
                            <th>status</th>
                            <th>data</th>
                            <th>cancella</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($domains as $domain) { ?>
                            <tr>
                                <td> n.<?= $i ?></td>
                                <td> id<?= $domain->id ?></td>
                                <td class="link"> <a id="dominio" href="https://www.<?= $domain->domain ?>"><?= $domain->domain ?></a> </td>
                                <td class="status"> <?= $domain->status ?> </td>
                                <?php
                                    if ($domain->status === "SCADUTO") {
                                        echo '<style>.status{color:red};</style>';
                                    } else if ($domain->status === "IN_SCADENZA") {
                                        echo '<style>.status{color:orange};</style>';
                                    } else {
                                        echo '<style>.status{color:green};</style>';
                                    }
                                ?>

                                <td> <?= $domain->expires ?> </td>
                                <td><input class="cancella" type="checkbox" name="cancella" value="ok"> Cancella</td>
                            </tr>
                    <?php $i++;
                        }
                    } else {
                        echo $message;
                    }
                    ?>
                    </tbody>
                </table>
                <button onclick="CreaElencoDaCancellare()">CreaElenco</button>
        </div>
    </div>
    <script>
        function WriteToFile(sito) {
            const nomeFile = "siti_da_rimuovere.txt";
            var file = new Blob(['\ufeff' + sito], {
                type: 'text/plain;charset=utf-8'
            });
            if (window.navigator.msSaveOrOpenBlob) // IE10+
                window.navigator.msSaveOrOpenBlob(file, filename);
            else {
                var a = document.createElement('a'),
                    url = URL.createObjectURL(file);
                a.href = url;
                a.download = nomeFile;
                document.body.appendChild(a);
                a.click();
                setTimeout(function() {
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                }, 0);
            }
        }

        function CreaElencoDaCancellare() {
            var table = document.getElementById("tbstyle");
            if (!table) return;

            daCancellare = [];
            for (var r = 0, n = table.rows.length; r < n; r++) {
                var check = table.rows[r].cells[5].firstChild;
                if (check.checked) {
                    daCancellare[r] = table.rows[r].cells[2].innerText;
                }
            }
            console.log(daCancellare);
            WriteToFile(daCancellare);
        }
    </script>
</body>

</html>