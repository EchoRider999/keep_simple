<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/github_username/repo_name">
    <img src="https://i.ibb.co/sPsrCSb/Logo.jpg" alt="Logo" width="80" height="80">
  </a>
<h3 align="center">📝 Keep simple</h3>
  <p align="center">
    Keep Simple is a very ✨ simple / 🤏 tiny / ☄️ fast Notes Taking Responsive PHP Web App without database - Google Keep alternative
  </p>
</div>

## ⏯️ Examples

| <img src="https://i.ibb.co/tH9sC1Y/1.jpg" alt="Login page" style="max-height: 250px;"> |<img src="https://i.ibb.co/Mg3sRgT/2.jpg" alt="Home page" style="max-height: 250px;"> |  <img src="https://i.ibb.co/VTPtW48/3.jpg" alt="Boostrap theme selector" style="max-height: 250px;"> | 
|:--:|:--:| :--:| 
| *🔑 Login page* | *🏠 Home page* | *🎨 Bootswatch theme selector* |

# 🎮 Features

- ✅ Very light and simple self-hosted note-taking application
- ✅ Data encrypted and stored in JSON files: `json/$login.json`
- ✅ 4 steps configuration
- ✅ Basic Login captcha
- ✅ No database required
- ✅ Multiple theme selector
- ✅ Responsive thanks to the magnificent booswatch themes

## ⚙️ Prerequisites

- ➡️ Web Server: Apache / Nginx
- ➡️ PHP: 8+

## 🚀Quick start

### 1️⃣ - Clone project to your webroot

```bash
# move to your webroot
cd $your_webroot
# clone projet
git clone git@github.com:EchoRider999/keep_simple.git
# rename as you want, for exemple : 
mv keep_simple keep
# move to project dir
cd keep
```

### 2️⃣ - Add users in `config/users.php`

```bash
# copy sample
cp config/users.php.sample config/users.php
# fix permissions
chmod 600 config/users.php
chown www-data config/users.php
# edit file
vim config/users.php
```
Add users like you want :
```php
<?php
// Define valid credentials
$valid_credentials = [
    "user1" => "pass1",
    "user2" => "pass2",
];
>
```

### 3️⃣ - Set encryption key in `config/encryption_key.php`

```bash
# copy sample
cp -p config/encryption_key.php.sample config/encryption_key.php
# fix permissions
chmod 600 config/encryption_key.php
chown www-data config/encryption_key.php
# edit file
vim config/encryption_key.php
```
Add your encryption key here (for example : `hPRAJqMqR:uZyAc2rQfujz3D4JrrgAgJ34qdYj3` ) :
```php
<?php
// Encryption key, keep it secure
$encryption_key = "hPRAJqMqR:uZyAc2rQfujz3D4JrrgAgJ34qdYj3"; 
?>
```

### 4️⃣ - Allow web user to write in `json` dir

Normally, it should be `www-data` for apache and nginx
```bash
# fix permissions
chmod 700 json
chown www-data json
```

### 🎉 Enjoy ! Go to `https://_URL_/keep` or equivalent 😉

## 💾 Data location

- Data are stored and crypted in JSON files: `json/$login.json`.
- Exemple : `json/user1.json` for user1, etc...
- You can check encryption by displaying the file :
```bash
# try to display crypted user1 data
cat json/user1.json
```