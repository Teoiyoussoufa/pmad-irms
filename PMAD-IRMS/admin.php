<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}
require_once 'includes/db.php';

// Handle user update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $user_id = intval($_POST['user_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $status = $_POST['status'];
    if ($name && $email && $role && $status) {
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, role=?, status=? WHERE id=?");
        $stmt->bind_param("ssssi", $name, $email, $role, $status, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}
// Handle user delete
if (isset($_GET['delete_user']) && is_numeric($_GET['delete_user'])) {
    $user_id = intval($_GET['delete_user']);
    if ($user_id !== $_SESSION['user_id']) { // Prevent self-delete
        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    }
}
// Handle company update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_company'])) {
    $company_id = intval($_POST['company_id']);
    $company_name = trim($_POST['company_name']);
    $description = trim($_POST['description']);
    $website = trim($_POST['website']);
    $category = trim($_POST['category']);
    $country = trim($_POST['country']);
    $employees_range = trim($_POST['employees_range']);
    $capital = floatval($_POST['capital']);
    $stmt = $conn->prepare("UPDATE companies SET company_name=?, description=?, website=?, category=?, country=?, employees_range=?, capital=? WHERE id=?");
    $stmt->bind_param("ssssssdi", $company_name, $description, $website, $category, $country, $employees_range, $capital, $company_id);
    $stmt->execute();
    $stmt->close();
}
// Handle company delete
if (isset($_GET['delete_company']) && is_numeric($_GET['delete_company'])) {
    $company_id = intval($_GET['delete_company']);
    $stmt = $conn->prepare("DELETE FROM companies WHERE id=?");
    $stmt->bind_param("i", $company_id);
    $stmt->execute();
    $stmt->close();
}
// Handle investor update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_investor'])) {
    $investor_id = intval($_POST['investor_id']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $stmt = $conn->prepare("UPDATE investors SET phone=?, address=? WHERE id=?");
    $stmt->bind_param("ssi", $phone, $address, $investor_id);
    $stmt->execute();
    $stmt->close();
}
// Handle investor delete
if (isset($_GET['delete_investor']) && is_numeric($_GET['delete_investor'])) {
    $investor_id = intval($_GET['delete_investor']);
    $stmt = $conn->prepare("DELETE FROM investors WHERE id=?");
    $stmt->bind_param("i", $investor_id);
    $stmt->execute();
    $stmt->close();
}
// Fetch users
$users = [];
$result = $conn->query("SELECT * FROM users ORDER BY id ASC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
// Fetch companies
$companies = [];
$sql = "SELECT c.*, u.email FROM companies c JOIN users u ON c.user_id = u.id ORDER BY c.company_name ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $companies[] = $row;
    }
}
// Fetch investors
$investors = [];
$sql = "SELECT i.*, u.email FROM investors i JOIN users u ON i.user_id = u.id ORDER BY i.id ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $investors[] = $row;
    }
}
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
$roles = ['user', 'company', 'investor', 'admin'];
$statuses = ['active', 'inactive'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { background: linear-gradient(135deg, #e0f7fa 0%, #f6f8fa 100%); }
        .admin-section { background: #fff; border-radius: 16px; box-shadow: 0 2px 8px #eee; margin-bottom: 40px; padding: 24px; }
        .admin-section h3 { color: #1976d2; font-weight: bold; margin-bottom: 18px; }
        .admin-table th, .admin-table td { vertical-align: middle; }
        .admin-table input, .admin-table select { width: 100%; border-radius: 6px; border: 1px solid #90caf9; background: #e0f2ff; padding: 6px; }
        .admin-table .btn { min-width: 70px; }
        .edit-fields input, .edit-fields select, .edit-fields textarea { margin-bottom: 8px; width: 100%; border-radius: 6px; border: 1px solid #90caf9; background: #e0f2ff; padding: 7px; }
        .edit-fields textarea { resize: vertical; }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container" style="max-width:1200px; margin-top:40px;">
    <h2 class="mb-4 text-center">Admin Dashboard</h2>
    <!-- Users Section -->
    <div class="admin-section">
        <h3>All Users</h3>
        <table class="table table-bordered admin-table bg-white">
            <thead class="table-light">
                <tr>
                    <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Created</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <form method="post">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <td><?= $user['id'] ?></td>
                        <td><input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required></td>
                        <td><input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required></td>
                        <td>
                            <select name="role" required>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role ?>" <?= ($user['role'] == $role) ? 'selected' : '' ?>><?= ucfirst($role) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select name="status" required>
                                <?php foreach ($statuses as $status): ?>
                                    <option value="<?= $status ?>" <?= ($user['status'] == $status) ? 'selected' : '' ?>><?= ucfirst($status) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><?= $user['created_at'] ?></td>
                        <td>
                            <button type="submit" name="update_user" class="btn btn-primary btn-sm">Update</button>
                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <a href="admin.php?delete_user=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')">Delete</a>
                            <?php endif; ?>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- Companies Section -->
    <div class="admin-section">
        <h3>All Companies</h3>
        <table class="table table-bordered admin-table bg-white">
            <thead class="table-light">
                <tr>
                    <th>ID</th><th>Company Name</th><th>Description</th><th>Website</th><th>Category</th><th>Country</th><th>Employees</th><th>Capital</th><th>Email</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($companies as $company): ?>
                <tr>
                    <form method="post">
                        <input type="hidden" name="company_id" value="<?= $company['id'] ?>">
                        <td><?= $company['id'] ?></td>
                        <td><input type="text" name="company_name" value="<?= htmlspecialchars($company['company_name']) ?>" required></td>
                        <td><textarea name="description" rows="2" required><?= htmlspecialchars($company['description']) ?></textarea></td>
                        <td><input type="text" name="website" value="<?= htmlspecialchars($company['website']) ?>"></td>
                        <td>
                            <select name="category" required>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat ?>" <?= ($company['category'] == $cat) ? 'selected' : '' ?>><?= $cat ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select name="country" required>
                                <?php foreach ($countries as $c): ?>
                                    <option value="<?= $c ?>" <?= ($company['country'] == $c) ? 'selected' : '' ?>><?= $c ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select name="employees_range" required>
                                <?php foreach ($employee_ranges as $er): ?>
                                    <option value="<?= $er ?>" <?= ($company['employees_range'] == $er) ? 'selected' : '' ?>><?= $er ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="number" name="capital" value="<?= htmlspecialchars($company['capital']) ?>" min="0" step="0.01" required></td>
                        <td><?= htmlspecialchars($company['email']) ?></td>
                        <td>
                            <button type="submit" name="update_company" class="btn btn-primary btn-sm">Update</button>
                            <a href="admin.php?delete_company=<?= $company['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this company?')">Delete</a>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- Investors Section -->
    <div class="admin-section">
        <h3>All Investors</h3>
        <table class="table table-bordered admin-table bg-white">
            <thead class="table-light">
                <tr>
                    <th>ID</th><th>Phone</th><th>Address</th><th>Email</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($investors as $investor): ?>
                <tr>
                    <form method="post">
                        <input type="hidden" name="investor_id" value="<?= $investor['id'] ?>">
                        <td><?= $investor['id'] ?></td>
                        <td><input type="text" name="phone" value="<?= htmlspecialchars($investor['phone']) ?>"></td>
                        <td><input type="text" name="address" value="<?= htmlspecialchars($investor['address']) ?>"></td>
                        <td><?= htmlspecialchars($investor['email']) ?></td>
                        <td>
                            <button type="submit" name="update_investor" class="btn btn-primary btn-sm">Update</button>
                            <a href="admin.php?delete_investor=<?= $investor['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this investor?')">Delete</a>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html> 