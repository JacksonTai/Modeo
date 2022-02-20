<?php

// connect to database
$db_hostname = "localhost";
$db_username = "root";
$db_password = "";
$db_database = "test";

$conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

// check connection
if (!$conn) {
     die("<h2>Failed to connect to MySQL</h2> Connection error: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="test.css">
     <title>Test File</title>
</head>

<body>

     <!-- <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
          <label for="iban">iban</label>
          <input id="iban" type="text" name="iban" />
          <input type="file" name="varName">
          <button type="submit" name="btnName">Submit</button>
     </form> -->
     <?php

     // date_default_timezone_set("Asia/Kuala_Lumpur");
     // echo date('Y-m-d');
     // echo '<br>';
     // echo date('H:i:s');
     // if (isset($_POST['btnName'])) {
     //      // Get temporary name of the file
     //      $tmpName = $_FILES['varName']['tmp_name'];

     //      // Convert the file into string
     //      $strImg = file_get_contents($tmpName);

     //      $encodedImg = base64_encode($strImg);


     //      $sql = "INSERT INTO test_table (img) VALUES (?)";


     //      /* ===== Execute insert query ===== */
     //      // Initialize prepared statement
     //      $stmt = mysqli_stmt_init($conn);

     //      // Prepare the statement
     //      if (!mysqli_stmt_prepare($stmt, $sql)) {
     //           die('<h2>SQL statement failed</h2>query error: ' . mysqli_error($conn));
     //      } else {
     //           // Bind parameter to statement
     //           mysqli_stmt_bind_param($stmt, 's', $encodedImg);

     //           // Execute prepared statement
     //           mysqli_stmt_execute($stmt);
     //      }

     //      // mysqli_query($conn, $sql);

     //      // Execute select query
     //      $imgSql = "SELECT * FROM test_table WHERE img = '$encodedImg'";
     //      $imgResult = mysqli_query($conn, $imgSql);
     //      $resultArr = mysqli_fetch_array($imgResult, MYSQLI_ASSOC);
     //      $img = $resultArr['img'];
     // }

     ?>
     <?php if (isset($img)) : ?>
          <img class="manage-product__item-image" src="data:image/jpg;charset=utf8;base64,<?php echo htmlspecialchars($img); ?>" alt="Image">
     <?php endif; ?>
     <script src="test.js"></script>
</body>

</html>