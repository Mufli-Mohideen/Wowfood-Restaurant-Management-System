<?php
if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);
   
   $mongoClient = new MongoDB\Driver\Manager("mongodb://localhost:27017");
   
   // Specify the data to insert
   $data = [
   [
      'name' => $name,
      'email' => $email,
      'tele' => $number,
      'message' => $msg
   ]
   ];
   
   // BulkWrite instance
   $bulkWrite = new MongoDB\Driver\BulkWrite;
   
   // Insert each document into the collection
   foreach ($data as $document) {
   $bulkWrite->insert($document);
   }
   
   // collection name
   $collection = 'rpos.adbms_cw'; 
   
   // Execute the bulk write operation
   $mongoClient->executeBulkWrite($collection, $bulkWrite);
   
   $message[] = 'sent message successfully!';
   
   }

?>






<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
   body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f2f2f2;
   }
   .contact {
      max-width: 500px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
   }
   .title {
      text-align: center;
      color: #333;
   }
   .box {
      width: 100%;
      margin-bottom: 20px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
      font-size: 16px;
   }
   .box:focus {
      outline: none;
      border-color: #66afe9;
   }
   textarea {
      resize: vertical;
   }
   .btn {
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
   }
   .btn:hover {
      background-color: #45a049;
   }
</style>

</head>
<body>
<?php include 'partials-front/menu.php'; ?>

<section class="contact">

   <h1 class="title">Get In Touch</h1>

   <form action="" method="POST">
      <input type="text" name="name" class="box" required placeholder="enter your name">
      <input type="email" name="email" class="box" required placeholder="enter your email">
      <input type="number" name="number" min="0" class="box" required placeholder="enter your number">
      <textarea name="msg" class="box" required placeholder="enter your message" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" class="btn" name="send">
   </form>

</section>

<?php include 'partials-front/footer.php'; ?>

</body>
</html>


