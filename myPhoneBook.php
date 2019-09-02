<!DOCTYPE html>
<html>

<head>
    <title>Phonebook Entry</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</head>

<style>
    body h2{
        margin-top: 1%;
    }
    h2{
        padding-left: 1%;
    }
    .myform{
        margin: 1% auto;
        width: 95vw;
    }
    fieldset{
        border-radius: 5px;
        background-color: #f2f2f2;
        width: 100%;
        
    }
    .form{
        width: 95%;
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
        
    }

    .form *{
        width: 48%;
    }

    @media screen and (max-width: 550px){
        .form *{
            width: 100%;
        }
    }
    table{
        width: 95vw;
        margin: auto auto;
    }
    table,
    tr,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    td{
        padding: 1%;
    }

    thead>tr,
    thead~td {
        background-color: aliceblue;
        font-weight: bold;
        border-collapse: collapse;
    }

</style>

<body>
    <div include="header.html"></div>
    <h2 class="secureBlock">Phone Entry</h2>
    <form class="myform" action="myPhoneBook.php" method="post">
        <fieldset>
            <div class="form">

            
                
                <label for="key">First Name</label>
                <input type="text" id="key" name="key" placeholder="First Name" size="10">

                <label for="role">Middle Inital</label>
                <input type="text" id="minit" placeholder="Middle Initial" name="minit" size="10">

                <label for="role">Last Name</label>
                <input type="text" id="lname" placeholder="Last Name" name="lname" size="10">

                <label for="phone">Phone</label>
                <input id="phone" type="text" placeholder="Enter Phone" name="phone" size="10">

                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Enter Email" name="email" size="10">

                <label for="role">Role</label>
                <input type="text" id="role" placeholder="Relationship" name="role" size="10">

                <label for="role">Topics Discussed</label>
                <input type="text" id="topics" placeholder="Topics Discussed" name="topics" size="10">

                <label for="role">Last Contact Date</label>
                <input type="text" id="ldate" placeholder="Last Contact Date" name="ldate" size="10">

                <button name="add" type="submit">Store</button>
                <button type="reset">Clear</button>
            </div>
        </fieldset>
    </form>


    <?php
        session_start();
    
        $dbFile = '/SECS/home/c/cyandura/secure/phoneBook.json';
    
        if (!isset($_SESSION['login']) || $_SESSION['login'] == '')
        {
            echo $_SESSION['login'];
            header ("Location: secure.html");
        } 

        $newKey = $_POST['key'];
        $minit = $_POST['minit'];
        $lname = $_POST['lname'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $topics = $_POST['topics'];
        $ldate = $_POST['ldate'];
        
    ?>


    <h2>My Secure Phone Book</h2>

    <?php
        $json = file_get_contents($dbFile);
        $depth = 4;
        $phBook = json_decode($json, true, $depth);
        
        if (isset($_POST['add']) && isset($_POST['key']))
        {
            //echo "Record Add with Key Set <br>";
            if(array_key_exists($newKey, $phBook))
            {
                $entry = $phBook[$newKey];
            
                //Update only values that are non-empty
            
                if ($minit != '')  {$entry[0] = $minit;}
                if ($lname != '')  {$entry[1] = $lname;}
                if ($phone != '')  {$entry[2] = $phone;}
                if ($email != '')  {$entry[3] = $email;}
                if ($role  != '')  {$entry[4] = $role;}
                if ($topics != '')  {$entry[5] = $topics;}
                if ($ldate  != '')  {$entry[6] = $ldate;}
            
                $phBook[$newKey] = $entry;
            }
            else
            {
                $phBook[$newKey] = Array ($minit, $lname, $phone, $email, $role, $topics, $ldate);
            }
        
        }
    
        
        if (isset($_POST['del']))
        {
            $delKey = $_POST['delRec'];
            unset($phBook[$delKey]);
        }
    
        ksort($phBook);
        echo "<table>";
        echo "<thead><tr><td>First Name</td> <td>Middle Initial</td> <td>Last Name</td> <td>Phone Number</td> 
            <td>Email</td>  <td>Role</td> <td>Topics Last Discussed</td> <td>Last Contact Date</td> <td>Delete?</td></tr></thead>";
        
        echo "<tbody>";
        foreach ($phBook as $key => $value)
        {
            echo "<tr><td> $key </td> <td>$value[0]</td> <td>$value[1]</td> <td>$value[2]</td> <td>$value[3]</td> 
                <td>$value[4]</td> <td>$value[5]</td> <td>$value[6]</td> <td><form action='myPhoneBook.php' 
                method='post'><input type='hidden' name='delRec' value=$key></input><button name='del' 
                type='submit'>Delete</button></form></td>
                </tr>";
        }
        echo "</tbody>";
        echo "</table>";
        
        echo "</tbody>";
        echo "</table>";
    
    
        // Write Array to a JSON file
        $fp = fopen($dbFile, 'w');
        fwrite($fp, json_encode($phBook));
        fclose($fp);
    
    
    ?>


    <div include="footer.html"></div>
</body>

</html>
