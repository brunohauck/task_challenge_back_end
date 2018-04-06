<?php
echo "//--------------------- start -------------------------------<br />";
$day_before = "5";
$hours_before = "2";
$username = "idsgeo5_marmita";
$password = "XXXXXXXX";
  try {
    $pdo = new PDO('mysql:host=localhost;dbname=idsgeo5_curso_udemy', $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare('SELECT * FROM employees 
    WHERE (DAYOFYEAR(date_birth) - DAYOFYEAR(NOW()))  <= :day 
    and (DAYOFYEAR(date_birth) - DAYOFYEAR(NOW())) >= 1 
    and date_birth < DATE_SUB(NOW(), INTERVAL :hour HOUR) ');

    
    $stmt->execute(array(
      ':day'   => $day_before,
      ':hour'   => $hours_before
      
    ));
    //echo $stmt->rowCount(); 
    while ($row = $stmt->fetch()) {
      echo $row['first_name']."<br />\n";
      $name = $row['first_name'];
      $surename = $row['surename'];
      $mail_content = 'Happy birthday '.$name.' '.$surename.' !. <br>';
      $to = $row['email']; //users email field
      $subject = 'Happy birthday';
      $message = 'hello';
      $headers = 'From: atendimento@softwareon.com.br' . "\r\n" .
      'Reply-To: atendimento@softwareon.com.br' . "\r\n" .
      'X-Mailer: PHP/' . phpversion();
      mail($to, $subject, $mail_content, $headers);  
      
    }
  } catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }
?>