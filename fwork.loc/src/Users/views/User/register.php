<?php
/**
 * Created by PhpStorm.
 * User: lamp
 * Date: 21.06.15
 * Time: 13:53
 */
if(!empty($errors))
    foreach($errors as $item)
        echo $item . '<br />';
?>
<form action="/reg" method="post">

    <div>
        <label for="name">Name:</label>
        <input value ="<?=$_POST['name'];?>" id="name" type="text" name="name" /><br />
    </div>

    <div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" />
    </div>

    <div>
        <label for="email">Email:</label>
        <input value ="<?=$_POST['email'];?>" id="email" type="email" name="email" /><br />
    </div>

    <div>
        <label for="role">Role:</label>
        <select id="role" name="role">
            <option disabled selected>Change role</option>
            <option <?=$_POST['role'] == "student" ? "selected" : "" ?> value="student">Student</option>
            <option <?=$_POST['role'] == "couch" ? "selected" : "" ?> value="couch">Couch</option>
        </select>
    </div>

    <input type="hidden" name="token" value="<?=md5(uniqid())?>" />

    <div>
        <input type="submit" value="Register">
    </div>

</form>