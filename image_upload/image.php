<?php
header('Access-Control-Allow-Origin: *');
$target_path = "/home/idsgeo5/public_html/desenvolvimento/curso_udemy/img/";
$target_path = $target_path . basename( $_FILES['image']['name']);
$imageName = $_FILES['image']['name'];
$parts = explode('_', $_FILES['image']['name']);
$id = $parts[0];

if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
  $username = "idsgeo5_marmita";
  $password = "XXXXXXXX";
  try {
    $pdo = new PDO('mysql:host=localhost;dbname=idsgeo5_curso_udemy', $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare('UPDATE employees SET img = :img WHERE id = :id');
    $stmt->execute(array(
      ':id'   => $id,
      ':img' => $imageName
    ));
    echo $stmt->rowCount(); 
  } catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }
  echo "Upload and move success";
  
  
} else {
    //echo $target_path;
    echo "There was an error uploading the file, please try again!";
}
?>