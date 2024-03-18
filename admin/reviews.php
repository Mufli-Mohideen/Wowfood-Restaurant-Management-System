<?php


if (isset($_GET['delete'])) {
   
   $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

   $delete_id = $_GET['delete'];

   // Filter to match the document with the given ID
   $filter = ['_id' => new MongoDB\BSON\ObjectId($delete_id)];

   //Delete command
   $command = new MongoDB\Driver\Command([
       'delete' => 'adbms_cw', // Collection name
       'deletes' => [
           ['q' => $filter, 'limit' => 1] // Limiting to delete only one document
       ],
       'writeConcern' => new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000)
   ]);

   // Execute the delete command
   try {
       $result = $manager->executeCommand('rpos', $command);
   } catch (MongoDB\Driver\Exception\Exception $e) {
       echo "Error deleting document: " . $e->getMessage();
       exit;
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">
<style>
   .messages {
   max-width: 800px;
   margin: 50px auto;
   padding: 20px;
   background-color: #fff;
   border-radius: 10px;
   box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.title {
   text-align: center;
   color: #333;
   margin-bottom: 20px;
}

.box-container {
   display: grid;
   grid-gap: 20px;
}

.box {
   padding: 20px;
   border: 1px solid #ccc;
   border-radius: 10px;
   background-color: #f9f9f9;
}

.box p {
   margin: 5px 0;
}

.delete-btn {
   display: inline-block;
   background-color: #ff4d4d;
   color: #fff;
   padding: 5px 10px;
   border-radius: 5px;
   text-decoration: none;
}

.delete-btn:hover {
   background-color: #cc0000;
}
</style>
</head>
<body>
   
<?php include 'partials/menu.php'; ?>

<section class="messages">

   <h1 class="title">messages</h1>

   <div class="box-container">

   <?php
      $mongoClient = new MongoDB\Driver\Manager("mongodb://localhost:27017");

      // Specify the query
      $query = new MongoDB\Driver\Query([]);

      // Execute the query
      $cursor = $mongoClient->executeQuery('rpos.adbms_cw', $query);

      // Iterate through the results
      foreach ($cursor as $document) {
   ?>
   <div class="box">
      <p>Name: <?= $document->name ?></p>
      <p>Tele: <?= $document->tele ?></p>
      <p>Email: <?= $document->email ?></p>
      <p>Message: <?= $document->message ?></p>
      <a href="reviews.php?delete=<?= $document->_id; ?>" onclick="return confirm('Delete this message?');" class="delete-btn">Delete</a>
   </div>

   <?php
   }
   ?>

   </div>

</section>


</body>
</html>