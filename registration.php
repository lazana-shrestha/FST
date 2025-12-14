<?php
$name = $email = $password = $confirm_password = "";
$nameErr = $emailErr = $passwordErr = $confirm_passwordErr = "";
$success_message = "";
$error_message = "";

$users_file = "users.json";

function initializeUsersFile($filename) {
    if (!file_exists($filename)) {
        $initial_data = json_encode([]);
        if (file_put_contents($filename, $initial_data) === false) {
            return false;
        }
    }
    return true;
}

function isEmailTaken($email, $users_array) {
    foreach ($users_array as $user) {
        if ($user['email'] === $email) {
            return true;
        }
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = trim($_POST["name"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = trim($_POST["password"]);
        if (strlen($password) < 6) {
            $passwordErr = "Password must be at least 6 characters long";
        } elseif (!preg_match("/[!@#$%^&*(),.?\":{}|<>]/", $password)) {
            $passwordErr = "Password must contain at least one special character";
        }
    }

    if (empty($_POST["confirm_password"])) {
        $confirm_passwordErr = "Confirm password is required";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($confirm_password != $password) {
            $confirm_passwordErr = "Passwords do not match";
        }
    }

    if (empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($confirm_passwordErr)) {
        
        if (!initializeUsersFile($users_file)) {
            $error_message = "Error: Could not create users file.";
        } else {
            $json_data = file_get_contents($users_file);
            
            if ($json_data === false) {
                $error_message = "Error: Could not read users file.";
            } else {
                $users = json_decode($json_data, true);
                
                if ($users === null) {
                    $error_message = "Error: Could not decode users data.";
                } else {
                    if (isEmailTaken($email, $users)) {
                        $emailErr = "This email is already registered.";
                    } else {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        
                        $new_user = [
                            'name' => $name,
                            'email' => $email,
                            'password' => $hashed_password,
                            'registration_date' => date('Y-m-d H:i:s')
                        ];
                        
                        $users[] = $new_user;
                        
                        $updated_data = json_encode($users, JSON_PRETTY_PRINT);
                        
                        if (file_put_contents($users_file, $updated_data) === false) {
                            $error_message = "Error: Could not save user data.";
                        } else {
                            $success_message = "Registration successful! You can now log in.";
                            $name = $email = $password = $confirm_password = "";
                        }
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>User Registration</title>
</head>
<body>
<h2>User Registration System</h2>

<?php if (!empty($success_message)): ?>
    <div style="color: green; background-color: #d4edda; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb;">
        <?php echo $success_message; ?>
    </div>
<?php endif; ?>

<?php if (!empty($error_message)): ?>
    <div style="color: red; background-color: #f8d7da; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb;">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>

<form action="registration.php" method="post">

    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
    <span style="color:red"><?php echo $nameErr; ?></span>
    <br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
    <span style="color:red"><?php echo $emailErr; ?></span>
    <br><br>

    <label>Password:</label><br>
    <input type="password" name="password" value="">
    <span style="color:red"><?php echo $passwordErr; ?></span>
    <br><br>

    <label>Confirm Password:</label><br>
    <input type="password" name="confirm_password" value="">
    <span style="color:red"><?php echo $confirm_passwordErr; ?></span>
    <br><br>

    <button type="submit">Submit</button>
</form>
</body>
</html>