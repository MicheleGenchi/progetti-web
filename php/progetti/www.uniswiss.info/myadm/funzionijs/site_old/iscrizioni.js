var iscrizioniDataTableOptions = {};

$(document).ready(function () {

    jQuery(function ($) { 

        iscrizioniDataTableOptions["language"] = {
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

        // iscrizioniDataTableOptions["dom"] = "lftp";
        iscrizioniDataTableOptions["responsive"] = true;
        iscrizioniDataTableOptions["scrollX"] = true;
        // iscrizioniDataTableOptions["buttons"] = [
        //     'csv', 'excel', 'pdf'
        // ];
        iscrizioniDataTableOptions["scrollY"] = false;
        iscrizioniDataTableOptions["colReorder"] = true;

        iscrizioniDataTableOptions["processing"] = true;
        iscrizioniDataTableOptions["serverSide"] = true;
        iscrizioniDataTableOptions["ajax"] = "funzioni/iscrizioni_load.php";
     
     
     
 
        iscrizioniDataTableOptions["columns"] = [
            {
                "name": "id",
                "visible": false,
                "orderable": false,
                "searchable": false
            },
             {
                "name": "data",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "scuola",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "iscrizione",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "corso",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
             {
                "name": "acconto",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "num_rate",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "num_rate_pagate",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {"name": "modulo_assicurazione",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "contratto",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            
            {
                "name": "contratto_compilato",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "attestato",
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
        iscrizioniDataTableOptions["order"] = [[1, 'desc']];

        var tableScuole = $('#iscrizioni_datatable').DataTable(iscrizioniDataTableOptions);


        function deleteUtente(id) {
            var serializedData = [];
            serializedData.push({ name: 'func', value: 'elimina_record' });
            serializedData.push({ name: 'id', value: id });
            serializedData.push({ name: 'table', value: 'iscrizione_corso'});
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
                            text: 'Iscrizione eliminata.',
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
        
        
  $(document).on('click', '.load_bonifici', function (e) {
            
            var id = $(this).attr("for");
            
            $.ajax({
                url: 'funzioni/iscrizioni.php',
                type: 'post',
                data: {
                    'id': id,
                    'func': 'load_bonifici'
                },
                success: function (response) {
                    // Add response in Modal body
                    $('#ins_iscrizioneModal .modal-body').html(response);

                      $('#ins_iscrizioneModal .modal-title').html('Carica file del bonifico');
                  
                    // Display Modal
                    $('#ins_iscrizioneModal').modal('show');
                    $('#ins_iscrizioneModal .modal-body .nav').tab(); 
                    
                    
                    jQuery('#ins_iscrizioneModal .modal-body').on("click",".elimina_file", function () {
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
                                      jQuery.post("funzioni/iscrizioni.php", {id_file: idfile, function: 'elimina_file'}, function (data) {
                                       jQuery('#div-file-'+idfile).remove();
                                       });
                           } else {
                               swal.close();
                           }
                       });
                     
                    });
                    
                    
                    
                    jQuery(".loadfile").fileinput({
                        uploadUrl: './funzioni/uploadfile_bonifico.php', // you must set a valid URL here else you will get an error
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

                }
            });
        });
        
        function deleteUtente(id) {
            var serializedData = [];
            serializedData.push({ name: 'func', value: 'elimina_record' });
            serializedData.push({ name: 'id', value: id });
            serializedData.push({ name: 'table', value: 'studente_corso'});
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
        function pagato_non(id,stato_attuale) {
            var serializedData = [];
            serializedData.push({ name: 'func', value: 'attiva_utente' });
            serializedData.push({ name: 'id', value: id });
            serializedData.push({ name: 'table', value: 'iscrizione _corso'});
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

   tableScuole.on('click', '.pagato_non', function (e) {
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
                    pagato_non(id,stato_attuale);
                } else {
                    swal.close();
                }
            });
        });

        
        $(document).on('click', '.ins_edit', function (e) {
            
            var id = $(this).attr("for");
            
            $.ajax({
                url: 'funzioni/iscrizioni.php',
                type: 'post',
                data: {
                    'id': id,
                    'func': 'load_ins_form'
                },
                success: function (response) {
                    
                     $('#ins_iscrizioneModal .modal-body').html('');
                    // Add response in Modal body
                    $('#ins_iscrizioneModal .modal-body').html(response);
                    
                    if(id!='0'){
                      $('#ins_iscrizioneModal .modal-title').html('Modifica iscrizione');
                    } else{
                      $('#ins_iscrizioneModal .modal-title').html('Inserisci iscrizione');  
                    }
                    // Display Modal
                    $('#ins_iscrizioneModal').modal('show');
    


             $('#ins_iscrizioneModal .modal-body #id_studente').select2({
                 theme: "bootstrap",
                 dropdownParent: $('#ins_iscrizioneModal')  
             }); 
              $('#ins_iscrizioneModal .modal-body #id_corso').select2({
                 theme: "bootstrap",
                 dropdownParent: $('#ins_iscrizioneModal')  
             }); 
             
              jQuery(".loadfile").fileinput({
                        uploadUrl: './funzioni/uploadfile.php', // you must set a valid URL here else you will get an error
                        language: "it",
                        dropZoneEnabled: false,
                        maxFileSize: 16000,
                        allowedFileExtensions:    ['jpg','jpeg','gif','png', 'txt','rtf','mp4','mp3','3gp','mov','xls','xlsx','doc','docx','pdf','bmp','jpeg','odt','ods','pptx','ppt','tiff'],
                        showPreview: false
                        }).on('fileuploaded', function(event, data, previewId, index) {
                            jQuery('#ins_iscrizioneModal .modal-body #'+ data.response.nomeinput).val(data.response.nomefile);
                //          // Nasconde il cestino dalla preview del file dopo averlo caricato
                             jQuery('#ins_iscrizioneModal .modal-body #'+ previewId +' > div:nth-child(2) > div:nth-child(3) > div:nth-child(1) > button:nth-child(2)').hide();
                        }).on("filebatchselected", function(event, files) {
                                jQuery(this).fileinput("upload");
                    });

                    $("#ins_iscrizioneModal .modal-body #form_ins_iscrizione").submit(function () {
                        var serializedData = [];
                        serializedData = $("#ins_iscrizioneModal .modal-body #form_ins_iscrizione").serialize();
                 
         
                        $.post("funzioni/iscrizioni.php",
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
                                    $('#ins_iscrizioneModal').modal('hide');
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