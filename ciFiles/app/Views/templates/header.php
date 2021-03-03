<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> | Conferesk</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <?php if(isset($_SESSION["role"])): ?>
    <link rel="stylesheet" href="<?php echo site_url("assets/css/app.min.css"); ?>">
    <?php else: ?>
    <link rel="stylesheet" href="<?php echo site_url("assets/css/public.min.css"); ?>">
    <?php endif; ?>
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <?php if(isset($_SESSION["role"])): ?>
        <header id="app">
            <nav>
                <div class="nav-wrapper">
                    <ul id="slide-out" class="sidenav sidenav-fixed">
                        <li><div class="user-view">                        
                        <a href="#name"><span class="black-text name"><?php echo $_SESSION["first_name"].' '.$_SESSION["last_name"]; ?></span></a>
                        <a href="#email"><span class="black-text email"><?php echo $_SESSION["email"]; ?></span></a>
                        <a href="<?php echo site_url("edit-profile"); ?>"><span class="blue-text email">Edit Profile</span></a>
                        </div></li>
                        <li><a class="waves-effect" href="<?php echo site_url(); ?>">Dashboard</a></li>
                        <?php if($_SESSION["role"]=="admin"): ?>
                        <li><a class="waves-effect" href="<?php echo site_url("notices-mgt"); ?>">Notices</a></li>
                        <li><a class="waves-effect" href="<?php echo site_url("tasks-mgt"); ?>">Tasks</a></li>
                        <li><a class="waves-effect" href="<?php echo site_url("employee-mgt"); ?>">Employees</a></li>
                        <li><a class="waves-effect" href="<?php echo site_url("manage-meetings"); ?>">Manage Meetings</a></li>
                        <?php else: ?>
                        <li><a class="waves-effect" href="<?php echo site_url("my-notices"); ?>">Notices</a></li>
                        <li><a class="waves-effect" href="<?php echo site_url("my-tasks"); ?>">Tasks</a></li>

                        <?php endif; ?>
                    </ul>
                    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    <a href="<?php echo site_url("/"); ?>" class="brand-logo center">Conferesk</a>
                    <ul id="nav-mobile" class="right">
                        <li><a href="<?php echo site_url("logout-exe"); ?>"><i class="material-icons">logout</i></a></li>
                    </ul>
                </div>
            </nav>
        </header>
    <?php endif; ?>