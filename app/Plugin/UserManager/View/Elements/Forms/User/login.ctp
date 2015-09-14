<?php
echo $this->Form->create(null, array(
    "url" => array("plugin" => "user_manager", "controller" => "users", "action" => "login"),
    'method' => 'post'
));
?>
<div class="container">
    <div class="login-left">
        <div class="login-right">
            <div class="login-middle">
                <div class="slogan">Logic Inventory System &raquo;</div>
                <div class="logo-container">
                    <div class="logo"></div>
                    <div class="locker"></div>
                </div>
                <div class="administration-login">LOGIN PANEL</div>
                <div class="user-password">
                    <div class="alert-error" align="center">
                        <?php echo $this->Session->flash("auth"); ?>
                    </div>
                    <div class="input-prepend user-name">
                        <h4 class="username-password username-password-header">User Name:</h4>
                        <span class="add-on"><i class="icon-user"></i></span><input name='data[User][username]' class="span2" id="inputIcon" type="text" name="name" placeholder="User Name">
                    </div>
                    <div class="input-prepend password">
                        <h4 class="username-password username-password-header">Password:</h4>
                        <span class="add-on"><i class="icon-password"></i></span><input name='data[User][screetp]' class="span2" id="inputIcon" type="password" name="password" placeholder="*****">
                    </div>
                </div>
                <div class="login-footer">
                    <div class="rember-me">
                        <ul>
                            <li>
                                <label class="checkbox">
                                    <input type="checkbox">Remember Me
                                </label>
                            </li>
                            <li class="forgot">Forgot Password?</li>
                        </ul>
                    </div>
                    <div class="sign-in">
                        <button type="submit" class="btn ">Sign In</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>