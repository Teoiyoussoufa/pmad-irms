<?php
session_start();
require_once 'includes/db.php';

// Fetch companies for dropdown
$companies = [];
$sql = "SELECT company_name FROM companies ORDER BY company_name ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $companies[] = $row['company_name'];
    }
}

$contact_success = '';
$contact_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if (!$name || !$email || !$company || !$message) {
        $contact_error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $contact_error = 'Invalid email address.';
    } else {
        $stmt = $conn->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $company, $message);
        if ($stmt->execute()) {
            $contact_success = 'Your message has been sent to ' . htmlspecialchars($company) . '. The company will contact you soon.';
        } else {
            $contact_error = 'Failed to send message. Please try again.';
        }
        $stmt->close();
    }
}
// Pre-select company if set in URL
$preselect_company = isset($_GET['company']) ? $_GET['company'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Contact a Company - PMAD-IRMS</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .contact-form {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px #b3e5fc;
            padding: 32px 24px 24px 24px;
        }
        .contact-form label { font-weight: bold; }
        .contact-form select, .contact-form input, .contact-form textarea {
            margin-bottom: 16px;
            border-radius: 6px;
            border: 1px solid #90caf9;
            background: #e0f2ff;
            padding: 10px;
        }
        .contact-form button {
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
        .contact-form button:hover {
            background: linear-gradient(90deg, #1976d2, #42a5f5);
        }
        .modal-success {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.4);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-success-content {
            background: #fff;
            border-radius: 16px;
            padding: 32px 24px;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 8px 32px #1976d2aa;
            animation: zoomInModal 0.3s cubic-bezier(.4,2,.6,1) forwards;
        }
        .modal-success-content .close-modal {
            position: absolute;
            top: 12px; right: 18px;
            font-size: 2rem;
            color: #1976d2;
            cursor: pointer;
            font-weight: bold;
        }
        @keyframes zoomInModal {
            0% { transform: scale(0.7); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="contact-form">
            <h2 class="mb-4 text-center">Contact a Company</h2>
            <?php if ($contact_error): ?>
                <div class="alert alert-danger"> <?= $contact_error ?> </div>
            <?php endif; ?>
            <form method="post" action="contact.php">
                <label for="name">Your Name</label>
                <input type="text" name="name" id="name" class="form-control" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                <label for="email">Your Email</label>
                <input type="email" name="email" id="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                <label for="company">Select Company</label>
                <select name="company" id="company" class="form-control" required>
                    <option value="">-- Select Company --</option>
                    <?php foreach ($companies as $c): ?>
                        <option value="<?= htmlspecialchars($c) ?>" <?= ($preselect_company == $c || ($_POST['company'] ?? '') == $c) ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="message">Message</label>
                <textarea name="message" id="message" class="form-control" rows="5" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                <button type="submit" name="contact_submit">Send</button>
            </form>
        </div>
    </div>
    <?php if ($contact_success): ?>
    <div class="modal-success" id="modalSuccess">
        <div class="modal-success-content position-relative">
            <span class="close-modal" onclick="document.getElementById('modalSuccess').style.display='none'">&times;</span>
            <h4>Message Sent!</h4>
            <p><?= $contact_success ?></p>
            <button class="btn btn-primary mt-3" onclick="document.getElementById('modalSuccess').style.display='none'">OK</button>
        </div>
    </div>
    <script>setTimeout(function(){ document.getElementById('modalSuccess').style.display='none'; }, 6000);</script>
    <?php endif; ?>
</body>
</html>