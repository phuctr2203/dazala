<?php

require_once '../login_page/db.php';

?>

<header class="header">

   <div class="header-1">
      <div class="flex">
         <p><a href="../login_page/login.php">login</a> | <a href="../login_page/register/pre_register.php">register</a> </p>
      </div>
   </div>

   <div class="header-2">
      <div class="flex">
         <a href="homepage.php" class="logo">DAZALA</a>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
         </div>

         <div class="user-box">
            <a href="logout.php" class="delete-btn">logout</a>
         </div>
      </div>
   </div>

</header>