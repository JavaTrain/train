<form method="POST" action="http://fwork.loc/<?=$action?>" class="login">

    <input value ="<?=$data['id'];?>" type="hidden" name="id" />
    <div>
        <label for="name">Name</label>
        <input id="name" value ="<?=$data['name'];?>" type="text" name="name" /><br />
    </div>
    <div>
        <label for="email">Email</label>
        <input id="email" value ="<?=$data['email'];?>" type="email" name="email" /><br />
    </div>
    <div>
        <label for="role">Role</label>
        <select id="role" name="role">
            <option disabled selected>Change role</option>
            <option <?=$data['role'] == "student" ? "selected" : ""?> value="student">Student</option>
            <option <?=$data['role'] == "couch" ? "selected" : ""?> value="couch">Couch</option>
        </select>
    </div>

    <h4>Courses</h4>
    <input <?php if(!empty($data)) echo in_array("1",$data['course']) ? "checked" : "" ?> id="php" type="checkbox" name="courses[]" value="1"><label for="php">PHP</label><br />
    <input <?php if(!empty($data)) echo in_array("2",$data['course']) ? "checked" : "" ?> id="java" type="checkbox" name="courses[]" value="2"><label for="java">JAVA</label><br />
    <input <?php if(!empty($data)) echo in_array("3",$data['course']) ? "checked" : "" ?> id="c++" type="checkbox" name="courses[]" value="3"><label for="c++">C++</label><br />

    <div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>