<?php
return function ($request, $response, $args) {
  global $api;
  $data = $api->query("SELECT * FROM users");
  //
  $output = fopen('php://output', 'w');
  fputcsv($output, array('id', 'nombre', 'email', 'token', 'creado'));
  foreach ($data as $reg) {
    fputcsv($output, array($reg->id, $reg->nombre, $reg->email, $reg->token, $reg->creado));
  }
  $filename = "users.csv";
  header('Content-Disposition: attachment; filename=' . $filename);
};