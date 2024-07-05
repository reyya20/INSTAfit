<!-- upload_weekly_challenge.php -->

<?php
session_start(); // Start the session

include '../components/connect.php';

// Check if tutor is logged in by checking the cookie
if (!isset($_COOKIE['tutor_id'])) {
   header('location: login.php');
   exit(); // Ensure the script stops executing after redirection
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
   $title = $_POST['title'];
   $description = $_POST['description'];
   $tutor_id = $_COOKIE['tutor_id'];

   // File upload handling
   $file_name = $_FILES['image']['name'];
   $file_tmp = $_FILES['image']['tmp_name'];
   $file_size = $_FILES['image']['size'];
   $file_error = $_FILES['image']['error'];

   // Check if file was uploaded without errors
   if ($file_error === 0) {
      // Validate file size if needed

      // Generate unique file name
      $file_destination = '../uploaded_files/' . $file_name;

      // Move uploaded file to destination
      if (move_uploaded_file($file_tmp, $file_destination)) {
         // Insert challenge details into database
         $insert_challenge = $conn->prepare("INSERT INTO `weekly_challenge` (title, description, image, tutor_id) VALUES (?, ?, ?, ?)");
         $insert_challenge->execute([$title, $description, $file_name, $tutor_id]);

         // Redirect to a confirmation page or back to challenges page
         header('location: weekly_challenge.php');
         exit();
      } else {
         echo '<p>Failed to upload image.</p>';
      }
   } else {
      echo '<p>Error uploading file.</p>';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Upload Weekly Challenge</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="upload-challenge">
   <h1 class="heading">Upload Weekly Challenge</h1>
   <div class="box-container">
      <form action="" method="POST" enctype="multipart/form-data" class="upload-form">
         <label for="title">Title:</label>
         <input type="text" id="title" name="title" required>
         <label for="description">Description:</label>
         <textarea id="description" name="description" rows="4" required></textarea>
         <label for="image">Upload Image:</label>
         <input type="file" id="image" name="image" accept="image/*" required>
         <button type="submit" name="submit" class="btn">Upload Challenge</button>
      </form>
   </div>
</section>

<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>
