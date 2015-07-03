<div class="conteiner">

<h1>Students list</h1>
    <a href="http://fwork.loc/add/create" class="btn btn-primary">Create Student</a>
<table class="~table table-bordered stripy">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Role</th>
            <th>Email</th>
            <th>Course</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tfoot></tfoot>
<?php
    foreach($list as $row){
?>
    <tbody>
        <tr>
            <td><?=$row['id']?></td>
            <td><?=$row['name']?></td>
            <td><?=$row['role']?></td>
            <td><?=$row['email']?></td>
            <td><?=$row['course']?></td>
            <td><a href="http://fwork.loc/edit/<?=$row['id']?>/update">Edit</a></td>
            <td><a href="http://fwork.loc/del/<?=$row['id']?>">Delete</a></td>
        </tr>
    </tbody>
<?php
    }
?>
</table>


</div>