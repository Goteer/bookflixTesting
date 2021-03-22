
<?php
$newFileName = '';
if (isset($_FILES['uploadedPdf']) && $_FILES['uploadedPdf']['error'] === UPLOAD_ERR_OK) {




  // get details of the uploaded file
  $fileTmpPath = $_FILES['uploadedPdf']['tmp_name'];
  $fileName = $_FILES['uploadedPdf']['name'];
  $fileSize = $_FILES['uploadedPdf']['size'];
  $fileType = $_FILES['uploadedPdf']['type'];
  $fileNameCmps = explode(".", $fileName);
  $fileExtension = strtolower(end($fileNameCmps));

  if ($fileSize > 50000000) {
    echo "El limite de tama&ntilde;o de del pdf es de 50MB.";
    $uploadOk = 0;
  }

  // sanitize file-name
  $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

  // check if file has one of the following extensions
  $allowedfileExtensions = array('pdf');

  if (in_array($fileExtension, $allowedfileExtensions))
  {
    // directory in which the uploaded file will be moved
    $uploadFileDir = $_SERVER['DOCUMENT_ROOT'].'/pdf/pdfFiles/';
    $dest_path = $uploadFileDir . $newFileName;

    if(move_uploaded_file($fileTmpPath, $dest_path))
    {
      //echo 'PDF subido correctamente.';
      $uploadOk = 1;
    }
    else
    {
      echo 'Error moviendo el archivo subido al directorio adecuado. De ser posible, informe al webmaster de este error.';
      $uploadOk = 0;
    }
  }
  else
  {
    echo 'No se pudo subir el archivo. Tipos de archivo permitidos: ' . implode(',', $allowedfileExtensions);
    $uploadOk = 0;
  }
}else if (isset($_FILES['uploadedPdf']) && !$_FILES['uploadedPdf']['error'] === UPLOAD_ERR_OK){
  echo "No se pudo subir el archivo";
  $uploadOk = 0;
}else{
  echo "No se subio un pdf.";
  $uploadOk = 2;
}

?>
