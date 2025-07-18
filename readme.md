# 📸 Simple PHP Photostrip Wen
This is a basic PHP project that includes file handling, email sending, and photo display features. It uses Composer for dependency management.

## 🚀 Getting Started
### 1. Clone the Repository
```bash
git clone https://github.com/Winzliu/Photostrip.git
```
### 2. Move Project to `www/` Directory
```bash
mv Photostrip "C:/laragon/www/your-project-folder"
```
### 3. Install Dependencies
```bash
cd Photostrip
composer install
```
### 4. Changing Email Credentials
Open `send_email.php`
```bash
// 🔧 Change these lines:
$mail->Username = '[YourEmail]'; // Replace with your email
$mail->Password = '[YourEmailPassword]'; // Replace with your email password

$mail->setFrom('[YourEmail]', 'ClayMe!'); // Replace with your email
```
To send emails using Gmail, you must generate an **App Password**. Here's how:
- Enable **2-Step Verification** on your Google account  
  👉 [https://myaccount.google.com/security](https://myaccount.google.com/security)
- Go to the **App Passwords** page  
  👉 [https://myaccount.google.com/apppasswords](
  )
- Create a new App Password:
  - Select **Mail** as the app
  - Choose **Other (Custom name)** and give it any name (e.g. `Photostrip App`)
- Copy the 16-digit password that is generated  
  → Use this in place of `[YourEmailPassword]` inside `send_email.php`.
> ⚠️ Never use your actual Gmail password, always use an App Password.
### 5. Start Your Local Server
```bash
Go to http://localhost/Photostrip
```
