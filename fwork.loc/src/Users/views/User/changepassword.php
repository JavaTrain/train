<?php
/**
 * Created by PhpStorm.
 * User: lamp
 * Date: 21.06.15
 * Time: 13:53
 */
?>
<form action="/change" method="post">

    <div>
        <label for="password_current">Current password:</label>
        <input type="password" name="password_current" id="password_current" />
    </div>

    <div>
        <label for="password_new">New password:</label>
        <input type="password" name="password_new" id="password_new" />
    </div>

<!--    <div>-->
<!--        <label for="password_new_again">New password again:</label>-->
<!--        <input type="password" name="password" id="password_new_again" />-->
<!--    </div>-->

    <div>
        <input type="submit" value="Change">
    </div>

</form>