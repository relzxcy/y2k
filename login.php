<?php
session_start();

// Jika sudah login, redirect ke index.php
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=adminpoli;charset=utf8mb4", 'root', '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                header("Location: index.php");
                exit();
            } else {
                $error = "Username atau password salah";
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    } else {
        $error = "Harap isi username dan password";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - politeknik negeri manado</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #06080f;
            --surface: #0b0e18;
            --surface2: #10141f;
            --border: #1a2035;
            --border2: #222a3f;
            --ac: #e63950;
            --text: #e2e8f0;
            --muted: #637089;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-box {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            text-align: center;
        }
        .logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.5rem;
            letter-spacing: 3px;
            margin-bottom: 20px;
        }
        .logo span { color: var(--ac); }
        .form-group {
            margin-bottom: 18px;
            text-align: left;
        }
        .form-group label {
            display: block;
            font-size: 0.8rem;
            color: var(--muted);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .form-input {
            width: 100%;
            padding: 12px 16px;
            background: var(--surface2);
            border: 1px solid var(--border2);
            border-radius: 10px;
            color: var(--text);
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s;
        }
        .form-input:focus { border-color: var(--ac); }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--ac);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: filter 0.3s;
            margin-top: 10px;
        }
        .btn-login:hover { filter: brightness(1.15); }
        .error-msg {
            background: rgba(230, 57, 80, 0.1);
            color: var(--ac);
            padding: 10px;
            border-radius: 8px;
            border: 1px solid rgba(230, 57, 80, 0.3);
            margin-bottom: 20px;
            font-size: 0.85rem;
            display: <?php echo $error ? 'block' : 'none'; ?>;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <div class="logo">politeknik negeri  <span>manado</span></div>
        
        <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>

        <form method="POST" action="">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-input" required autofocus autocomplete="off">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-input" required>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>

</body>
</html>
