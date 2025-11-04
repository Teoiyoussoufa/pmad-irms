<?php
session_start();
require_once 'includes/db.php';

$error = '';
$success = '';

// Company categories, countries, and employee ranges for dropdowns
$categories = ['Technology', 'Finance', 'Healthcare', 'Education', 'Retail', 'Manufacturing', 'Other'];
// Replace countries with all African countries
$countries = [
    'Algeria', 'Angola', 'Benin', 'Botswana', 'Burkina Faso', 'Burundi', 'Cabo Verde', 'Cameroon', 'Central African Republic',
    'Chad', 'Comoros', 'Congo', 'Democratic Republic of the Congo', 'Djibouti', 'Egypt', 'Equatorial Guinea', 'Eritrea',
    'Eswatini', 'Ethiopia', 'Gabon', 'Gambia', 'Ghana', 'Guinea', 'Guinea-Bissau', 'Ivory Coast', 'Kenya', 'Lesotho',
    'Liberia', 'Libya', 'Madagascar', 'Malawi', 'Mali', 'Mauritania', 'Mauritius', 'Morocco', 'Mozambique', 'Namibia',
    'Niger', 'Nigeria', 'Rwanda', 'Sao Tome and Principe', 'Senegal', 'Seychelles', 'Sierra Leone', 'Somalia', 'South Africa',
    'South Sudan', 'Sudan', 'Tanzania', 'Togo', 'Tunisia', 'Uganda', 'Zambia', 'Zimbabwe'
];
$employee_ranges = ['1-10', '11-50', '51-200', '201-500', '501-1000', '1000+'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    $extra1 = trim($_POST['extra1'] ?? ''); // phone or company_name
    $extra2 = trim($_POST['extra2'] ?? ''); // address or description
    $extra3 = trim($_POST['extra3'] ?? ''); // website (for company)

    // New company fields
    $category = $_POST['category'] ?? '';
    $country = $_POST['country'] ?? '';
    $employees_range = $_POST['employees_range'] ?? '';
    $capital = $_POST['capital'] ?? '';
    $logo_path = '';

    // Handle logo upload if company
    if ($role === 'company' && isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $target_dir = 'uploads/logos/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $logo_path = $target_dir . uniqid('logo_', true) . '.' . $ext;
        move_uploaded_file($_FILES['logo']['tmp_name'], $logo_path);
    }

    // Fix validation logic:
    if (!$name || !$email || !$password) {
        $error = "All fields are required.";
    } elseif ($role && !in_array($role, ['investor', 'company'])) {
        $error = "Invalid role selected.";
    } elseif ($role === 'company' && (!$extra1 || !$category || !$country || !$employees_range || !$capital)) {
        $error = "Please fill in all company details.";
    }

    if (!$error) {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // In PHP, if no role is selected, set $role = 'user'.
            if (!$role) { $role = 'user'; }
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, ?, 'active')");
            $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);
            if ($stmt->execute()) {
                $user_id = $stmt->insert_id;
                if ($role === 'investor') {
                    // Insert into investors table
                    $stmt2 = $conn->prepare("INSERT INTO investors (user_id, phone, address) VALUES (?, ?, ?)");
                    $stmt2->bind_param("iss", $user_id, $extra1, $extra2);
                    $stmt2->execute();
                } elseif ($role === 'company') {
                    // Insert into companies table with new fields
                    $stmt2 = $conn->prepare("INSERT INTO companies (user_id, company_name, description, website, category, country, employees_range, capital, logo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt2->bind_param("issssssds", $user_id, $extra1, $extra2, $extra3, $category, $country, $employees_range, $capital, $logo_path);
                    $stmt2->execute();
                }
                header('Location: login.php');
                exit;
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: url('img/dla_city.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .register-form {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            padding: 30px 30px 20px 30px;
            border: 1px solid #ccc;
            background: rgba(255,255,255,0.7);
            border-radius: 12px;
            box-shadow: 0 2px 12px #aaa;
        }
        .register-form input[type="text"],
        .register-form input[type="email"],
        .register-form input[type="password"],
        .register-form input[type="number"],
        .register-form input[type="file"],
        .register-form select,
        .register-form textarea {
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
        .register-form input:focus,
        .register-form select:focus,
        .register-form textarea:focus {
            border: 2px solid #2196f3;
            outline: none;
        }
        .register-form button {
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
        .register-form button:hover {
            background: linear-gradient(90deg, #1976d2, #42a5f5);
        }
        .register-form .login-link {
            margin-top: 18px;
            text-align: center;
        }
        .register-form .login-link a {
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
        }
        @media (max-width: 700px) {
            .register-form {
                padding: 16px 8px 10px 8px;
            }
            .policy-footer {
                font-size: 0.9rem;
                padding: 8px 4px;
            }
        }
        .form-input:focus, .form-select:focus {
            border: 2px solid #42a5f5 !important;
            outline: none;
        }
    </style>
    <script>
    function toggleFields() {
        var roleRadio = document.querySelector('input[name="role"]:checked');
        var role = roleRadio ? roleRadio.value : '';
        var isCompany = role === 'company';
        var isInvestor = role === 'investor';
        // Company fields
        var companyFields = document.querySelectorAll('#company-fields input, #company-fields select, #company-fields textarea');
        companyFields.forEach(function(field) {
            if (isCompany) {
                field.setAttribute('required', 'required');
            } else {
                field.removeAttribute('required');
            }
        });
        // Investor fields
        var investorFields = document.querySelectorAll('#investor-fields input');
        investorFields.forEach(function(field) {
            if (isInvestor) {
                field.setAttribute('required', 'required');
            } else {
                field.removeAttribute('required');
            }
        });
        document.getElementById('investor-fields').style.display = isInvestor ? 'block' : 'none';
        document.getElementById('company-fields').style.display = isCompany ? 'block' : 'none';
    }
    </script>
</head>
<body>
    <div style="width:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;">
       
        <form method="post" action="register.php" enctype="multipart/form-data" class="register-form">
            <center>
                <img src="img/IRMS.jpg" alt="IRMS Logo" style="width:90px;height:90px;object-fit:cover;border-top-left-radius:50px;border-top-right-radius:50px;border-bottom-left-radius:20px;border-bottom-right-radius:20px;margin-bottom:18px;box-shadow:0 2px 8px #aaa;background:#fff;">
            </center>
            <h2 style="text-align:center;font-weight:bold;">Create Your Account</h2>
            <?php if ($error): ?><p style="color:red;"> <?= $error ?> </p><?php endif; ?>
            <?php if ($success): ?><p style="color:green;"> <?= $success ?> </p><?php endif; ?>
            <div class="form-section">
                <label class="form-label" style="font-weight:bold;">Full Name</label>
                <input type="text" name="name" class="form-input" placeholder="Full Name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
            </div>
            <div class="form-section">
                <label class="form-label" style="font-weight:bold;">Email</label>
                <input type="email" name="email" class="form-input" placeholder="Email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            <div class="form-section">
                <label class="form-label" style="font-weight:bold;">Password</label>
                <input type="password" name="password" class="form-input" placeholder="Password" required>
            </div>
            <div class="form-section">
                <label class="form-label" style="font-weight:bold;">Register as</label>
                <label><input type="radio" name="role" value="investor" onchange="toggleFields()" <?= (($_POST['role'] ?? '') == 'investor') ? 'checked' : '' ?>> Investor</label>
                <label><input type="radio" name="role" value="company" onchange="toggleFields()" <?= (($_POST['role'] ?? '') == 'company') ? 'checked' : '' ?>> Company</label>
                <div style="font-size:0.95em;color:#1976d2;margin-top:4px;">If you do not select a type, you will be registered as a regular user.</div>
            </div>
            <div id="investor-fields" style="display:<?= (($_POST['role'] ?? '') == 'investor') ? 'block' : 'none' ?>;">
                <div class="form-section">
                    <label class="form-label" style="font-weight:bold;">Phone</label>
                    <input type="text" name="extra1" class="form-input" placeholder="Phone" value="<?= htmlspecialchars($_POST['extra1'] ?? '') ?>">
                </div>
                <div class="form-section">
                    <label class="form-label" style="font-weight:bold;">Address</label>
                    <input type="text" name="extra2" class="form-input" placeholder="Address" value="<?= htmlspecialchars($_POST['extra2'] ?? '') ?>">
                </div>
            </div>
            <div id="company-fields" style="display:<?= (($_POST['role'] ?? '') == 'company') ? 'block' : 'none' ?>;">
                <div class="form-section">
                    <label class="form-label" style="font-weight:bold;">Company Name</label>
                    <input type="text" name="extra1" class="form-input" placeholder="Company Name" value="<?= htmlspecialchars($_POST['extra1'] ?? '') ?>">
                </div>
                <div class="form-section">
                    <label class="form-label" style="font-weight:bold;">Description</label>
                    <textarea name="extra2" class="form-input" placeholder="Describe your company..." rows="4"><?= htmlspecialchars($_POST['extra2'] ?? '') ?></textarea>
                </div>
                <div class="form-section">
                    <label class="form-label" style="font-weight:bold;">Website</label>
                    <input type="text" name="extra3" class="form-input" placeholder="Website" value="<?= htmlspecialchars($_POST['extra3'] ?? '') ?>">
                </div>
                <div class="form-section">
                    <label class="form-label" style="font-weight:bold;">Category</label>
                    <select name="category" class="form-select">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat ?>" <?= (($_POST['category'] ?? '') == $cat) ? 'selected' : '' ?>><?= $cat ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-section">
                    <label class="form-label" style="font-weight:bold;">Country</label>
                    <select name="country" class="form-select">
                        <option value="">Select Country</option>
                        <?php foreach ($countries as $c): ?>
                            <option value="<?= $c ?>" <?= (($_POST['country'] ?? '') == $c) ? 'selected' : '' ?>><?= $c ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-section">
                    <label class="form-label" style="font-weight:bold;">Employees Range</label>
                    <select name="employees_range" class="form-select">
                        <option value="">Select Range</option>
                        <?php foreach ($employee_ranges as $er): ?>
                            <option value="<?= $er ?>" <?= (($_POST['employees_range'] ?? '') == $er) ? 'selected' : '' ?>><?= $er ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-section">
                    <label class="form-label" style="font-weight:bold;">Capital (FCFA)</label>
                    <input type="number" name="capital" class="form-input" placeholder="Capital in FCFA" min="0" step="0.01" value="<?= htmlspecialchars($_POST['capital'] ?? '') ?>" required>
                </div>
                <div class="form-section">
                    <label class="form-label" style="font-weight:bold;">Company Logo</label>
                    <input type="file" name="logo" class="form-input" accept="image/*">
                </div>
            </div>
            <button type="submit" style="width:100%;padding:12px;font-size:16px;">Register</button>
            <div class="login-link">
                <span>Already have an account?</span> <a href="login.php">Login</a>
            </div>
        </form>
    <div class="policy-footer">
        By registering, you agree to our <b>Privacy Policy</b> and <b>Terms of Service</b>. Your information is securely stored and never shared without your consent.
    </div>
    <script>document.addEventListener('DOMContentLoaded', function(){
        toggleFields();
        var radios = document.querySelectorAll('input[name="role"]');
        radios.forEach(function(radio) {
            radio.addEventListener('change', toggleFields);
        });
    });</script>
</body>
</html> 