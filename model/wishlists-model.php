<?php
/* This is the Wishlist Model */

// Get all vinyls to display in wishlist
function getWishlistData($userId)
{

    $db = dbConnect();
    $sql = 'SELECT * FROM public.wishlist WHERE userid = :userId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $wishlistData = $stmt->fetchALL(PDO::FETCH_ASSOC);

    // Close the database interaction
    $stmt->closeCursor();
    return $wishlistData;
}

// Add new item to wishlist
function insertWlItem($wlVinylBand, $wlVinylAlbum, $wlVinylPrice, $wlVinylNotes, $wlVinylImage, $userId)
{

    // Create a db connection
    $db = dbConnect();
    // The SQL statement
    $sql = 'INSERT INTO public.wishlist (wlvinylband, wlvinylalbum, wlvinylprice, wlvinylnotes, userid)
         VALUES (:wlVinylBand, :wlVinylAlbum, :wlVinylPrice, :wlVinylNotes, :userId)';
    // Create the prepared statement 
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':wlVinylBand', $wlVinylBand, PDO::PARAM_STR);
    $stmt->bindValue(':wlVinylAlbum', $wlVinylAlbum, PDO::PARAM_STR);
    $stmt->bindValue(':wlVinylPrice', $wlVinylPrice, PDO::PARAM_INT);
    $stmt->bindValue(':wlVinylNotes', $wlVinylNotes, PDO::PARAM_STR);
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

// Get specific wishlist item info
function getWishlistInfo($wishlistId) {

    $db = dbConnect();
    $sql = 'SELECT * FROM public.wishlist WHERE wishlistid = :wishlistId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':wishlistId', $wishlistId, PDO::PARAM_INT);
    $stmt->execute();
    $wishlistInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the database interaction
    $stmt->closeCursor();
    return $wishlistInfo;

}

// Delete wishlist item
function deleteWishlistItem($wishlistId) {

    // Create a db connection 
    $db = dbConnect();
    // The SQL statement
    $sql = 'DELETE FROM public.wishlist WHERE wishlistid = :wishlistId';
    // Create the prepared statement 
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':wishlistId', $wishlistId, PDO::PARAM_INT); 
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;

}

// Update wishlist item
function updateWlItem($wlVinylBand, $wlVinylAlbum, $wlVinylPrice, $wlVinylNotes, $wlVinylImage, $wishlistId) {

    // Create a db connection
    $db = dbConnect();
    // The SQL statement
    $sql = 'UPDATE public.wishlist SET wlvinylalbum = :wlVinylAlbum, wlvinylband = :wlVinylBand, wlvinylprice = :wlVinylPrice, wlvinylnotes = :wlVinylNotes 
    WHERE wishlistid = :wishlistId';
    // Create the prepared statement using the acme connection
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':wlVinylAlbum', $wlVinylAlbum, PDO::PARAM_STR);
    $stmt->bindValue(':wlVinylBand',  $wlVinylBand, PDO::PARAM_STR);
    $stmt->bindValue(':wlVinylPrice', $wlVinylPrice, PDO::PARAM_INT);
    $stmt->bindValue(':wlVinylNotes', $wlVinylNotes, PDO::PARAM_STR);
    // $stmt->bindValue(':wlVinylImage', $wlVinylImage, PDO::PARAM_INT);
    $stmt->bindValue(':wishlistId', $wishlistId, PDO::PARAM_INT); 
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}
