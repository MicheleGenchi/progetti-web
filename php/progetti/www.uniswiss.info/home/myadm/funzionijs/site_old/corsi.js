var corsiDataTableOptions = {};

$(document).ready(function () {

    jQuery(function ($) { 

        corsiDataTableOptions["language"] = {
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

        // corsiDataTableOptions["dom"] = "lftp";
        corsiDataTableOptions["responsive"] = true;
        corsiDataTableOptions["scrollX"] = true;
        // corsiDataTableOptions["buttons"] = [
        //     'csv', 'excel', 'pdf'
        // ];
        corsiDataTableOptions["scrollY"] = false;
        corsiDataTableOptions["colReorder"] = true;

        corsiDataTableOptions["processing"] = true;
        corsiDataTableOptions["serverSide"] = true;
        corsiDataTableOptions["ajax"] = "funzioni/corsi_load.php";
        corsiDataTableOptions["columns"] = [
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
                "name": "durata",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "descrizione",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "costo",
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
                "name": "attestato",
                "visible": true,
                "orderable": false,
                "searchable": false,
                "sClass": "text-center"
            },
            {
                "name": "manifesto",
                "visible": true,
                "orderable": false,
                "searchable": false,
                "sClass": "text-center"
            },
            {
                "name": "contratto",
                "visible": true,
                "orderable": false,
                "searchable": false,
                "sClass": "text-center"
            },
            {
                "name": "modulo_assicurazione",
                "visible": true,
                "orderable": false,
                "searchable": false,
                "sClass": "text-center"
            },
            {
                "name": "materiale",
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
        corsiDataTableOptions["order"] = [[1, 'desc']];

        var tableScuole = $('#corsi_datatable').DataTable(corsiDataTableOptions);


        function deleteUtente(id) {
            var serializedData = [];
            serializedData.push({ name: 'func', value: 'elimina_record' });
            serializedData.push({ name: 'id', value: id });
            serializedData.push({ name: 'table', value: 'anagrafica_corsi'});
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
                            text: 'Corso eliminato.',
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
            serializedData.push({ name: 'table', value: 'anagrafica_corsi'});
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
            $.post("funzioni/corsi.php",
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

 $(document).on('click', '.load_materiale', function (e) {
            
            var id = $(this).attr("for");
            
            $.ajax({
                url: 'funzioni/corsi.php',
                type: 'post',
                data: {
                    'id': id,
                    'func': 'load_materiale'
                },
                success: function (response) {
                    // Add response in Modal body
                    $('#materialeModal .modal-body').html(response);

                      $('#materialeModal .modal-title').html('Carica file del corso');
                  
                    // Display Modal
                    $('#materialeModal').modal('show');
                    $('#materialeModal .modal-body .nav').tab(); 
                    
                    
                    jQuery('#materialeModal .modal-body').on("click",".elimina_file", function () {
                        var questo = jQuery(this);
                        var idfile = questo.attr("data-id");
                     
                        swal({
                           title: 'Sei sicuro di voler eliminare questo file?',
                           // text: "L'azione è irreversibile!",
                           type: 'warning',
                           buttons: {
                               confirm: {
                                   text: 'Si, elimina!',
                                   className: 'btn btn-success'
                               },
                               cancel: {
                                   visible: true,
                                   className: 'btn btn-danger'
                               }
                           }
                       }).then((willDeactivate) => {
                           if (willDeactivate) {
                                      jQuery.post("funzioni/corsi.php", {id_file: idfile, function: 'elimina_file'}, function (data) {
                                       jQuery('#div-file-'+idfile).remove();
                                       });
                           } else {
                               swal.close();
                           }
                       });
                     
                    });
                    
                    
                    
                    jQuery(".loadfile").fileinput({
                        uploadUrl: './funzioni/uploadfile_corso.php', // you must set a valid URL here else you will get an error
                        language: "it",
                        maxFileSize: 16000,
                        allowedFileExtensions:    ['jpg','jpeg','gif','png', 'txt','rtf','mp3','xls','xlsx','doc','docx','pdf','bmp','jpeg','odt','ods','pptx','ppt','tiff'],
                        allowedPreviewMimeTypes: ['image/jpeg','image/png','image/bmp'],// allow content to be shown only for certain mime types
                            previewFileIconSettings: {
                            'doc': '<i class="fa fa-file-word-o text-primary" style="font-size: 0.6em;"></i>',
                            'xls': '<i class="fa fa-file-excel-o text-success" style="font-size: 0.6em;"></i>',
                            'ppt': '<i class="fa fa-file-powerpoint-o text-danger" style="font-size: 0.6em;"></i>',
                            'jpg': '<i class="fa fa-file-photo-o text-warning" style="font-size: 0.6em;"></i>',
                            'pdf': '<i class="fa fa-file-pdf-o text-danger"  style="font-size: 0.6em;"></i>',
                            'zip': '<i class="fa fa-file-archive-o text-muted" style="font-size: 0.6em;"></i>',
                            'htm': '<i class="fa fa-file-code-o text-info" style="font-size: 0.6em;"></i>',
                            'txt': '<i class="fa fa-file-text-o text-info" style="font-size: 0.6em;"></i>',
                            'rtf': '<i class="fa fa-file-text-o text-info" style="font-size: 0.6em;"></i>',
                            'MOV': '<i class="fa fa-file-movie-o text-warning" style="font-size: 0.6em;"></i>',
                            '3gp': '<i class="fa fa-file-movie-o text-warning" style="font-size: 0.6em;"></i>',
                            'mp4': '<i class="fa fa-file-movie-o text-warning" style="font-size: 0.6em;"></i>',
                            'mp3': '<i class="fa fa-file-audio-o text-warning" style="font-size: 0.6em;"></i>',
                            'docx': '<i class="fa fa-file-word-o text-primary" style="font-size: 0.6em;"></i>',
                            'xlsx': '<i class="fa fa-file-excel-o text-success" style="font-size: 0.6em;"></i>',
                            'pptx': '<i class="fa fa-file-powerpoint-o text-danger" style="font-size: 0.6em;"></i>'
                        }
                 });
                         
//                            .on('fileuploaded', function(event, data, previewId, index) {
//                            jQuery('.modal-body #'+ data.response.nomeinput).val(data.response.nomefile);
//                //          // Nasconde il cestino dalla preview del file dopo averlo caricato
//                             jQuery('.modal-body #'+ previewId +' > div:nth-child(2) > div:nth-child(3) > div:nth-child(1) > button:nth-child(2)').hide();
//                        }).on("filebatchselected", function(event, files) {
//                                jQuery(this).fileinput("upload");
//                    });
                    
                    jQuery(".loadfile_video").fileinput({
                        uploadUrl: './funzioni/uploadfile_corso.php', // you must set a valid URL here else you will get an error
                        language: "it",
                        maxFileSize: 500000,
                        allowedFileExtensions:    ['mp4','mov','avi','mpg','mpeg','xvid'],
                        allowedPreviewMimeTypes: ['mp4','mov','avi','mpg','mpeg','xvid'],// allow content to be shown only for certain mime types
                            previewFileIconSettings: {
                            'MOV': '<i class="fa fa-file-movie-o text-warning" style="font-size: 0.6em;"></i>',
                            '3gp': '<i class="fa fa-file-movie-o text-warning" style="font-size: 0.6em;"></i>',
                            'mp4': '<i class="fa fa-file-movie-o text-warning" style="font-size: 0.6em;"></i>',
                        }
                        });
                        
                        
                   $("#materialeModal .modal-body #form_ins_vimeo").submit(function () {
                       
                        var serializedData = [];
                        serializedData = $("#materialeModal .modal-body #form_ins_vimeo").serialize();

                        $.post("funzioni/corsi.php",
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
                                   $('#materialeModal .modal-body #form_ins_vimeo').trigger("reset");
                                }
                            },
                            "json"
                        );
                    });    


                    
                }
            });
        });
        
        $(document).on('click', '.ins_edit', function (e) {
            
            var id = $(this).attr("for");
            
            $.ajax({
                url: 'funzioni/corsi.php',
                type: 'post',
                data: {
                    'id': id,
                    'func': 'load_ins_form'
                },
                success: function (response) {
                    
                     $('#ins_corsoModal .modal-body').html('');
                    // Add response in Modal body
                    $('#ins_corsoModal .modal-body').html(response);
                    
                    if(id!='0'){
                      $('#ins_corsoModal .modal-title').html('Modifica corso');
                    } else{
                      $('#ins_corsoModal .modal-title').html('Inserisci corso');  
                    }
                    // Display Modal
                    $('#ins_corsoModal').modal('show');
    

                    jQuery(".loadfile").fileinput({
                        uploadUrl: './funzioni/uploadfile.php', // you must set a valid URL here else you will get an error
                        language: "it",
                        dropZoneEnabled: false,
                        maxFileSize: 16000,
                        allowedFileExtensions:    ['jpg','jpeg','gif','png', 'txt','rtf','xls','xlsx','doc','docx','pdf','bmp','jpeg','odt','ods','pptx','ppt','tiff'],
                        showPreview: false
                        }).on('fileuploaded', function(event, data, previewId, index) {
                            jQuery('#ins_corsoModal .modal-body #'+ data.response.nomeinput).val(data.response.nomefile);
                //          // Nasconde il cestino dalla preview del file dopo averlo caricato
                             jQuery('#ins_agenteModal .modal-body #'+ previewId +' > div:nth-child(2) > div:nth-child(3) > div:nth-child(1) > button:nth-child(2)').hide();
                        }).on("filebatchselected", function(event, files) {
                                jQuery(this).fileinput("upload");
                    });


                    $("#ins_corsoModal .modal-body #form_ins_corso").submit(function () {
                        var serializedData = [];
                        serializedData = $("#ins_corsoModal .modal-body #form_ins_corso").serialize();
                 
         
                        $.post("funzioni/corsi.php",
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
                                    $('#ins_corsoModal').modal('hide');
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