<?php
/* This is the Accounts Model */

// Get client data based on an email address
function getUser($userEmail){

    $db = dbConnect();
    $sql = 'SELECT username, useremail, userid, userpassword FROM public.user WHERE useremail = :email';
    // $userData = pg_prepare($db, 'query', $sql);
    // $userData = pg_execute($db, 'query', array($userEmail));
    
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $userEmail, PDO::PARAM_STR);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    // Close the database interaction
    $stmt->closeCursor();
    return $userData;
}

// This function checks if the email used for registration already exists db
function checkExistingEmail($userEmail){

    $db = dbConnect();
    $sql = 'SELECT useremail FROM public.user WHERE useremail = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $userEmail, PDO::PARAM_STR);
    $stmt->execute();
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
    // Close the database interaction
    $stmt->closeCursor();
    if (empty($matchEmail)) {
        return 0;
        // This was for testing: echo 'Nothing found';
        //exit;
    } else {
        return 1;
        // This was for testing: echo 'Match found';
        //exit;
    }
}

// Insert site visitor data to the database
function regClient($userName, $userEmail, $checkPassword){
    
    $db = dbConnect();
    // The SQL statement
    $sql = 'INSERT INTO public.user (username,useremail,userpassword)
     VALUES (:username, :useremail, :userpassword)';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':username', $userName, PDO::PARAM_STR);
    $stmt->bindValue(':useremail', $userEmail, PDO::PARAM_STR);
    $stmt->bindValue(':userpassword', $checkPassword, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

// Update client info in the database
function updateAccount($userName, $userEmail, $userId){
   
    $db = dbConnect();
    // The SQL statement
    $sql = 'UPDATE public.user SET username = :userName, useremail = :userEmail
    WHERE userid = :userId';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);
    // The next lines replace the placeholders in the SQL statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':userName', $userName, PDO::PARAM_STR);
    $stmt->bindValue(':userEmail', $userEmail, PDO::PARAM_STR);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
 
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

// Get updated client account info
function getAccountInfo($userId){

    $db = dbConnect(); 
    $sql = 'SELECT * FROM public.user WHERE userid = :userId';
    $stmt = $db->prepare($sql);
    // binValue is like an integer and the PDO: flag specificies it as an INT
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    // An associative array is being built with table field names used as "name" of element in array
    $userAccountInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $userAccountInfo;
   }


// Update account password in the database
function updatePassword($userPassword, $userId)
{
    // Create a connection object using the acme connection function
    $db = dbConnect();
    // The SQL statement
    $sql = 'UPDATE public.user SET userpassword = :userPassword
    WHERE userid = :userId';
    // Create the prepared statement
    $stmt = $db->prepare($sql);
    // The next lines replace the placeholders in the SQL statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':userPassword', $userPassword, PDO::PARAM_STR);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
 
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}