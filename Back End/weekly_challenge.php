<?php

include 'components/connect.php';

session_start();

if(!isset($_COOKIE['user_id'])){
   header('location:login.php');
}

$user_id = $_COOKIE['user_id'];

if(isset($_POST['vote'])){
   $challenge_id = $_POST['challenge_id'];
   $check_vote = $conn->prepare("SELECT * FROM `votes` WHERE user_id = ? AND challenge_id = ?");
   $check_vote->execute([$user_id, $challenge_id]);
   
   if($check_vote->rowCount() == 0){
      $insert_vote = $conn->prepare("INSERT INTO `votes` (user_id, challenge_id, vote) VALUES (?, ?, ?)");
      $insert_vote->execute([$user_id, $challenge_id, 1]);
      $update_votes = $conn->prepare("UPDATE `weekly_challenge` SET votes = votes + 1 WHERE id = ?");
      $update_votes->execute([$challenge_id]);
      $message[] = 'Voted successfully!';
   }else{
      $message[] = 'You have already voted for this image!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Weekly Challenge</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="challenge-container">

   <h1 class="heading"><strong>Weekly Challenge </strong><center><br>trending post </h1></center>

   <div class="box-container">

      <?php
         $select_challenges = $conn->prepare("SELECT * FROM `weekly_challenge` ORDER BY votes DESC");
         $select_challenges->execute();
         if($select_challenges->rowCount() > 0){
            while($fetch_challenge = $select_challenges->fetch(PDO::FETCH_ASSOC)){
               $challenge_id = $fetch_challenge['id'];
      ?>
      <div class="box">
         <img src="uploaded_files/<?= $fetch_challenge['image']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fetch_challenge['title']; ?></h3>
         <p><?= $fetch_challenge['description']; ?></p>
         <p>Votes: <span><?= $fetch_challenge['votes']; ?></span></p>
         <form action="" method="post">
            <input type="hidden" name="challenge_id" value="<?= $challenge_id; ?>">
            <input type="submit" value="Vote" name="vote" class="btn">
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No images submitted yet!</p>';
      }
      ?>

   </div>

</section>

</body>
</html>
