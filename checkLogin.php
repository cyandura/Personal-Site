<?php

    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];

    $dbUser = 'cody';
    $dbPass = 'cy';

    session_start();
    if ($username == $dbUser && $password == $dbPass)
    {
        $_SESSION['login'] = $username;
        $goto = "Location: myPhoneBook.php";  //This is our landing page
    } else {
        $_SESSION['login'] = '';
	    $ref = getenv("HTTP_REFERER");     //This is the referrer page -- the login form
	    $goto = "Location: " . $ref;
    }	
    header($goto);
    
?>
