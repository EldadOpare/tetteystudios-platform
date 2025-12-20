<?php
session_start();
require_once __DIR__ . '/src/auth.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? 'viewer';

    if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        $result = register($username, $email, $password, $role);
        if ($result['success']) {
            $success = $result['message'];
            // Auto login after registration
            $user = $GLOBALS['supabase']->request('GET', 'users', [
                'select' => '*,user_profiles(role)',
                'username' => "eq.$username"
            ]);
            if (!empty($user)) {
                $user = $user[0];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $profile = $user['user_profiles'][0] ?? [];
                $_SESSION['role'] = $profile['role'] ?? 'viewer';
                // Redirect to dashboard
                if ($_SESSION['role'] === 'filmmaker') {
                    header('Location: filmmaker_dashboard.php');
                } else {
                    header('Location: viewer_dashboard.php');
                }
                exit;
            }
        } else {
            $error = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - TetteyStudios+</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="auth-box-body">
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h1>Create Account</h1>
                <p>Start watching today</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($success) ?>
                    <br><small>Redirecting to login...</small>
                </div>
            <?php endif; ?>

            <form method="POST" action="signup.php">
                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-input" required
                        autocomplete="username">
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input" required autocomplete="email">
                </div>

                <div class="form-group">
                    <label class="form-label" for="role">I am a...</label>
                    <select id="role" name="role" class="form-input" required>
                        <option value="viewer">Viewer</option>
                        <option value="filmmaker">Filmmaker</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input" required
                        autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label class="form-label" for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-input" required
                        autocomplete="new-password">
                </div>

                <button type="submit" class="auth-btn">Sign Up</button>
            </form>

            <div class="auth-link">
                Already have an account? <a href="login.php">Sign in</a>
            </div>
        </div>
    </div>
    <script src="/js/script.js"></script>
</body>

</html>