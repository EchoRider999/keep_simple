<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/github_username/repo_name">
    <img src="https://i.ibb.co/sPsrCSb/Logo.jpg" alt="Logo" width="80" height="80">
  </a>
<h3 align="center">Keep simple</h3>
  <p align="center">
    Keep Simple is a very simple / tiny / fast Notes Taking Responsive PHP Web App without database - Google Keep alternative
  </p>
</div>

## Examples

| <img src="https://i.ibb.co/tH9sC1Y/1.jpg" alt="Login page" style="max-height: 250px;"> |<img src="https://i.ibb.co/Mg3sRgT/2.jpg" alt="Home page" style="max-height: 250px;"> |  <img src="https://i.ibb.co/VTPtW48/3.jpg" alt="Boostrap theme selector" style="max-height: 250px;"> | 
|:--:|:--:| :--:| 
| *Login page* | *Home page* | *Bootstrap theme selector* |

# Features

- Very light and simple self-hosted note-taking application
- Data encrypted and stored in JSON files: `json/$login.json`
- 3 steps configuration
- Basic Login captcha
- No database required

- Boostrap CSS theme selector

## Prerequisites

- Web Server: Apache / Nginx
- PHP: 8+

## Configuration

### 1 - Add your users in `config/users.php`

```php
// Define valid credentials
$valid_credentials = [
    "demo" => "demo",
    "foo" => "bar",
];
```

### 2 - Set your encryption key in `config/encryption_key.php`

```php
// Encryption key, keep it secure
$encryption_key = "YOUR_ENCRYPTION_KEY";
```

### 3 - Allow the web user to write to the `json` folder (e.g., `www-data`)

```bash
chmod 700 json
chown www-data json
```

### 4 - Enjoy it on mobile or desktop ;)
