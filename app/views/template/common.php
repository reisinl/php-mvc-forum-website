<div class="dropdown">
  <a class="dropbtn">
    <?php echo $userName ?>
  </a>
  <div class="dropdown-content">
<!--    <a href="--><?php //echo htmlspecialchars('/profile/index?'.$_SESSION['user_id']);?><!--">-->
<!--      Profile-->
<!--    </a>-->
    <a href="<?php echo htmlspecialchars('/func/logout');?>">
        <?php echo $ini_array[$language]['Logout'] ?>
    </a>
  </div>
</div>