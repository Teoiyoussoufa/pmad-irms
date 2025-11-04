<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.html');
    exit();
}
require_once 'includes/db.php';
$messages = [];
$result = $conn->query("SELECT * FROM messages ORDER BY sent_at DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Messages</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #e0f7fa 0%, #f6f8fa 100%);
        }
        .message-card {
            box-shadow: 0 2px 8px #eee;
            border-radius: 16px;
            margin-bottom: 32px;
            background: #fff;
            border-left: 6px solid #42a5f5;
            transition: box-shadow 0.2s, transform 0.2s;
            position: relative;
        }
        .message-card:hover {
            box-shadow: 0 8px 24px #b3e5fc;
            transform: translateY(-2px) scale(1.01);
        }
        .message-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px 8px 24px;
        }
        .message-name {
            font-size: 1.15rem;
            font-weight: bold;
            color: #1976d2;
        }
        .message-email {
            font-size: 0.98rem;
            color: #555;
        }
        .message-date {
            font-size: 0.95rem;
            color: #888;
            font-style: italic;
        }
        .message-body {
            padding: 0 24px 18px 24px;
            color: #333;
            font-size: 1.05rem;
        }
        .message-subject {
            display: inline-block;
            background: #e3f2fd;
            color: #1976d2;
            font-weight: bold;
            border-radius: 12px;
            padding: 2px 12px;
            font-size: 0.98rem;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container" style="max-width:900px; margin-top:40px;">
    <h2 class="mb-4 text-center">User Messages</h2>
    <?php if (count($messages) === 0): ?>
        <div class="alert alert-info">No messages received yet.</div>
    <?php endif; ?>
    <?php foreach ($messages as $msg): ?>
        <div class="message-card">
            <div class="message-header">
                <div>
                    <span class="message-name"><?= htmlspecialchars($msg['name']) ?></span>
                    <span class="badge bg-primary ms-2 message-email"> <?= htmlspecialchars($msg['email']) ?> </span>
                </div>
                <span class="message-date"><?= date('d M Y, H:i', strtotime($msg['sent_at'])) ?></span>
            </div>
            <div class="message-body">
                <?php if ($msg['subject']): ?>
                    <div class="message-subject">Subject: <?= htmlspecialchars($msg['subject']) ?></div>
                <?php endif; ?>
                <div><?= nl2br(htmlspecialchars($msg['message'])) ?></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html> 