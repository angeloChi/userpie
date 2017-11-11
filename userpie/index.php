<?php


require_once("models/config.php");

if(!isUserLoggedIn())
{
 include('landing-page.php');

 } else {

header("Location: login.php");

} ?>
