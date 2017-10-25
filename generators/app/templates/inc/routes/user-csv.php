<?php
  return function($request, $response, $args) {
    global $api;
    $data = $api->query("SELECT * FROM usuarios");
    //
    $output = fopen('php://output', 'w');
    fputcsv($output, array('id', 'nombre', 'email', 'token', 'creado'));
    foreach($data as $reg) {
      fputcsv($output, array($reg->id, $reg->nombre, $reg->email, $reg->token, $reg->creado));
    }
    $filename = "usuarios.csv";
    header('Content-Disposition: attachment; filename=' . $filename);
  };