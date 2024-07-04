<?php
session_start(); // Start the session

include '../components/connect.php';

// Check if tutor is logged in by checking the cookie
if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
} else {
   $tutor_id = '';
   header('location:login.php');
   exit(); // Ensure the script stops executing after redirection
}

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
   $title = $_POST['title'];
   $description = $_POST['description'];

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

         // Redirect back to the same page to refresh with the updated challenges
         header('location: weekly_challenge.php');
         exit();
      } else {
         echo '<p>Failed to upload image.</p>';
      }
   } else {
      echo '<p>Error uploading file.</p>';
   }
}

// Fetch the weekly challenges
$select_challenges = $conn->prepare("SELECT * FROM `weekly_challenge` ORDER BY date DESC");
$select_challenges->execute();
$challenges = $select_challenges->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Weekly Challenges</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="challenges">

   <h1 class="heading">Weekly Challenges</h1>

   <!-- Upload form -->
   <div class="box-container">
      <div class="box">
         <h3 class="title">Upload Weekly Challenge</h3>
         <form action="" method="POST" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>
            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            <button type="submit" name="submit" class="btn">Upload Challenge</button>
         </form>
      </div>
   </div>

   <!-- Display existing challenges -->
   <div class="box-container">
      <?php
      if(count($challenges) > 0){
         foreach($challenges as $challenge){
      ?>
      <div class="box">
         <img src="../uploaded_files/<?= $challenge['image']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $challenge['title']; ?></h3>
         <p><?= $challenge['description']; ?></p>
         <p>Votes: <span><?= $challenge['votes']; ?></span></p>
         <a href="profile.php?tutor_id=<?= $challenge['tutor_id']; ?>" class="inline-btn">View Profile</a>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">No challenges available</p>';
      }
      ?>
   </div>

</section>

<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>
