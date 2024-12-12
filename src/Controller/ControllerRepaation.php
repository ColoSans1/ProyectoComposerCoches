<?php

require_once '../Service/ServiceReparation.php';

class ControllerReparation {
    private $serviceReparation;

    public function __construct() {
        // Initialize the ServiceReparation class
        $this->serviceReparation = new ServiceReparation();
    }

    // Function to register a new reparation
    public function insertReparation() {
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Retrieve form data
            $id_workshop = $_POST['id_workshop'];
            $name_workshop = $_POST['name_workshop'];
            $register_date = $_POST['register_date'];
            $license_plate = $_POST['license_plate'];
            $photo = $_FILES['photo']; // The uploaded photo

            // Generate watermark text (license plate + unique ID)
            $watermark_text = $license_plate . '-' . uniqid();

            // Handle file upload and add watermark
            $photo_url = $this->uploadPhotoWithWatermark($photo, $watermark_text);

            // Create a new Reparation object
            $reparation = new Reparation($id_workshop, $name_workshop, $register_date, $license_plate, $photo_url, $watermark_text);

            // Call the service to insert the reparation into the database
            $insertSuccess = $this->serviceReparation->insertReparation($reparation);

            // Check if the insertion was successful and pass data to the view
            if ($insertSuccess) {
                // Get the last inserted ID
                $id_reparation = $this->serviceReparation->getLastInsertId(); 
                $this->renderView('insert_success', ['id_reparation' => $id_reparation]);
            } else {
                // If the insertion failed, show an error message
                $this->renderView('insert_error', ['message' => 'Error: Unable to register reparation.']);
            }
        } else {
            // Show the reparation form view if it's a GET request
            $this->renderView('reparation_form');
        }
    }

    // Function to query a reparation by its ID
    public function getReparation() {
        // Check if the request method is GET and the ID is provided
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id_reparation'])) {
            $id_reparation = $_GET['id_reparation'];

            // Call the service to get the reparation from the database
            $reparation = $this->serviceReparation->getReparation($id_reparation);

            // Check if the reparation exists
            if ($reparation) {
                // Depending on the user role, mask the license plate (GDPR)
                if ($_SESSION['role'] == 'client') {
                    $reparation['license_plate'] = '****-***'; // Masked license plate
                }

                // Pass the data to the view for displaying reparation details
                $this->renderView('reparation_details', $reparation);
            } else {
                // If the reparation was not found, show an error message
                $this->renderView('query_error', ['message' => 'Error: Reparation not found.']);
            }
        } else {
            // If no ID is provided, show an error message or redirect
            $this->renderView('query_error', ['message' => 'Error: No reparation ID provided.']);
        }
    }

    // Function to handle photo upload and watermarking
    private function uploadPhotoWithWatermark($photo, $watermark_text) {
        // Define the target directory for the uploaded photos
        $uploadDir = '../uploads/';

        // Get the file extension and generate a new unique filename
        $fileExtension = pathinfo($photo['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid() . '.' . $fileExtension;

        // Define the target file path
        $targetFilePath = $uploadDir . $newFileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($photo['tmp_name'], $targetFilePath)) {
            // Add watermark to the uploaded photo
            $this->addWatermarkToImage($targetFilePath, $watermark_text);
            return $targetFilePath;
        } else {
            return null; // Return null if the upload failed
        }
    }

    // Function to add a watermark to an image
    private function addWatermarkToImage($imagePath, $watermarkText) {
        // Get image dimensions
        list($width, $height) = getimagesize($imagePath);

        // Create image resource from the file
        $image = imagecreatefromjpeg($imagePath);

        // Set font and size for the watermark
        $font = 'arial.ttf'; // Adjust to your system's font path
        $fontSize = 20;
        $color = imagecolorallocate($image, 255, 255, 255); // White color

        // Calculate the position of the watermark (bottom-right corner)
        $textBoundingBox = imagettfbbox($fontSize, 0, $font, $watermarkText);
        $x = $width - $textBoundingBox[2] - 10;
        $y = $height - 10;

        // Add the watermark text to the image
        imagettftext($image, $fontSize, 0, $x, $y, $color, $font, $watermarkText);

        // Save the image with the watermark
        imagejpeg($image, $imagePath);

        // Free up memory
        imagedestroy($image);
    }

    // Function to render a view (you can pass data to the view here)
    private function renderView($viewName, $data = []) {
        extract($data); // Make the data array variables accessible in the view
        include "../views/$viewName.php"; // Include the corresponding view file
    }
}

?>
