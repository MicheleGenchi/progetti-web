<script src="js/jquery.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $("#Datiform").submit(function(){
    //recupera tutti i valori del form automaticamente
    var datiform = $("#Datiform").serialize();
    $.ajax({
      type: "POST",
      url: "funzioni/send.php",
      data: datiform,
      dataType: "json",
      success: function(data) {
        if(data.status == 'success'){
          $('#consulente').hide();
          $("#msg_risposta").html(data.msg);
        }else if(data.status == 'error'){
          $("#msg_risposta").html(data.msg);
        }
      }
    });
    return false;
  });
  $("#MatricolaForm").submit(function(){
    //recupera tutti i valori del form automaticamente
    var datiform = $("#MatricolaForm").serialize();
    $.ajax({
      type: "POST",
      url: "funzioni/controllo.php",
      data: datiform,
      dataType: "json",
      success: function(data) {
        if(data.status == 'success'){
          $("#controllo").html(data.msg);
        }else if(data.status == 'error'){
          $("#controllo").html(data.msg);
        }
      }
    });
    return false;
  });

});
</script>
