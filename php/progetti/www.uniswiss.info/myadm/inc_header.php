<!DOCTYPE html>
<html lang="it">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Uniswiss - Admin</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="<?= BASE_URL; ?>support/iconbb.png" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="<?= BASE_URL; ?>assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ['<?= BASE_URL; ?>assets/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!-- Core JS Files -->
    <script src="<?= BASE_URL; ?>assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="<?= BASE_URL; ?>assets/js/core/popper.min.js"></script>
    <script src="<?= BASE_URL; ?>assets/js/core/bootstrap.min.js"></script>
    
    <script src="<?= BASE_URL; ?>funzionijs/utility.js" type="text/javascript"></script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?= BASE_URL; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL; ?>assets/css/atlantis.min.css">
    <!-- JQuery DataTable Css -->
    <!-- <link href="<?= BASE_URL; ?>assets/js/plugin/datatables/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet" /> -->

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <!--<link rel="stylesheet" href="<?= BASE_URL; ?>assets/css/demo.css">-->
    <!-- DataTable Plugin Css -->
    <link href="<?= BASE_URL; ?>assets/js/plugin/datatables/extensions/ColReorder-1.4.1/css/colReorder.dataTables.min.css" rel="stylesheet" />
    <link href="<?= BASE_URL; ?>assets/js/plugin/datatables/extensions/Select-1.2.6/select.dataTables.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="<?= BASE_URL; ?>css/custom.css">