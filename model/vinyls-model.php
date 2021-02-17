<?php
/* This is the Vinyl Records Model */


// Insert a new product to the database
function insertVinyl($vinylBand, $vinylAlbum, $vinylYear, $vinylCondition, $vinylGenre, $imageId, $userId)
{
    // Create a db connection
    $db = dbConnect();
    // The SQL statement
    $sql = 'INSERT INTO public.vinyl (vinylBand, vinylAlbum, vinylYear, vinylCondition, vinylGenre, imageid, userid)
     VALUES (:vinylBand, :vinylAlbum, :vinylYear, :vinylCondition, :vinylGenre, :imageId, :userId)';
    // Create the prepared statement 
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':vinylBand', $vinylBand, PDO::PARAM_STR);
    $stmt->bindValue(':vinylAlbum', $vinylAlbum, PDO::PARAM_STR);
    $stmt->bindValue(':vinylYear', $vinylYear, PDO::PARAM_INT);
    $stmt->bindValue(':vinylCondition', $vinylCondition, PDO::PARAM_STR);
    $stmt->bindValue(':vinylGenre', $vinylGenre, PDO::PARAM_STR);
    $stmt->bindValue(':imageId', $imageId, PDO::PARAM_INT);
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

// Get all vinyls to display in collection
function getVinylData($userId) {

    $db = dbConnect();
    $sql = 'SELECT vinylid, vinylband, vinylalbum, vinylyear, vinylcondition, vinylgenre, imageurl FROM public.vinyl FULL OUTER JOIN public.image on public.vinyl.imageid = public.image.imageid WHERE userid = :userId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $vinylData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // $vinylData = pg_query($db, $stmt);
    // $rows = pg_num_rows($vinylData);


    // Close the database interaction
    $stmt->closeCursor();
    return $vinylData;

}

// Get specific vinyl info
function getVinylInfo($vinylId) {

    $db = dbConnect();
    $sql = 'SELECT vinylid, vinylband, vinylalbum, vinylyear, vinylcondition, vinylgenre, userid, public.vinyl.imageid, imageurl FROM public.vinyl FULL OUTER JOIN public.image on public.vinyl.imageid = public.image.imageid WHERE vinylid = :vinylId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':vinylId', $vinylId, PDO::PARAM_INT);
    $stmt->execute();
    $vinylInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the database interaction
    $stmt->closeCursor();
    return $vinylInfo;

}

// Delete vinyl record
function deleteVInyl($vinylId) {

        // Create a db connection 
        $db = dbConnect();
        // The SQL statement
        $sql = 'DELETE FROM public.vinyl WHERE vinylid = :vinylId';
        // Create the prepared statement 
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':vinylId', $vinylId, PDO::PARAM_INT); 
        // Insert the data
        $stmt->execute();
        // Ask how many rows changed as a result of our insert
        $rowsChanged = $stmt->rowCount();
        // Close the database interaction
        $stmt->closeCursor();
        // Return the indication of success (rows changed)
        return $rowsChanged;

}

// Update vinyl record
function updateVinyl($vinylBand, $vinylAlbum, $vinylYear, $vinylCondition, $vinylGenre, $imageId, $vinylId) {

        // Create a db connection
        $db = dbConnect();
        // The SQL statement
        $sql = 'UPDATE public.vinyl SET vinylalbum = :vinylAlbum, vinylband = :vinylBand, vinylyear = :vinylYear, vinylcondition = :vinylCondition, vinylgenre = :vinylGenre, imageid = :imageId 
        WHERE vinylid = :vinylId';
        // Create the prepared statement using the acme connection
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':vinylBand', $vinylBand, PDO::PARAM_STR);
        $stmt->bindValue(':vinylAlbum', $vinylAlbum, PDO::PARAM_STR);
        $stmt->bindValue(':vinylYear', $vinylYear, PDO::PARAM_INT);
        $stmt->bindValue(':vinylCondition', $vinylCondition, PDO::PARAM_STR);
        $stmt->bindValue(':vinylGenre', $vinylGenre, PDO::PARAM_STR);
        $stmt->bindValue(':imageId', $imageId, PDO::PARAM_INT);
        $stmt->bindValue(':vinylId', $vinylId, PDO::PARAM_INT); 
        // Insert the data
        $stmt->execute();
        // Ask how many rows changed as a result of our insert
        $rowsChanged = $stmt->rowCount();
        // Close the database interaction
        $stmt->closeCursor();
        // Return the indication of success (rows changed)
        return $rowsChanged;
}

// Insert image
function insertImage($imageURL) {

        // Create a db connection
        $db = dbConnect();
        // The SQL statement
        $sql = 'INSERT INTO public.image (imageurl) VALUES (:imageURL)';
        // Create the prepared statement 
        $stmt = $db->prepare($sql);
    
        $stmt->bindValue(':imageURL', $imageURL, PDO::PARAM_STR);
      
        // Insert the data
        $stmt->execute();
        // Ask how many rows changed as a result of our insert
        $rowsChanged = $stmt->rowCount();
        // Close the database interaction
        $stmt->closeCursor();
        // Return the indication of success (rows changed)
        return $rowsChanged;

}

// Get last image id
function getLastImageId() {

    $db = dbConnect();
    $sql = 'SELECT imageid FROM public.image WHERE created = (SELECT MAX (created) FROM public.image LIMIT 1)';

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $imageId = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the database interaction
    $stmt->closeCursor();
    return $imageId;

}

function getImage($imageId) {

    $db = dbConnect();
    $sql = 'SELECT * FROM public.image WHERE imageid = :imageId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':imageId', $imageId, PDO::PARAM_INT);
    $stmt->execute();
    $imageInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the database interaction
    $stmt->closeCursor();
    return $imageInfo;


}

// Update image
function updateImage($imageId, $imageURL) {

    // Create a db connection
    $db = dbConnect();
    // The SQL statement
    $sql = 'UPDATE public.image SET imageurl = :imageURL WHERE imageid = :imageId';
    // Create the prepared statement 
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':imageId', $imageId, PDO::PARAM_INT);
    $stmt->bindValue(':imageURL', $imageURL, PDO::PARAM_STR);
  
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;

}