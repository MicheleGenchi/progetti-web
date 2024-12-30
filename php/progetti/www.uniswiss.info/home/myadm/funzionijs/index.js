var studentiDataTableOptions = {};

$(document).ready(function () {

    jQuery(function ($) { 

        studentiDataTableOptions["language"] = {
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

        // studentiDataTableOptions["dom"] = "lftp";
        studentiDataTableOptions["responsive"] = true;
        // studentiDataTableOptions["buttons"] = [
        //     'csv', 'excel', 'pdf'
        // ];
        studentiDataTableOptions["scrollY"] = false;
        studentiDataTableOptions["scrollX"] = true;
        studentiDataTableOptions["colReorder"] = true;

        studentiDataTableOptions["processing"] = true;
        studentiDataTableOptions["serverSide"] = true;
        studentiDataTableOptions["ajax"] = "funzioni/index_load.php";
        studentiDataTableOptions["columns"] = [
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
                "name": "comune_nascita",
                "visible": true,
                "orderable": true,
                "searchable": true
            },
            {
                "name": "data_nascita",
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
                "name": "attivo",
                "visible": true,
                "orderable": true,
                "searchable": true,
                "sClass": "text-center"
            },
            
             {
                "name": "doc_identita",
                "visible": true,
                "orderable": false,
                "searchable": false,
                "sClass": "text-center"
            },
              {
                "name": "cod_fiscale",
                "visible": true,
                "orderable": false,
                "searchable": false,
                "sClass": "text-center"
            },
             {
                "name": "statino_esami",
                "visible": true,
                "orderable": false,
                "searchable": false,
                "sClass": "text-center"
            },
               {
                "name": "titolo_studio",
                "visible": true,
                "orderable": false,
                "searchable": false,
                "sClass": "text-center"
            },
               {
                "name": "data_laurea",
                "visible": true,
                "orderable": false,
                "searchable": false,
                "sClass": "text-center"
            },
               {
                "name": "matricola",
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
        studentiDataTableOptions["order"] = [[1, 'desc']];

        var tablestudenti = $('#studenti_datatable').DataTable(studentiDataTableOptions);


        function deleteUtente(id) {
            var serializedData = [];
            serializedData.push({ name: 'func', value: 'elimina_record' });
            serializedData.push({ name: 'id', value: id });
            serializedData.push({ name: 'table', value: 'anagrafica_studenti_swiss'});
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
                        tablestudenti.ajax.reload();
                        tablestudenti.columns.adjust();
                    }
                },
                "json"
            );
        }

        function deactivateUtente(id,stato_attuale) {
            var serializedData = [];
            serializedData.push({ name: 'func', value: 'attiva_utente' });
            serializedData.push({ name: 'id', value: id });
            serializedData.push({ name: 'table', value: 'anagrafica_studenti_swiss'});
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
                        tablestudenti.ajax.reload();
                        tablestudenti.columns.adjust();
                    }
                },
                "json"
            );
        }

        tablestudenti.on('click', '.deleten', function (e) {
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

        tablestudenti.on('click', '.deactivaten', function (e) {
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

        // tablestudenti.on('click', '.editn', function (e) {
        //     var id = $(this).attr("for");

        //     $('.modal-body').load('funzioni/utenti_functions.php?id=' + id + '&func=utenteLoad', function () {
        //         $('#editProfessionistaModal').modal('show');
        //     });
        // });


        $(document).on('click', '.ins_edit', function (e) {
            
            var id = $(this).attr("for");
            
            $.ajax({
                url: 'funzioni/index.php',
                type: 'post',
                data: {
                    'id': id,
                    'func': 'load_ins_form'
                },
                success: function (response) {
                    // Add response in Modal body
                    $('#ins_studenteModal .modal-body').html('');
                    $('#ins_studenteModal .modal-body').html(response);

                      if(id!='0'){
                      $('#ins_studenteModal .modal-title').html('Modifica studente');
                    } else{
                      $('#ins_studenteModal .modal-title').html('Inserisci studente');  
                    } 
$.fn.modal.Constructor.prototype.enforceFocus = function () {
$(document)
  .off('focusin.bs.modal') // guard against infinite focus loop
  .on('focusin.bs.modal', $.proxy(function (e) {
    if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
      this.$element.focus()
    }
  }, this))
}

   $('#data_laurea').datepicker(
                        {dateFormat: 'dd/mm/yy',
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-100:+0",
                         beforeShow: function(input, inst) {
        $(document).off('focusin.bs.modal');
    },
    onClose:function(){
        $(document).on('focusin.bs.modal');
    }
                      });

                 $('#data_nascita').datepicker(
                        {dateFormat: 'dd/mm/yy',
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-100:+0",
                         beforeShow: function(input, inst) {
        $(document).off('focusin.bs.modal');
    },
    onClose:function(){
        $(document).on('focusin.bs.modal');
    }
                      });
                    // Display Modal
                    $('#ins_studenteModal').modal('show');
                     
         
                    jQuery(".loadfile").fileinput({
                        uploadUrl: './funzioni/uploadfile.php', // you must set a valid URL here else you will get an error
                        language: "it",
                        dropZoneEnabled: false,
                        maxFileSize: 16000,
                        allowedFileExtensions:    ['jpg','jpeg','gif','png', 'txt','rtf','mp4','mp3','3gp','mov','xls','xlsx','doc','docx','pdf','bmp','jpeg','odt','ods','pptx','ppt','tiff'],
                        showPreview: false
                        }).on('fileuploaded', function(event, data, previewId, index) {
                            jQuery('#ins_studenteModal .modal-body #'+ data.response.nomeinput).val(data.response.nomefile);
                //          // Nasconde il cestino dalla preview del file dopo averlo caricato
                             jQuery('#ins_studenteModal .modal-body #'+ previewId +' > div:nth-child(2) > div:nth-child(3) > div:nth-child(1) > button:nth-child(2)').hide();
                        }).on("filebatchselected", function(event, files) {
                                jQuery(this).fileinput("upload");
                    });


                    $('#ins_studenteModal .modal-body #id_provincia').select2({
                      // theme: "bootstrap",
                       dropdownParent: $('#ins_studenteModal')  
                    });


                    $("#ins_studenteModal .modal-body #form_ins_studente").submit(function () {

                        var serializedData = $("#ins_studenteModal .modal-body #form_ins_studente").serialize();
                 
         
                        $.post("funzioni/index.php",
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
                                    tablestudenti.ajax.reload();
                                    tablestudenti.columns.adjust();
                                    $('#ins_studenteModal').modal('hide');
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