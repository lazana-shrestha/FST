<?php 
// Custom function 5: Upload portfolio file
function uploadPortfolioFile($file) {
    try {
        // Check if file was uploaded
        if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            throw new Exception("No file was uploaded!");
        }
        
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("File upload failed with error code: " . $file['error']);
        }
        
        // Check file size (max 2MB)
        $maxSize = 2 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            throw new Exception("File is too large! Maximum size is 2MB.");
        }
        
        // Allowed file types
        $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($fileExt, $allowedTypes)) {
            throw new Exception("Invalid file type! Only PDF, JPG, PNG are allowed.");
        }
        
        // Create uploads directory if it doesn't exist
        if (!is_dir('uploads')) {
            if (!mkdir('uploads', 0755)) {
                throw new Exception("Failed to create uploads directory!");
            }
        }
        
        // Generate unique filename
        $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);
        $newFilename = $safeName . '_' . date('Ymd_His') . '.' . $fileExt;
        $destination = 'uploads/' . $newFilename;
        
        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception("Failed to move uploaded file!");
        }
        
        return $newFilename;
        
    } catch (Exception $e) {
        throw $e;
    }
}

require_once 'includes/header.php';
?>

<h2>Upload Portfolio File</h2>

<?php
// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['portfolio_file'])) {
    try {
        $filename = uploadPortfolioFile($_FILES['portfolio_file']);
        
        echo "<p style='color: green;'>File uploaded successfully!</p>";
        echo "<p>Filename: " . htmlspecialchars($filename) . "</p>";
        echo "<p>File saved in: uploads/" . htmlspecialchars($filename) . "</p>";
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>Upload Error: " . $e->getMessage() . "</p>";
    }
}
?>

<form method="POST" action="" enctype="multipart/form-data">
    <div>
        <label for="portfolio_file">Choose Portfolio File:</label>
        <input type="file" id="portfolio_file" name="portfolio_file" required>
    </div>
    
    <div>
        <p><strong>Requirements:</strong></p>
        <ul>
            <li>Allowed formats: PDF, JPG, PNG</li>
            <li>Maximum size: 2MB</li>
        </ul>
    </div>
    
    <div>
        <button type="submit">Upload File</button>
    </div>
</form>

<p><a href="index.php">Back to Home</a></p>

<?php require_once 'includes/footer.php'; ?>