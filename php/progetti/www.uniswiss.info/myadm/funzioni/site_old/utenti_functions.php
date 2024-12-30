<?php
require("../inc_config.php");



function includeFile($filepathAndName)
{
    ob_start();
    include($filepathAndName);
    return ob_get_clean();
}

if ($_POST['func'] == "utenteDelete") {
    $errore = "";
    $warning = "no";

    if ($_POST['id']) {
        $db->query("DELETE FROM utente WHERE id='" . $_POST['id'] . "'");
        $db->execute();
    } else {
        $errore = 'ID non valido';
    }

    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();
}
if ($_POST['func'] == "utenteDeactivate") {
    $errore = "";
    $warning = "no";

    if ($_POST['id']) {
        $db->query("UPDATE utente SET attivo = NOT attivo WHERE id='" . $_POST['id'] . "'");
        if (!$db->execute()) {
            $errore = "NON MODIFICATO!";
        }
    } else {
        $errore = 'ID non valido';
    }

    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();
}
if ($_POST['func'] == "professionistaEdit") {
    $errore = "";
    $warning = "no";

    if ($_POST['id']) {
        $db->query("SELECT * FROM utente WHERE id = :id");
        $oldData = $db->single(array(":id" => $_POST['id']));

        $db->query("UPDATE utente
                    SET
                        nome = :nome,
                        cognome = :cognome,
                        email = :email,
                        username = :username,
                        sesso = :sesso,
		                anno_nascita = :anno_nascita,
                        id_nazione = :id_nazione,
                        id_lingua = :id_lingua,
                        indirizzo = :indirizzo,
		                -- foto = :foto,
                        id_comune = :id_comune,
                        telefono = :telefono,
                        fumatore = :fumatore,
                        ama_animali = :ama_animali,
                        ok_bambini = :ok_bambini,
                        vela = :vela,
                        motore = :motore,
                        sport_altro = :sport_altro,
                        descrizione_lunga = :descrizione_lunga,
                        -- immagine_profilo = :immagine_profilo,
                        id_tipo_professionista = :id_tipo_professionista		
                        -- id_lingua_registrazione = :id_lingua_registrazione
                    WHERE id='" . $_POST['id'] . "'");
        if (!$db->execute(array(
            ":nome" => $_POST['nome'],
            ":cognome" => $_POST['cognome'],
            ":email" => $_POST['email'],
            ":username" => $_POST['username'],
            ":sesso" => $_POST['sesso'],
            ":anno_nascita" => $_POST['annoNascita'],
            ":id_nazione" => $_POST['indirizzoNazione'],
            ":id_lingua" => $_POST['lingua'],
            ":indirizzo" => $_POST['indirizzo'],
            // ":foto" => $_POST['immagine_profilo'],
            ":id_comune" => $_POST['indirizzoComune'],
            ":telefono" => $_POST['telefono'],
            ":fumatore" => isset($_POST['fumatore']) ? 1 : 0,
            ":ama_animali" => isset($_POST['amaAnimali']) ? 1 : 0,
            ":ok_bambini" => isset($_POST['okBambini']) ? 1 : 0,
            ":vela" => isset($_POST['vela']) ? 1 : 0,
            ":motore" => isset($_POST['motore']) ? 1 : 0,
            ":sport_altro" => $_POST['sportAltro'],
            ":descrizione_lunga" => $_POST['descrizioneLunga'],
            //":immagine_profilo" => $_POST['immagineProfilo'],
            ":id_tipo_professionista" => $_POST['tipoProfessionista']
            //":id_lingua_registrazione" => $_POST['linguaRegistrazione']
        ))) {
            $errore = "NON MODIFICATO!";
        } else {
            $db->query("DELETE FROM sport_praticato WHERE id_professionista = :id_professionista");

            if (!$db->execute(array(":id_professionista" => $_POST['id']))) {
                $errore = "SPORT NON ELIMINATI!";
            } else {
                $db->query("SELECT *
                        FROM sport");

                $sports = $db->resultset();
                foreach ($sports as $sport) {
                    if (isset($_POST['sport' . $sport['id']])) {
                        $db->query("INSERT INTO sport_praticato
                                    (id_sport, id_professionista)
                                    VALUE ( :id_sport, :id_professionista)");

                        if (!$db->execute(array(":id_professionista" => $_POST['id'], ":id_sport" => $sport['id']))) {
                            $errore = "SPORT NON INSERITO!";
                        }
                    }
                }
            }
        }
    } else {
        $errore = 'ID non valido';
    }

    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();
}
if ($_POST['func'] == "clienteEdit") {
    $errore = "";
    $warning = "no";

    if ($_POST['id']) {
        $db->query("SELECT * FROM utente WHERE id = :id");
        $oldData = $db->single(array(":id" => $_POST['id']));

        $db->query("UPDATE utente
                    SET
                        nome = :nome,
                        cognome = :cognome,
                        email = :email,
                        username = :username,
                        sesso = :sesso,
		                anno_nascita = :anno_nascita,
                        id_nazione = :id_nazione,
                        id_lingua = :id_lingua,
                        indirizzo = :indirizzo,
		                -- foto = :foto,
                        id_comune = :id_comune,
                        telefono = :telefono,
                        -- immagine_profilo = :immagine_profilo
                        -- id_lingua_registrazione = :id_lingua_registrazione
                    WHERE id='" . $_POST['id'] . "'");
        if (!$db->execute(array(
            ":nome" => $_POST['nome'],
            ":cognome" => $_POST['cognome'],
            ":email" => $_POST['email'],
            ":username" => $_POST['username'],
            ":sesso" => $_POST['sesso'],
            ":anno_nascita" => $_POST['annoNascita'],
            ":id_nazione" => $_POST['indirizzoNazione'],
            ":id_lingua" => $_POST['lingua'],
            ":indirizzo" => $_POST['indirizzo'],
            // ":foto" => $_POST['immagine_profilo'],
            ":id_comune" => $_POST['indirizzoComune'],
            ":telefono" => $_POST['telefono'],
            // ":immagine_profilo" => $_POST['immagineProfilo']
            //":id_lingua_registrazione" => $_POST['linguaRegistrazione']
        ))) {
            $errore = "NON MODIFICATO!";
        }
    } else {
        $errore = 'ID non valido';
    }

    $arr = array('errore' => $errore);
    echo json_encode($arr);
    exit();
}
if ($_POST['func'] == "utenteLoad") {
    $errore = "";
    $warning = "no";

    if ($_POST['id']) {
        $db->query("SELECT
                        utente.*,
                        tipo_professionista.nome_" . $lng . " as nome_tipo_professionista,
                        lingua.sigla AS sigla_lingua
                    FROM utente
                    LEFT JOIN tipo_professionista ON utente.id_tipo_professionista = tipo_professionista.id
                    LEFT JOIN lingua ON utente.id_lingua = lingua.id
                    WHERE utente.id='" . $_POST['id'] . "'");
        $utente = $db->single();

        $db->query("SELECT
                        *
                    FROM tipo_professionista");

        $tipiProf = $db->resultset();

        $tipiProfOptions = "";
        foreach ($tipiProf as $tipoProf) {
            if ($tipoProf['id'] === $utente['id_tipo_professionista']) {
                $tipiProfOptions .= '<option value="' . $tipoProf['id'] . '" selected>' . $tipoProf['nome_' . $lng] . '</option>';
            } else {
                $tipiProfOptions .= '<option value="' . $tipoProf['id'] . '">' . $tipoProf['nome_' . $lng] . '</option>';
            }
        }

        $db->query("SELECT
                        *
                    FROM lingua");

        $lingue = $db->resultset();

        $lingueOptions = "";
        foreach ($lingue as $lingua) {
            if ($lingua['id'] === $utente['id_lingua']) {
                $lingueOptions .= '<option value="' . $lingua['id'] . '" selected>' . $lingua['sigla'] . '</option>';
            } else {
                $lingueOptions .= '<option value="' . $lingua['id'] . '">' . $lingua['sigla'] . '</option>';
            }
        }

        // $db->query("SELECT
        //                 skill.*,
        //                 tipo_skill.nome AS nome_tipo
        //             FROM skill
        //             LEFT JOIN tipo_skill ON skill.id_tipo = tipo_skill.id
        //             WHERE skill.id_professionista = :id_professionista");

        $db->query("SELECT *
                    FROM skill
                    WHERE skill.id_professionista = :id_professionista");

        $skills = $db->resultset(array(":id_professionista" => $utente['id']));

        $db->query("SELECT
                        lingua_conosciuta.*,
                        lingua.nome_" . $lng . " AS nome_lingua
                    FROM lingua_conosciuta
                    LEFT JOIN lingua ON lingua_conosciuta.id_lingua = lingua.id
                    WHERE lingua_conosciuta.id_professionista = :id_professionista");

        $lingue_conosciute = $db->resultset(array(":id_professionista" => $utente['id']));

        $db->query("SELECT *
                    FROM sport
                    ORDER BY sport.id");

        $sports = $db->resultset();

        $db->query("SELECT *
                    FROM sport_praticato
                    WHERE id_professionista = :id_professionista");

        $sport_praticati = $db->resultset(array(":id_professionista" => $utente['id']));

        $ids_sport_praticati = array();
        foreach ($sport_praticati as $sport_praticato) {
            array_push($ids_sport_praticati, $sport_praticato['id_sport']);
        }

        //disponibilita
        $db->query("SELECT
                        disponibilita_periodo.*,
                        porto.nome AS nome_porto,
                        porto.localita AS localita_porto
                    FROM disponibilita_periodo
                    LEFT JOIN porto ON disponibilita_periodo.id_porto = porto.id
                    WHERE disponibilita_periodo.id_professionista = :id_professionista
                    ORDER BY disponibilita_periodo.mese_inizio");

        $disponibilitas_periodo = $db->resultset(array(":id_professionista" => $utente['id']));

        //sesso
        if ($utente['sesso'] == "M") {
            $selectedM = " selected";
            $selectedF = "";
        } else {
            $selectedF = " selected";
            $selectedM = "";
        }

        //messaggi
        $db->query("SELECT COUNT(*) as messaggi FROM messaggio WHERE (id_utente = :userId)");
        $messaggiInviatiArr = $db->single(array(":userId" => $utente['id']));
        $messaggiInviati = $messaggiInviatiArr['messaggi'];

        // prenotazioniEseguite
        $totalePrenotazioniEseguite = 0;

        $sql = "SELECT
                COUNT(*) AS `totalePrenotazioniPagate`
                FROM prenotazione
                WHERE prenotazione.`data_conferma_pagamento` IS NOT NULL
                AND prenotazione.`data_conferma_pagamento` <> '0000-00-00'
                AND id_professionista = :userId";

        $db->query($sql);
        $db->bind(":userId", $utente['id']);

        $totalePrenotazioniEseguiteArr = $db->single();
        $totalePrenotazioniEseguite = intval($totalePrenotazioniEseguiteArr["totalePrenotazioniPagate"]);

        //porti disponibili
        $db->query("SELECT id_porto FROM disponibilita_periodo WHERE id_professionista = :userId GROUP BY id_porto");
        $portiDisponibiliArr = $db->resultset(array(":userId" => $utente['id']));
        $totalePortiDisponibili = count($portiDisponibiliArr);

        if ($utente['is_professionista']) {
            // $output = includeFile('professionista_load_content.php');
            $output = include 'professionista_load_content.php';
        } else {
            $output = include 'cliente_load_content.php';
        }
    } else {
        $errore = 'ID non valido';
    }

    // $arr = array('errore' => $errore);
    // echo json_encode($arr);
    echo $output;
    exit();
}
