# Aaran-Next

## 🚀 Overview
Aaran-Next is a modular, package-based enterprise application framework built with Laravel 12 and designed for scalability, flexibility, and Test-Driven Development (TDD). It supports advanced real-time features, role-based access control, and seamless AI integration.

## 🏗️ Architecture
Aaran-Next follows a modular structure, ensuring each feature is independent and reusable.

```
Aaran/
  Core/           → Core functionalities (Auth, RBAC, etc.)
  Auth/           → Authentication module (User, Roles, Permissions)
  LMS/            → Learning Management System module
  BMS/            → Business Management System module
  Docs/           → Documentation (Markdown files)
```

## ⚙️ Installation

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/your-repo/aaran-next.git
cd aaran-next
```

### 2️⃣ Install Dependencies
```bash
composer install
npm install
```

### 3️⃣ Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4️⃣ Run Migrations & Seeders
```bash
php artisan migrate --seed
```

### 5️⃣ Start the Server
```bash
php artisan serve
```

## 🛠 Features
- Modular Architecture with Laravel Packages
- Role-Based Access Control (RBAC) Without Spatie
- Test-Driven Development (TDD) with PestPHP
- Automated Module Discovery & Service Registration
- AI & Automation Ready for Enterprise Applications

## 📜 License
Aaran-Next is open-source and licensed under [MIT](LICENSE).

---
💡 **Stay tuned for more updates!**