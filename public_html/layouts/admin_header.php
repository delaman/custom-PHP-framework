<?php
/* Get employee information */
$employee = Employees::find_by_id($session->employeeID);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ty art</title>
        <link href="./stylesheets/BlueSquareShadow/style.css" media="all" rel="stylesheet" type="text/css" >
        <script src="./javascript/functions.js" type="text/javascript"></script>
    </head>
    <body>

        <div id="wrapper">

            <div id="header">
                <h1><a href="#">ty art</a></h1>
                <h2></h2>
            </div><!--header-->

            <div class="menu" id="menu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li>
                        <a href="#" class="menulink">Inventory<!--[if IE 7]><!--></a><!--<![endif]-->
                        <ul>
                            <li><a href="inventory_search.php">Search</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="menulink">Clients<!--[if IE 7]><!--></a><!--<![endif]-->
                        <ul>
                            <li><a href="contact_search.php">Search</a></li>
                            <li><a href="contact_list.php">List</a></li>
                            <li><a href="contact_insert.php">Add</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="menulink">Employees<!--[if IE 7]><!--></a><!--<![endif]-->
                        <ul>
                            <li><a href="employee_list.php">List</a></li>
                            <li><a href="employee_add.php">Add</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="menulink">Users</a>
                        <ul>
                            <li><a href="user_list.php">List</a></li>
                            <li>
                                <a href="#" class="sub">Add</a>
                                <ul>
                                    <li class="topline"><a href="user_add_employee.php">Employee</a></li>
                                    <li><a href="user_add_contact.php">Client</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div style="float: right;"><a href="logout.php">logout</a></div>
                <div  id="login"><a href="profile.php"><?php echo $employee->full_name(); ?></a></div> 
               
            </div><!--menu-->

            <div id="content">

