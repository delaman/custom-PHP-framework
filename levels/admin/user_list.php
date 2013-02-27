<?php
$users = User::find_all_by_employees();
$usersContacts = User::find_all_by_contacts();
?>
<?php echo $session->message(); ?>

<h2>Employee Users</h2>
<div class="box">
    <table border="0" width="100%" cellpadding="10">
        <tr>
            <th>Username</th>
            <th ></th>
        </tr>
        <?php foreach($users as $user) : ?>
        <tr style="color: white;">
            <td align="center"><?php echo $user->username; ?></td>
            <td><a href="user_delete.php?userID=<?php echo $user->id; ?>">Delete</a></td>
        </tr>
        <?php endforeach;?>
    </table>
</div> <!--box-->


<h2>Client Users</h2>
<div class="box">
    <table border="0" width="100%" cellpadding="10">
        <tr>
            <th >Username</th>
            <th ></th>
        </tr>
        <?php foreach($usersContacts as $user) : ?>
        <tr style="color: white;">
            <td align="center"><?php echo $user->username; ?></td>
            <td><a href="user_delete.php?userID=<?php echo $user->id; ?>">Delete</a></td>
        </tr>
        <?php endforeach;?>
    </table>
</div> <!--box-->