<?php
return function ($request, $response, $args) {
  global $api;
  $data = $api->query("SELECT * FROM users");
  //
  $output = fopen('php://output', 'w');
  fputcsv($output, array('id', 'token', 'name', 'lastname', 'email'));
  foreach ($data as $reg) {
    fputcsv($output, array($reg->id, $reg->token, $reg->name, $reg->lastname, $reg->email));
  }
  $filename = "users.csv";
  header('Content-Disposition: attachment; filename=' . $filename);
};
