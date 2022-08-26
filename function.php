<?php
class server{

 public function register(){
    include_once 'db.php';
    $conec = new Connection();
    $db = $conec->connect();

    if (isset($_POST['submit'])) {
      $Title = $_POST['Title'];
      $Description = $_POST['Description'];

      $insert = $db->prepare("INSERT INTO RegisterUser (sname,fname,username,phone)
	values(:sname,:fname,:username,:phone) ");

      $insert->bindParam(':sname', $sname);
      $insert->bindParam(':fname', $fname);
      $insert->bindParam(':username', $username);
      $insert->bindParam(':phone', $phone);
      $insert->execute();

      if ($insert) {
        //What you do here is up to you!
        echo "<script>alert('Registration Successful');</script>";
      }
    }
    return $insert;
  }
}

