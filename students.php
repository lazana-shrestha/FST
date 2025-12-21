<?php 
// Custom function 1: Format name (capitalize first letters)
function formatName($name) {
    return ucwords(strtolower(trim($name)));
}

require_once 'includes/header.php';
?>

<h2>View All Students</h2>

<?php
try {
    // Check if file exists
    if (!file_exists('students.txt')) {
        throw new Exception("No student data found!");
    }
    
    // Read file contents
    $content = file_get_contents('students.txt');
    
    if (empty($content)) {
        echo "<p>No students registered yet.</p>";
    } else {
        // Split by lines
        $lines = explode("\n", trim($content));
        
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>No.</th><th>Name</th><th>Email</th><th>Skills</th></tr>";
        
        $counter = 1;
        foreach ($lines as $line) {
            if (empty($line)) continue;
            
            // Split by pipe delimiter
            $data = explode('|', $line);
            
            if (count($data) >= 3) {
                $name = htmlspecialchars($data[0]);
                $email = htmlspecialchars($data[1]);
                $skills = isset($data[2]) ? explode(', ', $data[2]) : [];
                
                echo "<tr>";
                echo "<td>$counter</td>";
                echo "<td>$name</td>";
                echo "<td>$email</td>";
                echo "<td>";
                
                if (!empty($skills)) {
                    echo "<ul>";
                    foreach ($skills as $skill) {
                        echo "<li>" . htmlspecialchars(trim($skill)) . "</li>";
                    }
                    echo "</ul>";
                }
                
                echo "</td>";
                echo "</tr>";
                
                $counter++;
            }
        }
        
        echo "</table>";
        echo "<p>Total students: " . ($counter - 1) . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<p><a href="index.php">Back to Home</a></p>

<?php require_once 'includes/footer.php'; ?>