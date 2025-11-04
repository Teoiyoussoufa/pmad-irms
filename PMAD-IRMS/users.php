<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}
require_once 'includes/db.php';

// Handle create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_user'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    if ($name && $email && $password && $role && $status) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $hashed_password, $role, $status);
        $stmt->execute();
        $stmt->close();
    }
}
// Handle update
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
// Handle delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $user_id = intval($_GET['delete']);
    if ($user_id !== $_SESSION['user_id']) { // Prevent self-delete
        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    }
}
// Fetch users
$users = [];
$result = $conn->query("SELECT * FROM users ORDER BY id ASC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
$roles = ['simple user', 'company', 'investor'];
$statuses = ['active', 'inactive'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .user-table th, .user-table td { vertical-align: middle; }
        .user-table input, .user-table select { width: 100%; border-radius: 6px; border: 1px solid #90caf9; background: #e0f2ff; padding: 6px; }
        .user-table .btn { min-width: 70px; }
        .create-user-form { background: #fff; border-radius: 10px; box-shadow: 0 2px 8px #eee; padding: 18px 20px 10px 20px; margin-bottom: 30px; }
    </style>
</head>
<body style="background:#f6f8fa;">
<?php include 'navbar.php'; ?>
<div class="container" style="max-width:900px; margin-top:40px;">
    <h2 class="mb-4 text-center">User Management</h2>
    <form method="post" class="create-user-form row g-2 align-items-end">
        <input type="hidden" name="create_user" value="1">
        <div class="col-md-3"><input type="text" name="name" class="form-control" placeholder="Name" required></div>
        <div class="col-md-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
        <div class="col-md-2"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
        <div class="col-md-2">
            <select name="role" class="form-control" required>
                <option value="">Role</option>
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role ?>"><?= ucfirst($role) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-1">
            <select name="status" class="form-control" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div class="col-md-1"><button type="submit" class="btn btn-success w-100">Create</button></div>
    </form>
    <table class="table table-bordered user-table bg-white">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
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
                            <a href="users.php?delete=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')">Delete</a>
                        <?php endif; ?>
                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html> 