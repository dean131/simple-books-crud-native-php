<?php
// This file handles all CRUD actions for book data using HTTP Methods.

// Including the configuration file from the parent directory
// Make sure this points to your English config file, e.g., config_en.php
require_once '../config.php';

// Get the request method (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

check_token();

// --- Logic for GET method ---
if ($method == 'GET') {
    // Check if an 'id' parameter exists in the URL
    $id = (int) ($_GET['id'] ?? 0);

    if ($id != 0) {
        // --- ACTION: GET BOOK DETAILS BY ID ---
        $query = "SELECT * FROM books WHERE id = $id";
        $result = mysqli_query($connection, $query);
        $book = mysqli_fetch_assoc($result);

        if ($book) {
            http_response_code(200); // OK
            echo json_encode(['data' => $book]);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['message' => 'Book not found.']);
        }
    } else {
        // --- ACTION: GET ALL BOOKS ---
        $query = "SELECT * FROM books ORDER BY created_at DESC";
        $result = mysqli_query($connection, $query);
        $books = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        http_response_code(200); // OK
        echo json_encode(['data' => $books]);
    }
}

// --- Logic for POST method ---
elseif ($method == 'POST') {
    // --- ACTION: ADD A NEW BOOK ---
    $data = json_decode(file_get_contents("php://input"));
    if (empty($data->title) || empty($data->author)) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => 'Incomplete book data.']);
        exit();
    }

    $title = mysqli_real_escape_string($connection, $data->title);
    $author = mysqli_real_escape_string($connection, $data->author);
    $publisher = mysqli_real_escape_string($connection, $data->publisher ?? '');
    $isbn = mysqli_real_escape_string($connection, $data->isbn ?? '');
    $year = (int) ($data->year ?? 0);
    $picture = mysqli_real_escape_string($connection, $data->picture ?? '');
    $category = mysqli_real_escape_string($connection, $data->category);
    $description = mysqli_real_escape_string($connection, $data->description ?? '');
    
    $query = "INSERT INTO books (title, author, publisher, isbn, year, picture, category, description) 
              VALUES ('$title', '$author', '$publisher', '$isbn', $year, '$picture', '$category', '$description')";
              
    if (mysqli_query($connection, $query)) {
        http_response_code(201); // Created
        echo json_encode(['message' => 'Book added successfully.']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['message' => 'Failed to add book.']);
    }
}

// --- Logic for PUT method ---
elseif ($method == 'PUT') {
    // --- ACTION: UPDATE BOOK DATA ---
    $id = (int) ($_GET['id'] ?? 0);
    $data = json_decode(file_get_contents("php://input"));

    if ($id == 0 || empty($data->title)) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => 'Invalid ID or data for update.']);
        exit();
    }

    $title = mysqli_real_escape_string($connection, $data->title);
    $author = mysqli_real_escape_string($connection, $data->author);
    $publisher = mysqli_real_escape_string($connection, $data->publisher ?? '');
    $isbn = mysqli_real_escape_string($connection, $data->isbn ?? '');
    $year = (int) ($data->year ?? 0);
    $picture = mysqli_real_escape_string($connection, $data->picture ?? '');
    $category = mysqli_real_escape_string($connection, $data->category);
    $description = mysqli_real_escape_string($connection, $data->description ?? '');

    $query = "UPDATE books SET title='$title', author='$author', publisher='$publisher', isbn='$isbn', year=$year, picture='$picture', category='$category', description='$description' WHERE id=$id";
    
    if (mysqli_query($connection, $query)) {
        http_response_code(200); // OK
        echo json_encode(['message' => 'Book data updated successfully.']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['message' => 'Failed to update book data.']);
    }
}

// --- Logic for DELETE method ---
elseif ($method == 'DELETE') {
    // --- ACTION: DELETE A BOOK ---
    $id = (int) ($_GET['id'] ?? 0);
    if ($id == 0) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => 'Invalid book ID.']);
        exit();
    }

    $query = "DELETE FROM books WHERE id=$id";
    
    if (mysqli_query($connection, $query)) {
        if (mysqli_affected_rows($connection) > 0) {
            http_response_code(200); // OK
            echo json_encode(['message' => 'Book deleted successfully.']);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['message' => 'Book not found.']);
        }
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['message' => 'Failed to delete book.']);
    }
}

// --- Condition if no method matches ---
else {
    // If the method is not GET, POST, PUT, or DELETE
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Method not allowed.']);
}

// Always close the connection at the end of the script
mysqli_close($connection);
