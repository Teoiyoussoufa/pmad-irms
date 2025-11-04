<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
require_once 'includes/db.php';

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_company'])) {
    $company_id = intval($_POST['company_id']);
    $company_name = trim($_POST['company_name']);
    $description = trim($_POST['description']);
    $website = trim($_POST['website']);
    $category = trim($_POST['category']);
    $country = trim($_POST['country']);
    $employees_range = trim($_POST['employees_range']);
    $capital = floatval($_POST['capital']);
    // Only allow update if the user owns the company
    $stmt = $conn->prepare("SELECT user_id FROM companies WHERE id = ?");
    $stmt->bind_param("i", $company_id);
    $stmt->execute();
    $stmt->bind_result($owner_id);
    $stmt->fetch();
    $stmt->close();
    if ($owner_id == $_SESSION['user_id']) {
        $stmt = $conn->prepare("UPDATE companies SET company_name=?, description=?, website=?, category=?, country=?, employees_range=?, capital=? WHERE id=?");
        $stmt->bind_param("ssssssdi", $company_name, $description, $website, $category, $country, $employees_range, $capital, $company_id);
        $stmt->execute();
        $stmt->close();
    }
}

$companies = [];
$sql = "SELECT c.*, u.email FROM companies c JOIN users u ON c.user_id = u.id ORDER BY c.company_name ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $companies[] = $row;
    }
}
// For dropdowns
$categories = ['Technology', 'Finance', 'Healthcare', 'Education', 'Retail', 'Manufacturing', 'Other'];
$countries = [
    'Algeria', 'Angola', 'Benin', 'Botswana', 'Burkina Faso', 'Burundi', 'Cabo Verde', 'Cameroon', 'Central African Republic',
    'Chad', 'Comoros', 'Congo', 'Democratic Republic of the Congo', 'Djibouti', 'Egypt', 'Equatorial Guinea', 'Eritrea',
    'Eswatini', 'Ethiopia', 'Gabon', 'Gambia', 'Ghana', 'Guinea', 'Guinea-Bissau', 'Ivory Coast', 'Kenya', 'Lesotho',
    'Liberia', 'Libya', 'Madagascar', 'Malawi', 'Mali', 'Mauritania', 'Mauritius', 'Morocco', 'Mozambique', 'Namibia',
    'Niger', 'Nigeria', 'Rwanda', 'Sao Tome and Principe', 'Senegal', 'Seychelles', 'Sierra Leone', 'Somalia', 'South Africa',
    'South Sudan', 'Sudan', 'Tanzania', 'Togo', 'Tunisia', 'Uganda', 'Zambia', 'Zimbabwe'
];
$employee_ranges = ['1-10', '11-50', '51-200', '201-500', '501-1000', '1000+'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registered Companies</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #e0f7fa 0%, #f6f8fa 100%);
        }
        .company-card {
            box-shadow: 0 2px 8px #eee;
            border-radius: 16px;
            margin-bottom: 32px;
            background: #fff;
            border-top: 5px solid #42a5f5;
            transition: box-shadow 0.2s, transform 0.2s;
            position: relative;
        }
        .company-card:hover {
            box-shadow: 0 8px 24px #b3e5fc;
            transform: translateY(-4px) scale(1.02);
        }
        .company-logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
            border-radius: 12px;
            background: #f8f8f8;
            border: 2px solid #42a5f5;
        }
        .company-info {
            padding: 20px 10px 20px 10px;
        }
        .company-title {
            font-size: 1.4rem;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 2px;
        }
        .company-category {
            font-size: 1.05rem;
            color: #42a5f5;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .company-meta {
            font-size: 0.98rem;
            color: #555;
            margin-bottom: 6px;
        }
        .company-description {
            margin-top: 10px;
            color: #333;
            font-size: 1.01rem;
        }
        .company-website {
            color: #1976d2;
            text-decoration: underline;
        }
        .country-badge {
            display: inline-block;
            background: #e3f2fd;
            color: #1976d2;
            font-weight: bold;
            border-radius: 12px;
            padding: 2px 12px;
            font-size: 0.95rem;
            margin-left: 8px;
        }
        .btn-primary, .btn-success {
            background: linear-gradient(90deg, #42a5f5, #1976d2);
            border: none;
        }
        .btn-primary:hover, .btn-success:hover {
            background: linear-gradient(90deg, #1976d2, #42a5f5);
        }
        .edit-fields input, .edit-fields select, .edit-fields textarea {
            margin-bottom: 8px;
            width: 100%;
            border-radius: 6px;
            border: 1px solid #90caf9;
            background: #e0f2ff;
            padding: 7px;
        }
        .edit-fields textarea { resize: vertical; }
    </style>
</head>
<body style="background:#f6f8fa;">
    <?php include 'navbar.php'; ?>
    <div class="container" style="max-width:1000px; margin-top:40px;">
        <h2 class="mb-4 text-center">Registered Companies</h2>
        <div class="row">
            <?php if (count($companies) === 0): ?>
                <div class="col-12"><div class="alert alert-info">No companies registered yet.</div></div>
            <?php endif; ?>
            <?php foreach ($companies as $company): ?>
                <div class="col-md-6">
                    <div class="company-card d-flex align-items-center p-3">
                        <div class="me-3">
                            <?php if ($company['logo'] && file_exists($company['logo'])): ?>
                                <img src="<?= htmlspecialchars($company['logo']) ?>" alt="Logo" class="company-logo">
                            <?php else: ?>
                                <div class="company-logo d-flex align-items-center justify-content-center bg-light"><i class="fas fa-building fa-2x text-secondary"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="company-info flex-grow-1">
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $company['user_id'] && isset($_GET['edit']) && $_GET['edit'] == $company['id']): ?>
                                <form method="post" class="edit-fields">
                                    <input type="hidden" name="company_id" value="<?= $company['id'] ?>">
                                    <input type="text" name="company_name" value="<?= htmlspecialchars($company['company_name']) ?>" required placeholder="Company Name">
                                    <textarea name="description" rows="2" required placeholder="Description"><?= htmlspecialchars($company['description']) ?></textarea>
                                    <input type="text" name="website" value="<?= htmlspecialchars($company['website']) ?>" placeholder="Website">
                                    <select name="category" required>
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= $cat ?>" <?= ($company['category'] == $cat) ? 'selected' : '' ?>><?= $cat ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select name="country" required>
                                        <option value="">Select Country</option>
                                        <?php foreach ($countries as $c): ?>
                                            <option value="<?= $c ?>" <?= ($company['country'] == $c) ? 'selected' : '' ?>><?= $c ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select name="employees_range" required>
                                        <option value="">Select Range</option>
                                        <?php foreach ($employee_ranges as $er): ?>
                                            <option value="<?= $er ?>" <?= ($company['employees_range'] == $er) ? 'selected' : '' ?>><?= $er ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="number" name="capital" value="<?= htmlspecialchars($company['capital']) ?>" min="0" step="0.01" required placeholder="Capital (FCFA)">
                                    <button type="submit" name="update_company" class="btn btn-success btn-sm mt-2">Update</button>
                                    <a href="companies.php" class="btn btn-secondary btn-sm mt-2 ms-2">Cancel</a>
                                </form>
                            <?php else: ?>
                                <div class="company-title mb-1"><?= htmlspecialchars($company['company_name']) ?></div>
                                <div class="company-category mb-1">Category: <?= htmlspecialchars($company['category']) ?></div>
                                <div class="company-meta">Country: <span class="country-badge"><?= htmlspecialchars($company['country']) ?></span> | Employees: <?= htmlspecialchars($company['employees_range']) ?></div>
                                <div class="company-meta">Capital: <?= number_format($company['capital'], 0, ',', ' ') ?> FCFA</div>
                                <div class="company-meta">Email: <?= htmlspecialchars($company['email']) ?></div>
                                <?php if ($company['website']): ?>
                                    <div class="company-meta">Website: <a href="<?= htmlspecialchars($company['website']) ?>" class="company-website" target="_blank">Visit</a></div>
                                <?php endif; ?>
                                <div class="company-description"> <?= nl2br(htmlspecialchars($company['description'])) ?> </div>
                                <a class="btn btn-success rounded-pill py-2 px-4 mt-2" href="contact.php?company=<?= urlencode($company['company_name']) ?>">Contact</a>
                                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $company['user_id']): ?>
                                    <a href="companies.php?edit=<?= $company['id'] ?>" class="btn btn-primary btn-sm ms-2">Edit</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="js/main.js"></script>
    <script src="https://kit.fontawesome.com/4e9c2b2e7b.js" crossorigin="anonymous"></script>
</body>
</html> 