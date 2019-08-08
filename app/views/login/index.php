<body>
<div id="bg">
    <div id="login_wrap">

        <div id="login">
            <div id="status">
                <i style="top: 0"><?php echo $ini_array[$language]['Login'] ?></i>
            </div>
            <form method="post" id="login-form" action="<?php echo htmlspecialchars('/login/login');?>">
                <div class="form-area">
                    <p class="form">
                        <input name="userName" type="text" id="user" placeholder="<?php echo $ini_array[$language]['username'] ?>" value="<?php echo $userName ?>"/>
                    </p>
                    <p class="form">
                        <input name="userPwd" type="password" id="passwd" placeholder="<?php echo $ini_array[$language]['password'] ?>" value="<?php echo $userPwd ?>">
                    </p>
                    <input type="button" value="<?php echo $ini_array[$language]['Login'] ?>" class="btn" onclick="logIn()">

                </div>
                <div class="msg-area">
                    <p>
                        <?php echo $ini_array[$language]['Haven\'t got an account?'] ?> <a href="<?php echo htmlspecialchars('/SignIn');?>"><?php echo $ini_array[$language]['Sign Up'] ?></a>
                    </p>
                    <p class="form-message" id="msg">
                        <?php
                            if(isset($ini_array[$language][$errorMsg])) {
                                echo $ini_array[$language][$errorMsg];
                            } else {
                                echo $errorMsg;
                            }
                        ?>
                    </p>
                </div>
            </form>
        </div>
        <input hidden id="door">
        <?php include "app/views/template/language.php" ?>
    </div>

</div>
