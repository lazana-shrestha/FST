<?php 
// Custom function 1: Format name (capitalize first letters)
function formatName($name) {
    return ucwords(strtolower(trim($name)));
}

// Custom function 2: Validate email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Custom function 3: Clean skills string
function cleanSkills($string) {
    $string = trim($string);
    $string = preg_replace('/\s*,\s*/', ',', $string);
    return $string;
}

// Custom function 4: Save student to file
function saveStudent($name, $email, $skillsArray) {
    try {
        $file = fopen("students.txt", "a");
        if (!$file) {
            throw new Exception("Unable to open file for writing!");
        }
        
        $skillsString = implode(", ", $skillsArray);
        $data = "$name|$email|$skillsString\n";
        
        if (fwrite($file, $data) === FALSE) {
            throw new Exception("Unable to write to file!");
        }
        
        fclose($file);
        return true;
        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

require_once 'includes/header.php';
?>

<h2>Add Student Information</h2>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get form data
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $skills = $_POST['skills'] ?? '';
        
        // Validate inputs
        if (empty($name) || empty($email) || empty($skills)) {
            throw new Exception("All fields are required!");
        }
        
        // Use custom functions
        $formattedName = formatName($name);
        
        if (!validateEmail($email)) {
            throw new Exception("Invalid email address!");
        }
        
        $cleanedSkills = cleanSkills($skills);
        
        // Convert skills string to array
        $skillsArray = explode(',', $cleanedSkills);
        $skillsArray = array_map('trim', $skillsArray);
        
        // Save student data
        if (saveStudent($formattedName, $email, $skillsArray)) {
            echo "<p style='color: green;'>Student information saved successfully!</p>";
            $name = $email = $skills = '';
        } else {
            throw new Exception("Failed to save student information!");
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<form method="POST" action="">
    <div>
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required 
               value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
    </div>
    
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required
               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
    </div>
    
    <div>
        <label for="skills">Skills:</label>
        <input type="text" id="skills" name="skills" required
               value="<?php echo htmlspecialchars($_POST['skills'] ?? ''); ?>">
    </div>
    
    <div>
        <button type="submit">Add Student</button>
        <button type="reset">Reset</button>
    </div>
</form>

<p><a href="index.php">Back to Home</a></p>

<?php require_once 'includes/footer.php'; ?>