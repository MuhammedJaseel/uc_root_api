<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDirectory = 'uploads/'; // Directory where you want to store the uploaded zip file
    $uploadedFile = $_FILES['zip_file'];

    if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
        $fileType = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
        
        // Check if the uploaded file is a zip file
        if ($fileType === 'zip') {
            $targetPath = $uploadDirectory . basename($uploadedFile['name']);
            
            if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
                // The file has been successfully uploaded.
                echo json_encode(array('message' => 'File uploaded successfully'));
                // You can now process or unzip the zip file if needed.
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(array('error' => 'Error uploading file'));
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(array('error' => 'Only ZIP files are allowed'));
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(array('error' => 'File upload error'));
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('error' => 'Only POST requests are allowed'));
}
?>
