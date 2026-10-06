var corsi_studenteDataTableOptions = {};

$(document).ready(function () {

    jQuery(function ($) { 

        corsi_studenteDataTableOptions["language"] = {
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

        // corsi_studenteDataTableOptions["dom"] = "lftp";
        corsi_studenteDataTableOptions["responsive"] = true;
        // corsi_studenteDataTableOptions["buttons"] = [
        //     'csv', 'excel', 'pdf'
        // ];
        corsi_studenteDataTableOptions["scrollY"] = false;
        corsi_studenteDataTableOptions["scrollX"] = true;
        corsi_studenteDataTableOptions["colReorder"] = true;

        corsi_studenteDataTableOptions["processing"] = true;
        corsi_studenteDataTableOptions["serverSide"] = true;
        corsi_studenteDataTableOptions["ajax"] = "funzioni/corsi_studente_load.php";
        corsi_studenteDataTableOptions["columns"] = [
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
                "name": "Scuola",
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
                "name": "assicurazione",
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
                "name": "materiale",
                "visible": true,
                "orderable": false,
                "searchable": false,
                "sClass": "text-center"
            }

           
        ];
        corsi_studenteDataTableOptions["order"] = [[1, 'desc']];

        var tablecorsi_studente = $('#corsi_studente_datatable').DataTable(corsi_studenteDataTableOptions);


        tablecorsi_studente.on('click', '.deleten', function (e) {
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
      



 $(document).on('click', '.load_materiale', function (e) {
            
            var id = $(this).attr("for");
            
            $.ajax({
                url: 'funzioni/corsi_studente.php',
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
                    
                   
                   // var iframe = document.querySelector('iframe');
                    
                    $('.vid_vimeo').each(function(i, obj){
                        var id_corso=$(this).data("id_corso");
                        var id_file_corso=$(this).data("id_file");
                        var player = new Vimeo.Player($(this));
                        player.on('play', function() {
                               $.ajax({
                                url: 'funzioni/corsi_studente.php',
                                type: 'post',
                                data: {
                                    'id': id_file_corso,
                                    'id_corso': id_corso,
                                    'func': 'check_visionato'
                                },
                              success: function (response) {       
                                  var dati=$.parseJSON(response);
                                  if(dati.completato=='s'){ 
                                      tablecorsi_studente.ajax.reload();
                                  }
                              }
                             });
                        }); 
                    });
          

                    
                   $('.visionato').on('play', function() {
                        var id_file_corso=$(this).data("id_file");
                        var id_corso=$(this).data("id_corso");
                          $.ajax({
                                url: 'funzioni/corsi_studente.php',
                                type: 'post',
                                data: {
                                    'id': id_file_corso,
                                    'id_corso': id_corso,
                                    'func': 'check_visionato'
                                },
                              success: function (response) {
                                  if(response.completato=='s'){
                                      tablecorsi_studente.ajax.reload();
                                  }
                              }
                             });
                    });
                    $('#materialeModal .modal-body .nav').tab(); 

                }
            });
        });

     });
            });
    
