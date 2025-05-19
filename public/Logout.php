<?php
//log out the user and redirect to the home age
session_start();
unset($_SESSION);
session_destroy();
session_write_close();
header('Location: index.php');
