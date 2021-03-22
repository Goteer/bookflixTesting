
<?php
if (isset($_FILES['uploadedVideo']) && $_FILES['uploadedVideo']['error'] === UPLOAD_ERR_OK) {




  // get details of the uploaded file
  $fileTmpPath = $_FILES['uploadedVideo']['tmp_name'];
  $fileName = $_FILES['uploadedVideo']['name'];
  $fileSize = $_FILES['uploadedVideo']['size'];
  $fileType = $_FILES['uploadedVideo']['type'];
  $fileNameCmps = explode(".", $fileName);
  $fileExtension = strtolower(end($fileNameCmps));

  if ($fileSize > 25000000) {
    echo "El limite de tama&ntilde;o de video es de 25MB.";
    $uploadOk = 0;
  }

  // sanitize file-name
  $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

  // check if file has one of the following extensions
  $allowedfileExtensions = array('mp4', 'webm', 'ogg');

  if (in_array($fileExtension, $allowedfileExtensions))
  {
    // directory in which the uploaded file will be moved
    $uploadFileDir = $_SERVER['DOCUMENT_ROOT'].'/resources/video/videosSubidos/';
    $dest_path = $uploadFileDir . $newFileName;

    if(move_uploaded_file($fileTmpPath, $dest_path))
    {
      //echo 'Video subido correctamente.';
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
}else if (isset($_FILES['uploadedVideo']) && !$_FILES['uploadedVideo']['error'] === UPLOAD_ERR_OK){
  echo "No se pudo subir el archivo";
  $uploadOk = 0;
}else{
  echo "No se subio un video.";
  $uploadOk = 2;
}

?>
