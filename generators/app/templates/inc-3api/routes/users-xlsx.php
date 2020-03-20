<?php
return function ($request, $response, $args) {
  global $api;
  $data = $api->query("SELECT * FROM users");
  //
  $doc = new \PHPExcel();
  $doc->setActiveSheetIndex(0);
  $doc->getActiveSheet()->SetCellValue('A1', 'ID');
  $doc->getActiveSheet()->SetCellValue('B1', 'TOKEN');
  $doc->getActiveSheet()->SetCellValue('C1', 'NAME');
  $doc->getActiveSheet()->SetCellValue('D1', 'LASTNAME');
  $doc->getActiveSheet()->SetCellValue('E1', 'EMAIL');
  $index = 2;
  foreach ($data as $reg) {
    $doc->getActiveSheet()->SetCellValue('A' . $index, $reg->id);
    $doc->getActiveSheet()->SetCellValue('B' . $index, $reg->token);
    $doc->getActiveSheet()->SetCellValue('C' . $index, $reg->name);
    $doc->getActiveSheet()->SetCellValue('D' . $index, $reg->lastname);
    $doc->getActiveSheet()->SetCellValue('E' . $index, $reg->email);
    $index++;
  }
  $filename = "users.xlsx";
  $objWriter = \PHPExcel_IOFactory::createWriter($doc, 'Excel2007');
  $objWriter->save('php://output');
  header('Content-Disposition: attachment; filename=' . $filename);

  return $api->response($response, '', 200, 'application/vnd.ms-excel');
};
