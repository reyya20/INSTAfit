<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
      .side-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 300px; /* Adjust width as needed */
            height: 100vh; /* Full height */
            background-color: white;
            color: white;
            overflow-y: auto;
            padding-top: 20px; /* Adjust padding as needed */
        }

        .side-bar a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .side-bar a i {
            display: block;
            margin-bottom: 5px;
        }

        .side-bar a:hover {
            background-color: white;
            color: black;
        }

        /* Hide scrollbar */
        .side-bar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for Firefox */
        .side-bar {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }
         .navbar {
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            background-color: white;
            padding: 10px;
            height: 100vh; /* Full height */
        }

        .navbar a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a i {
            display: block;
            margin-bottom: 5px;
        }

        .navbar a:hover {
            background-color: white;
            color: black;
        }

        /* Hide scrollbar */
        .navbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for Firefox */
        .navbar {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }
    </style>
</head><?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo" background-colorgreen >INSTAfit</a>

      <form action="search_course.php" method="post" class="search-form">
         <input type="text" name="search_course" placeholder="search courses..." required maxlength="100">
         <button type="submit" class="fas fa-search" name="search_course_btn"></button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="toggle-btn" class="fas fa-sun"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <span>student</span>
         <a href="profile.php" class="btn">view profile</a>
         <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
         <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         <?php
            }else{
         ?>
         <h3>please login or register</h3>
          <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
         <?php
            }
         ?>
      </div>

   </section>

</header>

<!-- header section ends -->

<!-- side bar section starts  -->

<div class="side-bar">

   <div class="close-side-bar">
      <i class="fas fa-times"></i>
   </div>

   <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <span>User</span>
         <a href="profile.php" class="btn">view profile</a>
         <?php
            }else{
         ?>
         <h3>please login or register</h3>
          <div class="flex-btn" style="padding-top: .5rem;">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
         <?php
            }
         ?>
      </div>

   <nav class="navbar">
      <a href="home.php"><i class="fas fa-home"></i><span>home</span></a>
      <a href="about.php"><i class="fas fa-question"></i><span>about us</span></a>
      <a href="courses.php"><i class="fas fa-dumbbell"></i><span>Exercise</span></a>
      <a href="teachers.php"><i class="fas fa-user"></i><span>Trainer</span></a>
      <a href="weekly_challenge.php"><i class="fas fa-trophy"></i><span>Weekly Challenge</span></a>
      <a href="http://127.0.0.1:8000/home/"><i class="fas fa-apple-alt"></i><span>CalorieWise</span></a>

      <a href="contact.php"><i class="fas fa-bolt"></i><span>MuscleMaster</span></a>
      <a href="contact.php"><i class="fas fa-headset"></i><span>contact us</span></a>
      <!-- Red Apple -->

   </nav>

</div>
</body
</html>
<!-- side bar section ends -->