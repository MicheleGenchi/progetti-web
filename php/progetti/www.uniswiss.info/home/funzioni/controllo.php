<?php
header('Content-type: application/json');
if(isset($_POST['controllo'])!="")
{
  $response_array['status'] = 'error';
  $msg='<div class="alert alert-danger" role="alert">Questa matricola non è valida</div>';
  $response_array['msg'] = $msg;
}
else
{
  $controllo = $_POST["certificato"];
  if ($controllo=='00157458210')
  {
  $response_array['status'] = 'success';
  $msg='<div class="alert alert-success" role="alert">Matricola valida, diploma di laurea conseguito.</div>';
  $response_array['msg'] = $msg;
  }
  else
  {
  $response_array['status'] = 'error';
  $msg='<div class="alert alert-danger" role="alert">Questa matricola non è valida</div>';
  $response_array['msg'] = $msg;
  }
}
echo json_encode($response_array);
?>
