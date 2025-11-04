<?php
session_start();
require_once 'includes/db.php'; // Ensure this file exists and connects to your DB

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $selected_role = $_POST['user_type'] ?? '';

    // In PHP, if $selected_role is empty, treat as 'simple user'.
    if (!$selected_role) { $selected_role = 'user'; }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND status = 'active'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        @font-face {
            font-family: 'Candara Bold';
            src: local('Candara Bold'), local('Candara-Bold'), url('https://fonts.cdnfonts.com/s/15309/Candara.woff') format('woff');
            font-weight: bold;
        }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: url('img/dla_city.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Candara Bold', Candara, Arial, sans-serif;
        }
        .login-form {
            max-width: 400px;
            width: 100%;
            margin: 0 auto;
            padding: 24px 24px 16px 24px;
            border: 1px solid #ccc;
            background: rgba(255,255,255,0.7);
            border-radius: 12px;
            box-shadow: 0 2px 12px #aaa;
        }
        .login-form input[type="email"],
        .login-form input[type="password"],
        .login-form select {
            background: #e0f2ff;
            border: 1px solid #90caf9;
            color: #222;
            border-radius: 6px;
            margin-bottom: 14px;
            padding: 10px;
            width: 100%;
            font-size: 1rem;
            transition: border 0.2s;
        }
        .login-form input[type="email"]:focus,
        .login-form input[type="password"]:focus,
        .login-form select:focus {
            border: 2px solid #2196f3;
            outline: none;
        }
        .login-form button {
            background: linear-gradient(90deg, #42a5f5, #1976d2);
            color: #fff;
            border: none;
            border-radius: 6px;
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
            font-weight: 500;
            margin-top: 8px;
            box-shadow: 0 2px 6px #b3e5fc;
            transition: background 0.2s;
        }
        .login-form button:hover {
            background: linear-gradient(90deg, #1976d2, #42a5f5);
        }
        .login-form .register-link {
            margin-top: 18px;
            text-align: center;
        }
        .login-form .register-link a {
            color: #1976d2;
            text-decoration: underline;
        }
        .policy-footer {
            width: 100%;
            text-align: center;
            font-size: 0.95rem;
            color: #1976d2;
            background: rgba(224,242,255,0.7);
            border-radius: 8px 8px 0 0;
            padding: 10px 16px;
            position: fixed;
            left: 0;
            bottom: 0;
            z-index: 100;
            font-family: 'Candara Bold', Candara, Arial, sans-serif;
        }
        .form-input:focus {
            border: 2px solid #42a5f5 !important;
            outline: none;
        }
        @media (max-width: 600px) {
            .login-form {
                padding: 16px 8px 10px 8px;
            }
            .policy-footer {
                font-size: 0.9rem;
                padding: 8px 4px;
            }
        }
    </style>
</head>
<body>
    <div style="width:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;">
      
        <form method="post" action="login.php" class="login-form">
            <center>
                <img src="img/IRMS.jpg" alt="IRMS Logo" style="width:90px;height:90px;object-fit:cover;border-top-left-radius:50px;border-top-right-radius:50px;border-bottom-left-radius:20px;border-bottom-right-radius:20px;margin-bottom:18px;box-shadow:0 2px 8px #aaa;background:#fff;">
            </center>
            <h2 class="text-center mb-4" style="font-weight:bold;">Login</h2>
            <?php if ($error): ?><p style="color:red;" class="mb-2 text-center"><b><?= $error ?></b></p><?php endif; ?>
            <div class="form-group mb-3">
                <label for="login-email" class="form-label" style="font-weight:bold;">Email</label>
                <input id="login-email" type="email" name="email" placeholder="Email" required class="form-input">
            </div>
            <div class="form-group mb-3">
                <label for="login-password" class="form-label" style="font-weight:bold;">Password</label>
                <input id="login-password" type="password" name="password" placeholder="Password" required class="form-input">
            </div>
            <div class="form-group mb-3">
                <label for="user_type" class="form-label" style="font-weight:bold;">Login as</label>
                <select id="user_type" name="user_type" class="form-input">
                    <option value="">User (default)</option>
                    <option value="investor">Investor</option>
                    <option value="company">Company</option>
                </select>
            </div>
            <button type="submit">Login</button>
            <div class="register-link">
                <span>Don't have an account?</span> <a href="register.php">Sign Up</a>
            </div>
        </form>
    </div>
    <div class="policy-footer">
        By logging in, you agree to our <b>Privacy Policy</b> and <b>Terms of Service</b>. Your information is securely stored and never shared without your consent.
    </div>
</body>
</html> 