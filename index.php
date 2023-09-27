<?php

require_once('Controller.php');

$data = [
    'username' => $_POST['username'] ?? '',
    'email' => $_POST['email'] ?? '',
    'password' => $_POST['password'] ?? '',
];

$controller = new Controller($data);
$validator = $controller->getValidator();
$controller->handleForm();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sample Form</title>
</head>
<body>
    <form method="post" action="">
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?= htmlspecialchars($data['username']); ?>">
            <?php foreach ($validator->showError('username') as $error): ?>
                <span class="error"><?= $error; ?></span><br>
            <?php endforeach; ?>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" value="<?= htmlspecialchars($data['email']); ?>">
            <?php foreach ($validator->showError('email') as $error): ?>
                <span class="error"><?= $error; ?></span><br>
            <?php endforeach; ?>
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" value="">
            <?php foreach ($validator->showError('password') as $error): ?>
                <span class="error"><?= $error; ?></span><br>
            <?php endforeach; ?>
        </div>

        <div>
            <input type="submit" value="Submit">
        </div>
    </form>
</body>
</html>
