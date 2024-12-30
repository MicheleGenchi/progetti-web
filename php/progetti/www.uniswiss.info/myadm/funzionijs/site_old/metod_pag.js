var metodopagDataTableOptions = {};

$(document).ready(function () {

    jQuery(function ($) { 

        metodopagDataTableOptions["language"] = {
            "sEmptyTable": "Nessun dato presente nella tabella",
            "sInfo": "Vista da _START_ a _END_ di _TOTAL_ elementi",
            "sInfoEmpty": "Vista da 0 a 0 di 0 elementi",
            "sInfoFiltered": "(filtrati da _MAX_ elementi totali)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "Visualizza _MENU_ elementi",
            "sLoadingRecords": "Caricamento...",
            "sProcessing": "Elaborazione...",
            "sSearch": "Cerca:",
            "sZeroRecords": "La ricerca non ha portato alcun risultato.",
            "oPaginate": {
                "sFirst": "Inizio",
                "sPrevious": "Precedente",
                "sNext": "Successivo",
                "sLast": "Fine"
            },
            "oAria": {
                "sSortAscending": ": attiva per ordinare la colonna in ordine crescente",
                "sSortDescending": ": attiva per ordinare la colonna in ordine decrescente"
            }
        };

        // metodopagDataTableOptions["dom"] = "lftp";
        metodopagDataTableOptions["responsive"] = true;
        // metodopagDataTableOptions["buttons"] = [
        //     'csv', 'excel', 'pdf'
        // ];
        metodopagDataTableOptions["scrollY"] = false;
        metodopagDataTableOptions["colReorder"] = true;

        metodopagDataTableOptions["processing"] = true;
        metodopagDataTableOptions["serverSide"] = true;
        metodopagDataTableOptions["ajax"] = "funzioni/metod_pag_load.php";
        metodopagDataTableOptions["columns"] = [
            {
                "name": "id",
                "visible": false,
                "orderable": false,
                "searchable": false
            },
            {
                "name": "email",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
           
            {
                "name": "attivo",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "sClass": "text-center"
            },

            {
                "name": "elimina",
                "visible": true,
                "orderable": false,
                "searchable": false
            }
           
        ];
        metodopagDataTableOptions["order"] = [[1, 'desc']];

        var tablemetodopag = $('#metodopag_datatable').DataTable(metodopagDataTableOptions);


        function deleteUtente(id) {
            var serializedData = [];
            serializedData.push({ name: 'func', value: 'elimina_record' });
            serializedData.push({ name: 'id', value: id });
            serializedData.push({ name: 'table', value: 'account_paypal'});
            //            console.log(values);
            $.post("funzioni/common.php",
                serializedData,
                function (data) {
                    if (data.errore != '') {
                        // showWarningMessage(false, {'text': 'Potrebbe esserci un problema. Il server riporta: ' + data.messaggio + '. Codice errore: ' + data.errore});
                        // return false;
                        swal({
                            title: 'Attenzione!',
                            text: 'Potrebbe esserci un problema. Il server riporta: ' + data.messaggio + '. Codice errore: ' + data.errore,
                            type: 'warning',
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            }
                        });
                    } else {
                        // return true;
                        swal({
                            title: 'Cancellato!',
                            text: 'Utente eliminato.',
                            type: 'success',
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            }
                        });
                        tablemetodopag.ajax.reload();
                        tablemetodopag.columns.adjust();
                    }
                },
                "json"
            );
        }

        function deactivateUtente(id,stato_attuale) {
            var serializedData = [];
            serializedData.push({ name: 'func', value: 'attiva_metodo' });
            serializedData.push({ name: 'id', value: id });
            serializedData.push({ name: 'table', value: 'account_paypal'});
            serializedData.push({ name: 'stato_attuale', value: stato_attuale});
            //            console.log(values);
            $.post("funzioni/metod_pag.php",
                serializedData,
                function (data) {
                    if (data.errore != '') {
                        // showWarningMessage(false, {'text': 'Potrebbe esserci un problema. Il server riporta: ' + data.messaggio + '. Codice errore: ' + data.errore});
                        // return false;
                        swal({
                            title: 'Attenzione!',
                            text: 'Potrebbe esserci un problema. Il server riporta: ' + data.messaggio + '. Codice errore: ' + data.errore,
                            type: 'warning',
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            }
                        });
                    } else {
                        // return true;
                        swal({
                            title: 'Ok!',
                            text: 'Account attivato.',
                            type: 'success',
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            }
                        });
                        tablemetodopag.ajax.reload();
                        tablemetodopag.columns.adjust();
                    }
                },
                "json"
            );
        }

        tablemetodopag.on('click', '.deleten', function (e) {
            var id = $(this).attr("for");
            swal({
                title: 'Sei sicuro?',
                text: "L'azione è irreversibile!",
                type: 'warning',
                buttons: {
                    confirm: {
                        text: 'Si, cancella!',
                        className: 'btn btn-success'
                    },
                    cancel: {
                        visible: true,
                        className: 'btn btn-danger'
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    deleteUtente(id);
                } else {
                    swal.close();
                }
            });
        });

        tablemetodopag.on('click', '.deactivaten', function (e) {
            var id = $(this).attr("for");
            var stato_attuale = $(this).data("stato");
            //alert(stato_attuale);
            swal({
                title: 'Sei sicuro?',
                // text: "L'azione è irreversibile!",
                type: 'warning',
                buttons: {
                    confirm: {
                        text: 'Si, cambia stato!',
                        className: 'btn btn-success'
                    },
                    cancel: {
                        visible: true,
                        className: 'btn btn-danger'
                    }
                }
            }).then((willDeactivate) => {
                if (willDeactivate) {
                    deactivateUtente(id,stato_attuale);
                } else {
                    swal.close();
                }
            });
        });

        // tablemetodopag.on('click', '.editn', function (e) {
        //     var id = $(this).attr("for");

        //     $('.modal-body').load('funzioni/utenti_functions.php?id=' + id + '&func=utenteLoad', function () {
        //         $('#editProfessionistaModal').modal('show');
        //     });
        // });


        $(document).on('click', '.ins_edit', function (e) {
            
            var id = $(this).attr("for");
            
            $.ajax({
                url: 'funzioni/metod_pag.php',
                type: 'post',
                data: {
                    'id': id,
                    'func': 'load_ins_form'
                },
                success: function (response) {
                    // Add response in Modal body
                    $('#ins_metodopagModal .modal-body').html('');
                    $('#ins_metodopagModal .modal-body').html(response);

                      if(id!='0'){
                      $('#ins_metodopagModal .modal-title').html('Modifica account paypal');
                    } else{
                      $('#ins_metodopagModal .modal-title').html('Inserisci account paypal');  
                    } 
             
                    // Display Modal
                    $('#ins_metodopagModal').modal('show');
                     



                    $("#ins_metodopagModal .modal-body #form_ins_metodopag").submit(function () {

                        var serializedData = $("#ins_metodopagModal .modal-body #form_ins_metodopag").serialize();
                 
         
                        $.post("funzioni/metod_pag.php",
                            serializedData,
                            function (data) {
                                if (data.errore != '') {
                                    // showWarningMessage(false, {'text': 'Potrebbe esserci un problema. Il server riporta: ' + data.messaggio + '. Codice errore: ' + data.errore});
                                    // return false;
                                    swal({
                                        title: 'Attenzione!',
                                        text: 'Si è verificato un problema con odice errore: ' + data.errore,
                                        type: 'warning',
                                        buttons: {
                                            confirm: {
                                                className: 'btn btn-success'
                                            }
                                        }
                                    });
                                } else {
                                    // return true;
                                    swal({
                                        title: 'Ok!',
                                        text: 'Operazione riuscita.',
                                        type: 'success',
                                        buttons: {
                                            confirm: {
                                                className: 'btn btn-success'
                                            }
                                        }
                                    });
                                    tablemetodopag.ajax.reload();
                                    tablemetodopag.columns.adjust();
                                    $('#ins_metodopagModal').modal('hide');
                                }
                            },
                            "json"
                        );
                    });
                }
            });
        });

    });
});