var agentiDataTableOptions = {};

$(document).ready(function () {

    jQuery(function ($) { 

        agentiDataTableOptions["language"] = {
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

        // agentiDataTableOptions["dom"] = "lftp";
        agentiDataTableOptions["responsive"] = true;
        agentiDataTableOptions["scrollX"] = true;
        // agentiDataTableOptions["buttons"] = [
        //     'csv', 'excel', 'pdf'
        // ];
        agentiDataTableOptions["scrollY"] = false;
        agentiDataTableOptions["colReorder"] = true;

        agentiDataTableOptions["processing"] = true;
        agentiDataTableOptions["serverSide"] = true;
        agentiDataTableOptions["ajax"] = "funzioni/agenti_load.php";
        agentiDataTableOptions["columns"] = [
            {
                "name": "id",
                "visible": false,
                "orderable": false,
                "searchable": false
            },
            {
                "name": "nome",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "email",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "telefono",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "piva",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "provincia",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "doc_identita",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "sClass": "text-center"
            },
            {
                "name": "tessera_sanitaria",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "sClass": "text-center"
            },
            {
                "name": "attivo",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "sClass": "text-center"
            },
            {
                "name": "n_scuole",
                "visible": true,
                "orderable": false,
                "searchable": false,
                "sClass": "text-center"
            },
            {
                "name": "incasso",
                "visible": true,
                "orderable": false,
                "searchable": false,
                "sClass": "text-center"
            },
            {
                "name": "modifica",
                "visible": true,
                "orderable": false,
                "searchable": false
            },
            {
                "name": "elimina",
                "visible": true,
                "orderable": false,
                "searchable": false
            }
           
        ];
        agentiDataTableOptions["order"] = [[1, 'desc']];

        var tableAgenti = $('#agenti_datatable').DataTable(agentiDataTableOptions);
            
//        if(livello=='Agente'){
//              var column = tableAgenti.column(9);
//              column.visible( ! column.visible() );
//              var column2 = tableAgenti.column(10);
//              column2.visible( ! column2.visible() );
//        }    

        function deleteUtente(id) {
            var serializedData = [];
            serializedData.push({ name: 'func', value: 'elimina_record' });
            serializedData.push({ name: 'id', value: id });
            serializedData.push({ name: 'table', value: 'anagrafica_agenti'});
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
                        tableAgenti.ajax.reload();
                        tableAgenti.columns.adjust();
                    }
                },
                "json"
            );
        }

        function deactivateUtente(id,stato_attuale) {
            var serializedData = [];
            serializedData.push({ name: 'func', value: 'attiva_utente' });
            serializedData.push({ name: 'id', value: id });
            serializedData.push({ name: 'table', value: 'anagrafica_agenti'});
            serializedData.push({ name: 'stato_attuale', value: stato_attuale});
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
                            title: 'Ok!',
                            text: 'Stato modificato.',
                            type: 'success',
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            }
                        });
                        tableAgenti.ajax.reload();
                        tableAgenti.columns.adjust();
                    }
                },
                "json"
            );
        }

        tableAgenti.on('click', '.deleten', function (e) {
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

        tableAgenti.on('click', '.deactivaten', function (e) {
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

        // tableAgenti.on('click', '.editn', function (e) {
        //     var id = $(this).attr("for");

        //     $('.modal-body').load('funzioni/utenti_functions.php?id=' + id + '&func=utenteLoad', function () {
        //         $('#editProfessionistaModal').modal('show');
        //     });
        // });


        $(document).on('click', '.ins_edit', function (e) {
            
            var id = $(this).attr("for");
            
            $.ajax({
                url: 'funzioni/agenti.php',
                type: 'post',
                data: {
                    'id': id,
                    'func': 'load_ins_form'
                },
                success: function (response) {
                    // Add response in Modal body
                    $('#ins_agenteModal .modal-body').html('');
                    $('#ins_agenteModal .modal-body').html(response);

                      if(id!='0'){
                      $('#ins_agenteModal .modal-title').html('Modifica agente');
                    } else{
                      $('#ins_agenteModal .modal-title').html('Inserisci agente');  
                    } 
                    // Display Modal
                    $('#ins_agenteModal').modal('show');
                     


                    jQuery(".loadfile").fileinput({
                        uploadUrl: './funzioni/uploadfile.php', // you must set a valid URL here else you will get an error
                        language: "it",
                        dropZoneEnabled: false,
                        maxFileSize: 16000,
                        allowedFileExtensions:    ['jpg','jpeg','gif','png', 'txt','rtf','mp4','mp3','3gp','mov','xls','xlsx','doc','docx','pdf','bmp','jpeg','odt','ods','pptx','ppt','tiff'],
                        showPreview: false
                        }).on('fileuploaded', function(event, data, previewId, index) {
                            jQuery('#ins_agenteModal .modal-body #'+ data.response.nomeinput).val(data.response.nomefile);
                //          // Nasconde il cestino dalla preview del file dopo averlo caricato
                             jQuery('#ins_agenteModal .modal-body #'+ previewId +' > div:nth-child(2) > div:nth-child(3) > div:nth-child(1) > button:nth-child(2)').hide();
                        }).on("filebatchselected", function(event, files) {
                                jQuery(this).fileinput("upload");
                    });


                    $('#ins_agenteModal .modal-body #id_provincia').select2({
                      // theme: "bootstrap",
                       dropdownParent: $('#ins_agenteModal')
                        
                    });


                    $("#ins_agenteModal .modal-body #form_ins_agente").submit(function () {

                        var serializedData = $("#ins_agenteModal .modal-body #form_ins_agente").serialize();
                 
         
                        $.post("funzioni/agenti.php",
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
                                    tableAgenti.ajax.reload();
                                    tableAgenti.columns.adjust();
                                    $('#ins_agenteModal').modal('hide');
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