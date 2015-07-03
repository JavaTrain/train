<?php
/**
 * Created by PhpStorm.
 * User: lamp
 * Date: 21.06.15
 * Time: 13:53
 */
?>
<form action="/auth" method="post">
    <div>
        <label for="login">Login:</label>
        <input type="text" name="login" id="login" />
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" />
    </div>
    <div>
        <label for="remember">Remember Me:</label>
        <input type="checkbox" name="remember" id="remember" />
    </div>
    <input type="hidden" name="token" value="<?=md5(uniqid())?>" />
    <div>
        <input type="submit" value="Login">
    </div>

</form>