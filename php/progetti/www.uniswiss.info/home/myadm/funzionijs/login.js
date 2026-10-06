$(document).ready(function () {
    jQuery(function ($) {
        $("#loginForm").submit(function () {
            $.post("funzioni/login.php",
                $("#loginForm").serialize(),
                function (data) {
                    if (data.errore != '') {
                        swal({
                            title: 'Attenzione!',
                            text: 'Potrebbe esserci un problema. Il server riporta: ' + data.errore,
                            type: 'warning',
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            }
                        });
                    } else {
                        swal({
                            title: 'Ok!',
                            text: 'Accesso effettuato.',
                            type: 'success',
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            }
                        });
                        setTimeout(function () {
                            if(data.livello=='Admin'){
                                window.location.href = "index.php";
                            }else 
                             if(data.livello=='Studente'){
                                window.location.href = "studente.php";
                            }
                        }, 1000);
                    }
                },
                "json"
            );
        });
    });
});