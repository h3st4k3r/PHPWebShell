# W3bsh3llPRO - Advanced Web Shell for Red Team Operations

## 📌 Overview
**W3bsh3llPRO** is a **powerful, lightweight web shell** designed for **Red Team operations, penetration testing, and security auditing**. It provides a **hacker-style interface** for executing commands, managing files, and performing emergency actions in a remote environment.

> **⚠️ Warning:** This tool is for **authorized security testing** only. Unauthorized use is illegal.

---

## 🔥 Features

### **1️⃣ Command Execution**
- **Manual Commands:**
  - Enter any shell command in the input field and click **Execute**.
  - Output appears in the terminal below.

- **Predefined Quick Commands:**
  - **List Files (`ls -la`)** → Lists files and directories.
  - **Who Am I (`whoami`)** → Displays the current user.
  - **Current Directory (`pwd`)** → Shows the working directory.

### **2️⃣ File Management**
- **Compress & Download ZIP** → Creates a ZIP of all files in the directory and downloads it.

### **3️⃣ Emergency Actions**
- **Emergency Delete (`rm -rf *`)**
  - **WARNING:** Deletes the shell and all files in the directory.
  - A confirmation prompt prevents accidental execution.

- **Clear History**
  - Clears the displayed terminal output (does not affect logs).

---

## 🚀 Installation & Setup

### **1️⃣ Deploying the Shell**
1. Upload `index.php` to a **web-accessible server**.
2. Ensure the PHP environment is running (`php -S 0.0.0.0:8000` or Apache).
3. Access the shell via your browser (`http://yourserver/index.php`).

### **2️⃣ Changing the Default Password**
The default credentials are:
```php
$users = ["admin" => hash("sha256", "toor")];
```
To change the password:
1. Open `index.php`.
2. Locate the `$users` array.
3. Replace `toor` with a new password.
4. Generate a SHA-256 hash of your new password:
   ```bash
   echo -n "NEW_PASSWORD" | sha256sum
   ```
5. Replace the hash in `index.php`:
   ```php
   $users = ["admin" => "your_new_hashed_password"];
   ```
6. Save and re-upload `index.php`.

---

## 🖥️ Using the Web Interface

### **Login**
1. Enter **Username & Password** (set in `index.php`).
2. Click **Login** to access the shell.

### **Executing Commands**
1. **Manual Execution:**
   - Type a command in the input field.
   - Click **Execute** to run it.

2. **Using Quick Commands:**
   - Click **List Files** (`ls -la`), **Who Am I** (`whoami`), or **Current Directory** (`pwd`).

### **Managing Files**
- Click **Compress & Download ZIP** to package all files and download them.

### **Emergency Delete**
1. Click **Emergency Delete**.
2. A confirmation prompt appears: *"Warning: You are about to delete the shell and all files in its directory! This action is irreversible."*
3. If confirmed, **all files** in the directory are deleted.

### **Clearing History**
- Click **Clear History** to reset the terminal display.

---

## 🛡️ Security Best Practices
- **Restrict Access**: Host on an internal Red Team server.
- **Use Strong Passwords**: Change the default credentials immediately.
- **Monitor Usage**: Log accesses and commands.
- **Remove After Use**: Do not leave it exposed on a live server.

---

## 📖 Legal Disclaimer
**This tool is intended for educational and authorized security testing purposes only.** Unauthorized use against systems you do not own or have permission to test is illegal and punishable by law.

**Developed by:** ©h3st4k3r 🚀
