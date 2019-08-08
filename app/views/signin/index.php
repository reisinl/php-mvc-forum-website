<body>
<div id="bg">
    <div id="login_wrap">
        <div id="login">
            <div id="status">
                <i style="width:400px;"><?php echo $ini_array[$language]['Sign Up'] ?></i>
            </div>
            <form method="post" id="login-form" action="<?php echo htmlspecialchars('/SignIn/SignIn');?>">
                <div class="form-area">
                    <p class="form">
                        <input name="userName" type="text" id="user" placeholder="<?php echo $ini_array[$language]['username'] ?>" value="<?php echo $userName ?>"/>
                    </p>
                    <p class="form">
                        <input name="userPwd" type="password" id="passwd" placeholder="<?php echo $ini_array[$language]['password'] ?>" value="<?php echo $userPwd ?>"/>
                    </p>
                    <p class="form confirm">
                        <input name="userPwdCfm" type="password" placeholder="<?php echo $ini_array[$language]['confirm password'] ?>" value="<?php echo $userPwdCfm ?>"/>
                    </p>
                    <p class="form confirm">
                        <input name="firstName" type="text" placeholder="<?php echo $ini_array[$language]['your first name'] ?>" value="<?php echo $firstName ?>"/>
                    </p>
                    <p class="form confirm">
                        <input name="lastName" type="text" placeholder="<?php echo $ini_array[$language]['your last name'] ?>" value="<?php echo $lastName ?>"/>
                    </p>
                    <p class="form confirm">
                        <input name="email" type="text" placeholder="<?php echo $ini_array[$language]['your email'] ?>" value="<?php echo $email ?>"/>
                    </p>
                    <input type="button" value="<?php echo $ini_array[$language]['Sign Up'] ?>" class="btn" onclick="signIn()" id="btn">

                </div>
                <div class="sign-msg-area">
                    <p>
                        <?php echo $ini_array[$language]['Already got an account?'] ?>
                        <a href="<?php echo htmlspecialchars('/Login');?>"><?php echo $ini_array[$language]['Login'] ?></a>
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