<?php
session_start();
include 'config/database.php';
include 'assets/loader.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $profile_picture = null;

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/profile_pictures/';
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        $file_info = $_FILES['profile_picture'];
        $file_type = $file_info['type'];
        $file_size = $file_info['size'];
        $file_tmp = $file_info['tmp_name'];
        
        // Validate file type
        if (!in_array($file_type, $allowed_types)) {
            $error = "Invalid file type. Please upload a JPEG, PNG, or GIF image.";
        }
        // Validate file size
        elseif ($file_size > $max_size) {
            $error = "File size too large. Please upload an image smaller than 5MB.";
        }
        // Validate that it's actually an image
        elseif (!getimagesize($file_tmp)) {
            $error = "Invalid image file. Please upload a valid image.";
        }
        else {
            // Generate unique filename
            $file_extension = pathinfo($file_info['name'], PATHINFO_EXTENSION);
            $unique_filename = uniqid('profile_', true) . '.' . $file_extension;
            $target_path = $upload_dir . $unique_filename;
            
            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            // Move uploaded file
            if (move_uploaded_file($file_tmp, $target_path)) {
                $profile_picture = $target_path;
            } else {
                $error = "Failed to upload profile picture. Please try again.";
            }
        }
    }

    // Only proceed with registration if no upload errors
    if (!isset($error)) {
        try {
            // First check if email already exists
            $check = $pdo->prepare("SELECT email FROM users WHERE email = ?");
            $check->execute([$email]);
            
            if ($check->rowCount() > 0) {
                $error = "This email is already registered. Please try logging in.";
            } else {
                // If email doesn't exist, create new user with profile picture
                $stmt = $pdo->prepare("INSERT INTO users (fullname, email, profile_picture, password, role, status, created_at, updated_at) VALUES (?, ?, ?, ?, 'Student', 'Active', NOW(), NOW())");
                $stmt->execute([$fullname, $email, $profile_picture, $password]);
                
                // Set success message in session
                $_SESSION['success'] = "Registration successful! Please login.";
                header("Location: login.php");
                exit();
            }
        } catch (PDOException $e) {
            // If database error and file was uploaded, clean up
            if ($profile_picture && file_exists($profile_picture)) {
                unlink($profile_picture);
            }
            $error = "Registration failed: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - BeThePro's</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="css/signup.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="brand-header">
            <div class="brand-logo">BeThePro's</div>
            <div class="brand-tagline">Master Your Interview Skills</div>
        </div>
        <h2>Create Your Account</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="fullname" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Profile Picture (Optional)</label>
                <div class="file-upload-container">
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="file-input">
                    <label for="profile_picture" class="file-upload-label">
                        <span class="upload-icon">📷</span>
                        <span class="upload-text">Choose Profile Picture</span>
                    </label>
                    <div class="file-info">
                        <small>Accepted formats: JPEG, PNG, GIF (Max size: 5MB)</small>
                    </div>
                    <div class="image-preview" id="imagePreview"></div>
                </div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Sign Up</button>
        </form>
        <div class="footer">
            Already have an account? <a href="login.php">Log in</a>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('profile_picture');
    const fileLabel = document.querySelector('.file-upload-label');
    const uploadText = document.querySelector('.upload-text');
    const imagePreview = document.getElementById('imagePreview');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Update label text
            uploadText.textContent = file.name;
            fileLabel.classList.add('file-selected');
            
            // Show image preview
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" style="
                        width: 80px; 
                        height: 80px; 
                        border-radius: 50%; 
                        object-fit: cover; 
                        border: 3px solid #667eea;
                        margin-top: 10px;
                    ">
                `;
            };
            reader.readAsDataURL(file);
        } else {
            // Reset if no file selected
            uploadText.textContent = 'Choose Profile Picture';
            fileLabel.classList.remove('file-selected');
            imagePreview.innerHTML = '';
        }
    });
});
</script>

<style>
.file-upload-container {
    margin-top: 5px;
}

.file-input {
    display: none;
}

.file-upload-label {
    display: inline-block;
    padding: 12px 20px;
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    border: 2px dashed #cbd5e0;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    width: 100%;
    box-sizing: border-box;
}

.file-upload-label:hover {
    background: linear-gradient(135deg, #edf2f7, #cbd5e0);
    border-color: #667eea;
}

.file-upload-label.file-selected {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-color: #667eea;
}

.upload-icon {
    font-size: 1.2rem;
    margin-right: 8px;
}

.upload-text {
    font-weight: 500;
}

.file-info {
    margin-top: 5px;
    text-align: center;
}

.file-info small {
    color: #718096;
    font-size: 0.875rem;
}

.image-preview {
    text-align: center;
}

/* Update existing styles */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #2d3748;
    font-weight: 500;
}
</style>
</body>
</html>
