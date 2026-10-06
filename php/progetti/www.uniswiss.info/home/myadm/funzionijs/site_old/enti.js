var scuoleDataTableOptions = {};

$(document).ready(function () {

    jQuery(function ($) { 

        scuoleDataTableOptions["language"] = {
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

        // scuoleDataTableOptions["dom"] = "lftp";
        scuoleDataTableOptions["responsive"] = true;
        scuoleDataTableOptions["scrollX"] = true;
        // scuoleDataTableOptions["buttons"] = [
        //     'csv', 'excel', 'pdf'
        // ];
        scuoleDataTableOptions["scrollY"] = false;
        scuoleDataTableOptions["colReorder"] = true;

        scuoleDataTableOptions["processing"] = true;
        scuoleDataTableOptions["serverSide"] = true;
        scuoleDataTableOptions["ajax"] = "funzioni/enti_load.php";
        scuoleDataTableOptions["columns"] = [
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
                "name": "provincia",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "citta",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "settore",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "referente",
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
                "name": "email",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
          {
                "name": "contratto",
                "visible": true,
                "orderable": false,
                "searchable": false
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
        scuoleDataTableOptions["order"] = [[1, 'desc']];

        var tableScuole = $('#scuole_datatable').DataTable(scuoleDataTableOptions);


        function deleteUtente(id) {
            var serializedData = [];
            serializedData.push({ name: 'func', value: 'elimina_record' });
            serializedData.push({ name: 'id', value: id });
            serializedData.push({ name: 'table', value: 'anagrafica_enti_convenzionati'});
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
                            title: 'Cancellata!',
                            text: 'Record eliminato.',
                            type: 'success',
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            }
                        });
                        tableScuole.ajax.reload();
                        tableScuole.columns.adjust();
                    }
                },
                "json"
            );
        }

        function deactivateUtente(id,stato_attuale) {
            var serializedData = [];
            serializedData.push({ name: 'func', value: 'attiva_utente' });
            serializedData.push({ name: 'id', value: id });
            serializedData.push({ name: 'table', value: 'anagrafica_enti_convenzionati'});
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
                        tableScuole.ajax.reload();
                        tableScuole.columns.adjust();
                    }
                },
                "json"
            );
        }


        tableScuole.on('click', '.send_contratto', function (e) {
            var id = $(this).attr("for");
            var email = $(this).data("email");
            var serializedData = [];
            serializedData.push({ name: 'func', value: 'send_contratto' });
            serializedData.push({ name: 'id', value: id });
            serializedData.push({ name: 'email', value: email });
            $.post("funzioni/enti.php",
                      serializedData,
                      function (data) {
                          if (data.errore != '') {
                              // showWarningMessage(false, {'text': 'Potrebbe esserci un problema. Il server riporta: ' + data.messaggio + '. Codice errore: ' + data.errore});
                              // return false;
                              swal({
                                  title: 'Attenzione!',
                                  text: 'Si è verificato un problema con codice errore: ' + data.errore,
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
                                  text: 'Email inviata.',
                                  type: 'success',
                                  buttons: {
                                      confirm: {
                                          className: 'btn btn-success'
                                      }
                                  }
                              });
                          }
                      },
                      "json"
                  );
            
        
        });


        tableScuole.on('click', '.deleten', function (e) {
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

   tableScuole.on('click', '.deactivaten', function (e) {
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

         $(document).on('click', '#aumentacosti', function (e) {
             var perc=$('#aumenta').val();
             $('.costi_corso').each(function(){
                 valore_attuale=parseFloat($(this).val());
                 
                 $(this).val( valore_attuale+( ( (valore_attuale/100)*perc)) );
             });
             
         });
        

        $(document).on('click', '.ins_edit', function (e) {
            
            var id = $(this).attr("for");
            
            $.ajax({
                url: 'funzioni/enti.php',
                type: 'post',
                data: {
                    'id': id,
                    'func': 'load_ins_form'
                },
                success: function (response) {
                    // Add response in Modal body
                     $('#ins_scuolaModal .modal-body').html('');
                    $('#ins_scuolaModal .modal-body').html(response);
                    
                    if(id!='0'){
                      $('#ins_scuolaModal .modal-title').html('Modifica ente');
                    } else{
                      $('#ins_scuolaModal .modal-title').html('Inserisci ente');  
                    }
                    // Display Modal
                    $('#ins_scuolaModal').modal('show');
    
                     jQuery(".loadfile").fileinput({
                        uploadUrl: './funzioni/uploadfile.php', // you must set a valid URL here else you will get an error
                        language: "it",
                        dropZoneEnabled: false,
                        maxFileSize: 16000,
                        allowedFileExtensions:    ['jpg','jpeg','gif','png', 'txt','rtf','mp4','mp3','3gp','mov','xls','xlsx','doc','docx','pdf','bmp','jpeg','odt','ods','pptx','ppt','tiff'],
                        showPreview: false
                        }).on('fileuploaded', function(event, data, previewId, index) {
                            jQuery('#ins_scuolaModal .modal-body #'+ data.response.nomeinput).val(data.response.nomefile);
                //          // Nasconde il cestino dalla preview del file dopo averlo caricato
                             jQuery('#ins_scuolaModal .modal-body #'+ previewId +' > div:nth-child(2) > div:nth-child(3) > div:nth-child(1) > button:nth-child(2)').hide();
                        }).on("filebatchselected", function(event, files) {
                                jQuery(this).fileinput("upload");
                    });
                    
                    $('#ins_scuolaModal .modal-body #id_provincia').select2({
                      // theme: "bootstrap",
                       dropdownParent: $('#ins_scuolaModal')
                        
                    });


                    $("#ins_scuolaModal .modal-body #form_ins_ente").submit(function () {

                        var serializedData = $("#ins_scuolaModal .modal-body #form_ins_ente").serialize();
                 
         
                        $.post("funzioni/enti.php",
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
                                    tableScuole.ajax.reload();
                                    tableScuole.columns.adjust();
                                    $('#ins_scuolaModal').modal('hide');
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