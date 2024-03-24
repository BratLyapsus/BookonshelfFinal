<?php
//This check does not allow to open page directly if user is not logged in
function pageAccessCheck($requiredRole)
{

// Check if the user has the required role
    if ($_SESSION['userRole'] !== $requiredRole) {
// Redirect the user to the no-access page
        header("Location: ../html/index.php?page=no-access");
        exit(); // Stop further execution
    }
}

/////////////Gets all books data from complex database for listing all books////////////////////////////
function getAllBooksData ()
{
    global $pdo;
    try{
        $sql = "SELECT b.*, l.bookLanguage, g.bookGenre, w.bookWriter 
        FROM books b
        LEFT JOIN languages l ON b.language_id = l.language_id
        LEFT JOIN genres g ON b.genre_id = g.genre_id
        LEFT JOIN writers w ON b.writer_id = w.writer_id";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e)
    {
        "smt went wrong with selecting PHOTO". $e->getMessage();
    }
}
/////////////Gets single bookdata from complex database for book search////////////////////////////
function getSingleBookData ($bookname)
{
    global $pdo;
    try{
        $sql = "SELECT b.*, l.bookLanguage, g.bookGenre, w.bookWriter 
        FROM books b
        LEFT JOIN languages l ON b.language_id = l.language_id
        LEFT JOIN genres g ON b.genre_id = g.genre_id
        LEFT JOIN writers w ON b.writer_id = w.writer_id WHERE bookName LIKE CONCAT('%', :bookname, '%')";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam('bookname', $bookname);
        $stmt->execute();

        return $stmt->fetch();
    }
    catch (PDOException $e)
    {
        "smt went wrong with selecting PHOTO". $e->getMessage();
    }
}

function getSingleBookDataById ($bookid)
{
    global $pdo;
    try{
        /*$sql = "SELECT b.*, l.bookLanguage, g.bookGenre, w.bookWriter
        FROM books b
        LEFT JOIN languages l ON b.language_id = l.language_id
        LEFT JOIN genres g ON b.genre_id = g.genre_id
        LEFT JOIN writers w ON b.writer_id = w.writer_id WHERE bookName LIKE CONCAT('%', :bookname, '%')";*/
        $sql = "SELECT * FROM books WHERE book_id = :bookid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam('bookid', $bookid);
        $stmt->execute();

        return $stmt->fetch();
    }
    catch (PDOException $e)
    {
        "smt went wrong with selecting PHOTO". $e->getMessage();
    }
}

/////////////Gets userdata from complex database for login////////////////////////////
function getUserData ($username)
{
    global $pdo;
    try{
        $sql = "SELECT u.*, r.userRole, a.city, a.streetName, a.postalCode, a.houseNumber
        FROM users u
        LEFT JOIN roles r ON u.userRole_id = r.userRole_id
        LEFT JOIN addresses a ON u.userAddress_id = a.userAddress_id WHERE username = :username";
        //$sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch();
    }
    catch (PDOException $e)
    {
        "smt went wrong with selecting PHOTO". $e->getMessage();
    }
}
function getWriterBook ($bookwriter)
{
    global $pdo;
    try{
        $sql = "SELECT b.*, l.bookLanguage, g.bookGenre, w.bookWriter 
        FROM books b
        LEFT JOIN languages l ON b.language_id = l.language_id
        LEFT JOIN genres g ON b.genre_id = g.genre_id
        LEFT JOIN writers w ON b.writer_id = w.writer_id WHERE bookwriter LIKE CONCAT('%', :bookwriter, '%')";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':bookwriter', $bookwriter);
        $stmt->execute();

        return $stmt->fetch();
    }
    catch (PDOException $e)
    {
        "smt went wrong with selecting PHOTO". $e->getMessage();
    }
}
/////////////Gets single writerdata from complex database for writer search////////////////////////////
function getWriterBooks ($bookwriter)
{
    global $pdo;
    try{
        $sql = "SELECT b.*, l.bookLanguage, g.bookGenre, w.bookWriter 
        FROM books b
        LEFT JOIN languages l ON b.language_id = l.language_id
        LEFT JOIN genres g ON b.genre_id = g.genre_id
        LEFT JOIN writers w ON b.writer_id = w.writer_id WHERE bookwriter LIKE CONCAT('%', :bookwriter, '%')";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':bookwriter', $bookwriter);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e)
    {
        "smt went wrong with selecting PHOTO". $e->getMessage();
    }
}
/////////////adds writerdata to complex database to add writer ////////////////////////////
function addWriter($bookwriter)
{
    global $pdo;
    $sql = "INSERT INTO writers (bookWriter) VALUES (:writer)";
    $stmt_writer = $pdo->prepare($sql);
    $stmt_writer->bindParam(':writer', $bookwriter);
    $stmt_writer->execute();
    return $pdo->lastInsertId();
}
/////////////Gets writer id in writers db from complex database. If it does not exists, adds to db////////////////////////////
function getWriterId($bookwriter)
{
    global $pdo;
    $sql_getWriter = "SELECT writer_id FROM writers WHERE bookWriter = :bookwriter";
    $stmt_getWriter = $pdo->prepare($sql_getWriter);
    $stmt_getWriter->bindParam(':bookwriter', $bookwriter);
    $stmt_getWriter->execute();

    $writerData = $stmt_getWriter->fetch(PDO::FETCH_ASSOC);

    if ($writerData) {
        return $writerData['writer_id']; // Return the writer ID if the writer exists
    } else {
        //return 'Автор не существует'; // Return this if the writer does not exist
        return addWriter($bookwriter);
    }
}
/////////////adds genre to genre db and returns id////////////////////////////
function addGenre($bookgenre)
{
    global $pdo;
    $sql_addgenre = "INSERT INTO genres (bookGenre) VALUES (:genre)";
    $stmt_addgenre = $pdo->prepare($sql_addgenre);
    $stmt_addgenre->bindParam(':genre', $bookgenre);
    $stmt_addgenre->execute();
    return $pdo->lastInsertId();
}
/////////////Gets gener id from genre db. . If it does not exists, adds to db////////////////////////////
function getGenreId($bookgenre)
{
    global $pdo;
    $sql_getgenre = "SELECT genre_id FROM genres WHERE bookGenre = :bookgenre";
    $stmt_getgenre = $pdo->prepare($sql_getgenre);
    $stmt_getgenre->bindParam(':bookgenre', $bookgenre);
    $stmt_getgenre->execute();

    $genreData = $stmt_getgenre->fetch(PDO::FETCH_ASSOC);

    if ($genreData) {
        return $genreData['genre_id']; // Return the writer ID if the writer exists
    } else {
        //return 'Автор не существует'; // Return this if the writer does not exist
        return addGenre($bookgenre);
    }
}
/////////////adds new language to language db////////////////////////////
function addLanguage($booklanguage)
{
    global $pdo;
    $sql_addlanguage = "INSERT INTO languages (bookLanguage) VALUES (:language)";
    $stmt_addlanguage = $pdo->prepare($sql_addlanguage);
    $stmt_addlanguage->bindParam(':language', $booklanguage);
    $stmt_addlanguage->execute();
    return $pdo->lastInsertId();
}
/////////////Gets language id from  language db. . If it does not exists, adds to db////////////////////////////
function getLanguageId($booklanguage)
{
    global $pdo;
    $sql_getlanguage = "SELECT language_id FROM languages WHERE bookLanguage = :booklanguage";
    $stmt_getlanguage = $pdo->prepare($sql_getlanguage);
    $stmt_getlanguage->bindParam(':booklanguage', $booklanguage);
    $stmt_getlanguage->execute();

    $languageData = $stmt_getlanguage->fetch(PDO::FETCH_ASSOC);

    if ($languageData) {
        return $languageData['language_id']; // Return the writer ID if the writer exists
    } else {
        //return 'Автор не существует'; // Return this if the writer does not exist
        return addLanguage($booklanguage);
    }
}
function getUserRoleId($userrole)
{
    global $pdo;
    $sql_getrole = "SELECT userRole_id FROM roles WHERE userRole = :userrole";
    $stmt_getrole = $pdo->prepare($sql_getrole);
    $stmt_getrole->bindParam(':userrole', $userrole);
    $stmt_getrole->execute();
    $userRoleData = $stmt_getrole->fetch(PDO::FETCH_ASSOC);

    if ($userRoleData) {
        return $userRoleData['userRole_id']; // Return the writer ID if the writer exists
    } else {
        //return 'Автор не существует'; // Return this if the writer does not exist
        $_SESSION['Notification'] = 'Такие права доступа не существуют';
        header('Location: ../html/index.php?page=registration');;
    }
}
function addAddress($city, $street, $postalcode, $housenumber)
{
    global $pdo;
    $sql_addaddress = "INSERT INTO addresses (city, streetName, postalCode, houseNumber) VALUES (:city, :street, :postalcode, :housenumber)";
    $stmt_addaddress = $pdo->prepare($sql_addaddress);
    $stmt_addaddress->bindParam(':city', $city);
    $stmt_addaddress->bindParam(':street', $street);
    $stmt_addaddress->bindParam(':postalcode', $postalcode);
    $stmt_addaddress->bindParam(':housenumber', $housenumber);
    $stmt_addaddress->execute();
    return $pdo->lastInsertId();
}
function getAddressId($city, $street, $postalcode, $housenumber)
{
    global $pdo;
    $sql_checkaddress = "SELECT userAddress_id FROM addresses WHERE city = :city AND streetName = :street AND postalCode = :postalcode AND houseNumber = :housenumber";
    $stmt_checkaddress = $pdo->prepare($sql_checkaddress);
    $stmt_checkaddress->bindParam(':city', $city);
    $stmt_checkaddress->bindParam(':street', $street);
    $stmt_checkaddress->bindParam(':postalcode', $postalcode);
    $stmt_checkaddress->bindParam(':housenumber', $housenumber);
    $stmt_checkaddress->execute();

    $addressData = $stmt_checkaddress->fetch(PDO::FETCH_ASSOC);

    if ($addressData) {
        return $addressData['address_id']; // Return the writer ID if the writer exists
    } else {
        //return 'Автор не существует'; // Return this if the writer does not exist
        return addAddress($city, $street, $postalcode, $housenumber);
    }
}
/////////////adds new book to books db////////////////////////////
function addBook($writerId, $genreId, $languageId, $bookName, $bookPhoto, $pageAmount, $bookAmount, $bookAnnotation, $registrationNumber)
{
    global $pdo;
    $sql_addbook = "INSERT INTO books (writer_id, genre_id, language_id, bookName, bookPhoto, pageAmount, bookAmount, bookAnnotation, registrationnumber) 
                    VALUES (:writerId, :genreId, :languageId, :bookName, :bookPhoto, :pageAmount, :bookAmount, :bookAnnotation, :registrationNumber)";
    $stmt_addbook = $pdo->prepare($sql_addbook);
    $stmt_addbook->bindParam(':writerId', $writerId);
    $stmt_addbook->bindParam(':genreId', $genreId);
    $stmt_addbook->bindParam(':languageId', $languageId);
    $stmt_addbook->bindParam(':bookName', $bookName);
    $stmt_addbook->bindParam(':bookPhoto', $bookPhoto);
    $stmt_addbook->bindParam(':pageAmount', $pageAmount);
    $stmt_addbook->bindParam(':bookAmount', $bookAmount);
    $stmt_addbook->bindParam(':bookAnnotation', $bookAnnotation);
    $stmt_addbook->bindParam(':registrationNumber', $registrationNumber);
    $stmt_addbook->execute();
    return $pdo->lastInsertId();

}
////////////adds new book to books db////////////////////////////
function addUser($userRoleId, $userAddressId, $firstname, $lastname, $username, $userpassword, $useremail, $userphoto)
{
    global $pdo;
    $sql_adduser = "INSERT INTO users (userRole_id, UserAddress_id, firstName, lastName, userName, userPassword, userEmail, userPhoto) 
                    VALUES (:roleId, :addressId, :firstname, :lastname, :username, :userpassword, :useremail, :userphoto)";
    $stmt_adduser = $pdo->prepare($sql_adduser);
    $stmt_adduser->bindParam(':roleId', $userRoleId);
    $stmt_adduser->bindParam(':addressId', $userAddressId);
    $stmt_adduser->bindParam(':firstname', $firstname);
    $stmt_adduser->bindParam(':lastname', $lastname);
    $stmt_adduser->bindParam(':username', $username);
    $stmt_adduser->bindParam(':userpassword', $userpassword);
    $stmt_adduser->bindParam(':useremail', $useremail);
    $stmt_adduser->bindParam(':userphoto', $userphoto);
    $stmt_adduser->execute();
    return $pdo->lastInsertId();

}
/////////////Checks for book existance before adding new booki////////////////////////////
function checkBookExistence($bookName)
{
    global $pdo;
    $sql_checkbook = "SELECT book_id FROM books WHERE bookName = :bookName";
    $stmt_checkbook = $pdo->prepare($sql_checkbook);
    $stmt_checkbook->bindParam(':bookName', $bookName);
    $stmt_checkbook->execute();
    $bookData = $stmt_checkbook->fetch(PDO::FETCH_ASSOC);
    return ($bookData !== false); // Return true if the book exists, false otherwise
}
function checkWriterExistence($bookWriter)
{
    global $pdo;
    $sql_checkwriter = "SELECT writer_id FROM writers WHERE bookWriter = :bookWriter";
    $stmt_checkwriter = $pdo->prepare($sql_checkwriter);
    $stmt_checkwriter->bindParam(':bookWriter', $bookWriter);
    $stmt_checkwriter->execute();
    $writerData = $stmt_checkwriter->fetch(PDO::FETCH_ASSOC);
    return ($writerData !== false); // Return true if the writer exists, false otherwise
}
function checkGenreExistence($bookGenre)
{
    global $pdo;
    $sql_checkgenre = "SELECT genre_id FROM genres WHERE bookGenre = :bookGenre";
    $stmt_checkgenre = $pdo->prepare($sql_checkgenre);
    $stmt_checkgenre->bindParam(':bookGenre', $bookGenre);
    $stmt_checkgenre->execute();
    $genreData = $stmt_checkgenre->fetch(PDO::FETCH_ASSOC);
    return ($genreData !== false); // Return true if the genre exists, false otherwise
}
function checkLanguageExistence($bookLanguage)
{
    global $pdo;
    $sql_checklanguage = "SELECT language_id FROM languages WHERE bookLanguage = :bookLanguage";
    $stmt_checklanguage = $pdo->prepare($sql_checklanguage);
    $stmt_checklanguage->bindParam(':bookLanguage', $bookLanguage);
    $stmt_checklanguage->execute();
    $languageData = $stmt_checklanguage->fetch(PDO::FETCH_ASSOC);
    return ($languageData !== false); // Return true if the language exists, false otherwise
}
function checkRegistrationNumberExistence($registrationNumber)
{
    global $pdo;
    $sql_checkregistrationnumber = "SELECT book_id FROM books WHERE registrationNumber = :registrationNumber";
    $stmt_checkregistrationnumber = $pdo->prepare($sql_checkregistrationnumber);
    $stmt_checkregistrationnumber->bindParam(':registrationNumber', $registrationNumber);
    $stmt_checkregistrationnumber->execute();
    $registrationnumberData = $stmt_checkregistrationnumber->fetch(PDO::FETCH_ASSOC);
    return ($registrationnumberData !== false); // Return true if the registrationnumber exists, false otherwise
}
function checkAnnotationExistence($bookAnnotation)
{
    global $pdo;
    $sql_checkannotation= "SELECT book_id FROM books WHERE bookAnnotation = :bookAnnotation";
    $stmt_checkannotation= $pdo->prepare($sql_checkannotation);
    $stmt_checkannotation->bindParam(':bookAnnotation', $bookAnnotation);
    $stmt_checkannotation->execute();
    $annotationData = $stmt_checkannotation->fetch(PDO::FETCH_ASSOC);
    return ($annotationData !== false); // Return true if the registrationnumber exists, false otherwise
}
function checkUserNameExistence($username)
{
    global $pdo;
    $sql_checkusername = "SELECT user_id FROM users WHERE UserName = :username";
    $stmt_checkusername = $pdo->prepare($sql_checkusername);
    $stmt_checkusername->bindParam(':username', $username);
    $stmt_checkusername->execute();
    $usernameData = $stmt_checkusername->fetch(PDO::FETCH_ASSOC);
    return ($usernameData !== false); // Return true if the genre exists, false otherwise
}
function checkEmailExistence($useremail)
{
    global $pdo;
    $sql_checkuseremail = "SELECT user_id FROM users WHERE UserEmail = :useremail";
    $stmt_checkuseremail = $pdo->prepare($sql_checkuseremail);
    $stmt_checkuseremail->bindParam(':useremail', $useremail);
    $stmt_checkuseremail->execute();
    $useremailData = $stmt_checkuseremail->fetch(PDO::FETCH_ASSOC);
    return ($useremailData !== false); // Return true if the genre exists, false otherwise
}

function checkAddresstExistence($city, $street, $postalcode, $housenumber)
{
    global $pdo;
    $sql_checkaddress = "SELECT address_id FROM addresses WHERE city = :city AND streetName = :street AND postalCode = :postalcode AND houseNumber = :housenumber";
    $stmt_checkaddress = $pdo->prepare($sql_checkaddress);
    $stmt_checkaddress->bindParam(':city', $city);
    $stmt_checkaddress->bindParam(':street', $street);
    $stmt_checkaddress->bindParam(':postalcode', $postalcode);
    $stmt_checkaddress->bindParam(':housenumber', $housenumber);
    $stmt_checkaddress->execute();
    $addressData = $stmt_checkaddress->fetch(PDO::FETCH_ASSOC);
    return ($addressData !== false); // Return true if the address exists, false otherwise
}
function isImage($file) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileType = mime_content_type($file);
    return in_array($fileType, $allowedTypes);
}
/////////////check if uploaded bookphoto is an image////////////////////////////
function checkImage()
{
    if (isset($_FILES['bookphoto']) && is_uploaded_file($_FILES['bookphoto']['tmp_name']) && isImage($_FILES['bookphoto']['tmp_name'])) {
        // Read image file
        $bookphoto = file_get_contents($_FILES['bookphoto']['tmp_name']);
    }
}
/////////////resizes the image////////////////////////////
    function resizeImage($imagePath, $width, $height)
    {
        $image = imagecreatefromstring(file_get_contents($imagePath));
        $resizedImage = imagescale($image, $width, $height);
        ob_start();
        imagejpeg($resizedImage);
        $resizedImageData = ob_get_clean();
        return $resizedImageData;
    }
/////////////deletes book from db////////////////////////////
function deleteBook($bookname)
{
    global $pdo;
    try {
        $sql = "DELETE FROM books WHERE bookName = :bookname";
        $stmt_deletebooks = $pdo->prepare($sql);
        $stmt_deletebooks->bindParam(":bookname", $bookname);
        $stmt_deletebooks->execute();

        if ($stmt_deletebooks->rowCount() > 0)
        {


        }
        else
        {
            echo "No matching book found for deletion.";
        }
        //echo $selectedbookid;

    }
    catch (PDOException $e)
    {
        echo "Fout_book: " . $e->getMessage();
    }
}

function editBook($bookId, $writerId, $genreId, $languageId, $bookName, $bookPhoto, $pageAmount, $bookAmount, $bookAnnotation, $registrationNumber)
{
    global $pdo;
    //$sql_addbook = "INSERT INTO books (writer_id, genre_id, language_id, bookName, bookPhoto, pageAmount, bookAmount, bookAnnotation, registrationnumber)
    //                VALUES (:writerId, :genreId, :languageId, :bookName, :bookPhoto, :pageAmount, :bookAmount, :bookAnnotation, :registrationNumber)";
    //$sql = "UPDATE bdtemp SET bookName = :bookname, bookWriter = :bookwriter, bookGenre = :bookgenre, pageAmount = :pageamount, ISBN = :isbn, bookAmount = :bookamount, bookAnnotation = :bookannotation, bookCover = :bookcover WHERE book_id = :book_id";
    $sql_editbook = "UPDATE books SET 
                 writer_id = :writerId, 
                 genre_id = :genreId, 
                 language_id = :languageId, 
                 bookName = :bookName, 
                 bookPhoto = :bookPhoto,
                 pageAmount = :pageAmount, 
                 bookAmount = :bookAmount, 
                 bookAnnotation = :bookAnnotation, 
                 registrationnumber = :registrationNumber
                 WHERE book_id = :bookId ";

    $stmt_editbook  = $pdo->prepare($sql_editbook);
    $stmt_editbook ->bindParam(':bookId', $bookId);
    $stmt_editbook ->bindParam(':writerId', $writerId);
    $stmt_editbook ->bindParam(':genreId', $genreId);
    $stmt_editbook ->bindParam(':languageId', $languageId);
    $stmt_editbook ->bindParam(':bookName', $bookName);
    $stmt_editbook ->bindParam(':bookPhoto', $bookPhoto);
    $stmt_editbook ->bindParam(':pageAmount', $pageAmount);
    $stmt_editbook ->bindParam(':bookAmount', $bookAmount);
    $stmt_editbook ->bindParam(':bookAnnotation', $bookAnnotation);
    $stmt_editbook ->bindParam(':registrationNumber', $registrationNumber);
    $stmt_editbook ->execute();
    return $pdo->lastInsertId();

}
function editBookAmount($bookId, $bookAmount)
{
    global $pdo;
    $sql_editbook = "UPDATE books SET  bookAmount = :bookAmount                
                    WHERE book_id = :bookId ";

    $stmt_editbook  = $pdo->prepare($sql_editbook);
    $stmt_editbook ->bindParam(':bookId', $bookId);
    $stmt_editbook ->bindParam(':bookAmount', $bookAmount);
    $stmt_editbook ->execute();
    return $pdo->lastInsertId();
}
function editEndDateHistory($borrowid, $currentdate)
{
    global $pdo;
    $sql_editbook = "UPDATE bookshistory SET  borrowedEndDate = :currentdate                
                    WHERE borrow_id = :borrowid ";

    $stmt_editdate  = $pdo->prepare($sql_editbook);
    $stmt_editdate ->bindParam(':borrowid', $borrowid);
    $stmt_editdate ->bindParam(':currentdate', $currentdate);
    $stmt_editdate ->execute();
    return $pdo->lastInsertId();
}


function checkBorrowIdByBookIdAndUserId ($bookid, $userid)
{
    try {
        global $pdo;
        $sql = "SELECT borrow_id FROM booksinborrow WHERE book_id = :bookid AND user_id = :userid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam('bookid', $bookid);
        $stmt->bindParam('userid', $userid);
        $stmt->execute();
        $borrowid = $stmt->fetch(PDO::FETCH_ASSOC);
        //return $stmt->fetch();
        return ($borrowid !== false);
    }
    catch (PDOException $e)
    {
        "smt went wrong with selecting PHOTO". $e->getMessage();
    }
}
function getBorrowId($bookid, $userid)
{
    global $pdo;
    $sql = "SELECT borrow_id FROM booksinborrow WHERE book_id = :bookid AND user_id = :userid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam('bookid', $bookid);
    $stmt->bindParam('userid', $userid);
    $stmt->execute();

    $borrowdata = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($borrowdata) {
        return $borrowdata['borrow_id']; // Return the writer ID if the writer exists
    } else {
        //return 'Автор не существует'; // Return this if the writer does not exist
        echo 'книга свободна';
    }
}
function checkReservationIdByBookIdAndUserId ($bookid, $userid)
{
    global $pdo;
    try{
        $sql = "SELECT reserve_id FROM reservedbooks WHERE book_id = :bookid AND user_id = :userid ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam('bookid', $bookid);
        $stmt->bindParam('userid', $userid);
        $stmt->execute();

        return $stmt->fetch();
    }
    catch (PDOException $e)
    {
        "smt went wrong with selecting PHOTO". $e->getMessage();
    }
}
function checkReservationIdByBookId ($bookid)
{
    global $pdo;
    try{
        $sql = "SELECT * FROM reservedbooks WHERE book_id = :bookid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam('bookid', $bookid);
        $stmt->execute();
        $reservedata = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($reservedata) {
            return $reservedata; // Return the writer ID if the writer exists
        }
    }
    catch (PDOException $e)
    {
        "smt went wrong with selecting PHOTO". $e->getMessage();
    }
}
function getReserveId($bookid)
{
    global $pdo;
    $sql = "SELECT reserve_id FROM reservedbooks WHERE book_id = :bookid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam('bookid', $bookid);
    $stmt->execute();
    $reservedata = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($reservedata) {
        $_SESSION['Notification'] = 'Книга вами уже зарезервирована. Вы сможете взять эту книгу как только она вернется в библиотеку';
        header('Location: ../html/index.php?page=user-booksearchresult');
        exit; // Make sure to exit after redirecting
    }
}

function addBookToBorrow($bookid, $userid, $startdate, $enddate)
{
    global $pdo;
    $sql_addbooktoborrow = "INSERT INTO booksinborrow (book_id, user_id, inBorrowStartDate, inBorrowEndDate) 
                    VALUES (:bookid, :userid, :startdate, :enddate)";
    $stmt_addbooktoborrow = $pdo->prepare($sql_addbooktoborrow);
    $stmt_addbooktoborrow->bindParam(':bookid', $bookid);
    $stmt_addbooktoborrow->bindParam(':userid', $userid);
    $stmt_addbooktoborrow->bindParam(':startdate', $startdate);
    $stmt_addbooktoborrow->bindParam(':enddate', $enddate);
    $stmt_addbooktoborrow->execute();
    return $pdo->lastInsertId();

}
function addBookToHistory($borrowid, $bookid, $userid, $startdate, $enddate)
{
    global $pdo;
    $sql_addbooktohistory = "INSERT INTO bookshistory (borrow_id, book_id, user_id, BorrowedStartDate, BorrowedEndDate) 
                    VALUES (:borrowid, :bookid, :userid, :startdate, :enddate)";
    $stmt_addbooktohistory = $pdo->prepare($sql_addbooktohistory);
    $stmt_addbooktohistory->bindParam(':borrowid', $borrowid);
    $stmt_addbooktohistory->bindParam(':bookid', $bookid);
    $stmt_addbooktohistory->bindParam(':userid', $userid);
    $stmt_addbooktohistory->bindParam(':startdate', $startdate);
    $stmt_addbooktohistory->bindParam(':enddate', $enddate);
    $stmt_addbooktohistory->execute();
    return $pdo->lastInsertId();

}
function addBookToReserve($bookid, $userid, $startdate, $enddate)
{
    global $pdo;
    $sql_addbooktoreserve = "INSERT INTO reservedbooks (book_id, user_id, reserveStartDate, reserveEndDate) 
                    VALUES (:bookid, :userid, :startdate, :enddate)";
    $stmt_addbooktoreserve = $pdo->prepare($sql_addbooktoreserve);
    $stmt_addbooktoreserve->bindParam(':bookid', $bookid);
    $stmt_addbooktoreserve->bindParam(':userid', $userid);
    $stmt_addbooktoreserve->bindParam(':startdate', $startdate);
    $stmt_addbooktoreserve->bindParam(':enddate', $enddate);
    $stmt_addbooktoreserve->execute();
    return $pdo->lastInsertId();

}

function getBorrowedBooksData($userid)
{
    global $pdo;
    try {
        $sql = "SELECT b.*, l.bookLanguage, g.bookGenre, w.bookWriter, bb.inBorrowStartDate, inBorrowEndDate
        FROM books b
        LEFT JOIN languages l ON b.language_id = l.language_id
        LEFT JOIN genres g ON b.genre_id = g.genre_id
        LEFT JOIN writers w ON b.writer_id = w.writer_id 
        INNER JOIN booksinborrow  bb ON b.book_id = bb.book_id 
        WHERE bb.user_id = :userid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userid', $userid);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Something went wrong with selecting PHOTO: " . $e->getMessage();
    }
}
function getBorrowUserData($userid)
{
    global $pdo;
    try {
$sql = "SELECT * FROM booksinborrow WHERE user_id = :userid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userid', $userid);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Something went wrong with selecting PHOTO: " . $e->getMessage();
    }
}


function getReservedBooksData($userid)
{
    global $pdo;
    try {
        $sql = "SELECT b.*, l.bookLanguage, g.bookGenre, w.bookWriter
        FROM books b
        LEFT JOIN languages l ON b.language_id = l.language_id
        LEFT JOIN genres g ON b.genre_id = g.genre_id
        LEFT JOIN writers w ON b.writer_id = w.writer_id 
        INNER JOIN reservedbooks  br ON b.book_id = br.book_id 
        WHERE br.user_id = :userid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userid', $userid);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Something went wrong with selecting PHOTO: " . $e->getMessage();
    }
}
function getHistoryBooksData($userid)
{
    global $pdo;
    try {
        $sql = "SELECT b.*, l.bookLanguage, g.bookGenre, w.bookWriter, bh.borrowedStartDate, bh.borrowedEndDate
        FROM books b
        LEFT JOIN languages l ON b.language_id = l.language_id
        LEFT JOIN genres g ON b.genre_id = g.genre_id
        LEFT JOIN writers w ON b.writer_id = w.writer_id 
        INNER JOIN bookshistory bh ON b.book_id = bh.book_id
        WHERE bh.user_id = :userid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userid', $userid);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Something went wrong with selecting PHOTO: " . $e->getMessage();
    }
}
function returnBook($bookid, $userid)
{
    global $pdo;
    try {
        $sql = "DELETE FROM booksinborrow WHERE book_id = :bookid AND user_id = :userid";
        $stmt_deletebooks = $pdo->prepare($sql);
        $stmt_deletebooks->bindParam(":bookid", $bookid);
        $stmt_deletebooks->bindParam(":userid", $userid);
        $stmt_deletebooks->execute();

        if ($stmt_deletebooks->rowCount() > 0)
        {


        }
        else
        {
            echo "No matching book found for deletion.";
        }
        //echo $selectedbookid;

    }
    catch (PDOException $e)
    {
        echo "Fout_book: " . $e->getMessage();
    }
}
function clearReservationByBookIdUserId($bookid, $userid)
{
    global $pdo;
    try {
        $sql = "DELETE FROM reservedbooks WHERE book_id = :bookid AND user_id = :userid";
        $stmt_deletebooks = $pdo->prepare($sql);
        $stmt_deletebooks->bindParam(":bookid", $bookid);
        $stmt_deletebooks->bindParam(":userid", $userid);
        $stmt_deletebooks->execute();


    }
    catch (PDOException $e)
    {
        echo "Fout_book: " . $e->getMessage();
    }
}