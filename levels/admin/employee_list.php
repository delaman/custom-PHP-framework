<?php
$employees = Employees::find_all();
?>
<?php echo $session->message(); ?>
<div class="box">
    <table id="itemNotes" border="0" width="100%" >
        <tr>
            <th width="45%" align="left">First name</th>
            <th width="45%" align="left">Last name</th>
            <th width="10%"></th>

        </tr>
            <?php foreach($employees as $employee) : ?>
        <tr style="color: white;">
            <td><?php echo $employee->name1; ?></td>
            <td><?php echo $employee->name2; ?></td>
            <td><a href="employee_delete.php?employeeID=<?php echo $employee->id?>">Delete</a></td>
        </tr>
            <?php endforeach;?>
    </table>
</div> <!--box-->