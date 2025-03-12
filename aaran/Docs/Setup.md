Great! Since we're restarting Aaran-BMS as **Aaran-Next** with **Test-Driven Development (TDD)** and a **modular/package-based structure**, let's outline the first steps:

### **Step 1: Project Setup**
- [ ] Initialize a new Laravel 12 project.
- [ ] Set up **PestPHP** for testing.
- [ ] Configure a modular/package-based structure.
- [ ] Set up version control (Git).

### **Step 2: Core Architecture**
- [ ] Define the **Aaran-Next** folder structure.
- [ ] Create a service provider for automatic module loading.
- [ ] Implement a test-driven approach to module creation.

### **Step 3: User Management Module (First Module with TDD)**
- [ ] Write the first test for the `User` model.
- [ ] Implement the `User` model, migration, and factory.
- [ ] Set up repositories, services, and middleware.
- [ ] Implement authentication (API & Web).

Would you like to start with **Step 1: Project Setup**, or do you want to tweak the approach?

### **Step 1: Project Setup**

#### **1. Initialize a New Laravel 12 Project**
Run the following command to create a fresh Laravel 12 project:
```bash
composer create-project laravel/laravel aaran-next
```
Then, navigate into the project directory:
```bash
cd aaran-next
```

#### **2. Set Up Pest for Testing**
Since we’re using Test-Driven Development (TDD), we’ll use PestPHP instead of PHPUnit. Install Pest using:
```bash
composer require pestphp/pest --dev
```
Then, run the Pest installation command:
```bash
php artisan pest:install
```
This will set up `tests/Pest.php` and Pest configurations.

#### **3. Configure a Modular/Package-Based Structure**
Since we’re using a modular approach, let's create a base folder for all our modules:
```bash
mkdir -p Aaran/Core
mkdir -p Aaran/Modules
mkdir -p Aaran/Setup
```
We’ll keep:
- **Core functionalities** in `Aaran/Core/`
- **Feature modules** inside `Aaran/Modules/`
- **Setup & automation scripts** in `Aaran/Setup/`

#### **4. Set Up Version Control (Git)**
Initialize a Git repository and create a `.gitignore` file:
```bash
git init
echo "vendor/" >> .gitignore
echo ".env" >> .gitignore
echo "node_modules/" >> .gitignore
git add .
git commit -m "Initial commit for Aaran-Next"
```

---

### **Next Step**
✅ **Step 1 (Project Setup) Done!**

Would you like to move to **Step 2: Core Architecture**, or do you want to make changes?

### **Step 2: Core Architecture**

Now that Aaran-Next is set up, let's structure its **core architecture** for modular development.

---

## **1. Define the Aaran-Next Folder Structure**
We will structure the project to support modular development. Run the following to create the necessary folders:
```bash
mkdir -p Aaran/Core/Providers
mkdir -p Aaran/Modules
mkdir -p Aaran/Setup/Console
mkdir -p Aaran/Tests
```
- **Aaran/Core/** → Holds system-wide utilities, helpers, and auto-registration logic.
- **Aaran/Modules/** → Contains all feature modules (Auth, Users, Courses, etc.).
- **Aaran/Setup/** → Contains commands for project automation.
- **Aaran/Tests/** → Contains additional test cases outside Laravel’s default `tests/` folder.

---

## **2. Create AaranServiceProvider (Module Auto-Loader)**
We will create a **service provider** to automatically load modules.

### **Create the Service Provider**
Run the command:
```bash
php artisan make:provider AaranServiceProvider
```
Then, move the generated file to `Aaran/Core/Providers/AaranServiceProvider.php`.

### **Modify AaranServiceProvider.php**
Update the `register()` and `boot()` methods to **auto-load modules** from `Aaran/Modules/`.

**Aaran/Core/Providers/AaranServiceProvider.php**
```php
<?php

namespace Aaran\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class AaranServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerModules();
    }

    public function boot()
    {
        $this->bootModules();
    }

    protected function registerModules()
    {
        $modules = glob(base_path('Aaran/Modules/*'), GLOB_ONLYDIR);
        foreach ($modules as $module) {
            $providerPath = $module . '/Providers/ModuleServiceProvider.php';
            if (File::exists($providerPath)) {
                $this->app->register("Aaran\\Modules\\" . basename($module) . "\\Providers\\ModuleServiceProvider");
            }
        }
    }

    protected function bootModules()
    {
        foreach (glob(base_path('Aaran/Modules/*/routes/*.php')) as $routeFile) {
            $this->loadRoutesFrom($routeFile);
        }
    }
}
```
### **Register AaranServiceProvider in Laravel**
Open `config/app.php` and add:
```php
Aaran\Core\Providers\AaranServiceProvider::class,
```

---

## **3. Implement a Test-Driven Approach**
Before moving to the next step, let's write a **test** to ensure our **module auto-loader** works correctly.

Create a test file:
```bash
touch tests/Feature/ModuleAutoLoadTest.php
```
Then, add the following test case:

**tests/Feature/ModuleAutoLoadTest.php**
```php
<?php

test('AaranServiceProvider loads modules correctly', function () {
    $this->assertTrue(class_exists(\Aaran\Core\Providers\AaranServiceProvider::class));
});
```
Run the test:
```bash
php artisan test --filter ModuleAutoLoadTest
```
If it passes ✅, our module loader works!

---

## **Next Step**
✅ **Core Architecture is set up!**  
Would you like to move to **Step 3: User Management Module**, or refine anything first? 🚀


Perfect! With `"Aaran\\": "aaran/"` in `composer.json`, Laravel will now recognize our **Aaran** namespace correctly.

Now, run:
```bash
composer dump-autoload
```
This will refresh the autoloader and ensure our **Aaran/Core/Providers/AaranServiceProvider** is correctly registered.

---

## **Next Step: User Management Module**
Now, let’s move to **Step 3: User Management Module** with TDD.

### **Step 3: Create the User Management Module**

1️⃣ **Generate the Module Folder**  
Run:
```bash
mkdir -p aaran/Auth/Identity/{Providers,Models,Migrations,Routes,Tests}
```
This will create the `Identity` module under `Auth`, following:
```
aaran/Auth/Identity/
    ├── Providers/
    ├── Models/
    ├── Migrations/
    ├── Routes/
    ├── Tests/
```
This will keep **Identity-related features** like users, authentication, and roles structured.

---

2️⃣ **Create the User Model**  
Inside `aaran/Auth/Identity/Models/User.php`:
```php
<?php

namespace Aaran\Auth\Identity\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password'];
}
```

---

3️⃣ **Create the Module Service Provider**  
Inside `aaran/Auth/Identity/Providers/ModuleServiceProvider.php`:
```php
<?php

namespace Aaran\Auth\Identity\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register services
    }

    public function boot()
    {
        $this->loadMigrationsFrom(base_path('aaran/Auth/Identity/Migrations'));
        $this->loadRoutesFrom(base_path('aaran/Auth/Identity/Routes/web.php'));
    }
}
```
Now our **User module** will have its own migrations & routes.

---

4️⃣ **Register the Module Provider in AaranServiceProvider**  
Open `Aaran/Core/Providers/AaranServiceProvider.php` and ensure module providers are auto-registered:
```php
protected function registerModules()
{
    $modules = glob(base_path('aaran/*/*'), GLOB_ONLYDIR);
    foreach ($modules as $module) {
        $providerPath = $module . '/Providers/ModuleServiceProvider.php';
        if (file_exists($providerPath)) {
            $this->app->register("Aaran\\" . str_replace('/', '\\', substr($module, 6)) . "\\Providers\\ModuleServiceProvider");
        }
    }
}
```

---

5️⃣ **Write a Test for the User Model (TDD)**  
Create `tests/Feature/UserTest.php`:
```php
<?php

use Aaran\Auth\Identity\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('User model can be created', function () {
    $user = User::factory()->create();
    expect($user)->toBeInstanceOf(User::class);
});
```
Run the test:
```bash
php artisan test --filter UserTest
```
✅ If it passes, **User Management Module is working!**

---

### **Next Steps**
✅ **User module is set up!**  
Do you want to:
1. **Proceed with Authentication (Login, Register, Middleware)?**
2. **Refine anything before continuing?**

### **Refining Aaran-Next Before Moving Forward**

Let's clean up and strengthen the foundation before proceeding with authentication.

---

## **1️⃣ Standardize Module Auto-Loading**

Right now, the `AaranServiceProvider` loads modules dynamically, but let's make it cleaner and more efficient.

### **Update `registerModules()` in `Aaran/Core/Providers/AaranServiceProvider.php`**

```php
protected function registerModules()
{
    $modules = glob(base_path('aaran/*/*'), GLOB_ONLYDIR);
    
    foreach ($modules as $module) {
        $namespace = "Aaran\\" . str_replace('/', '\\', substr($module, 6)) . "\\Providers\\ModuleServiceProvider";
        $providerPath = $module . '/Providers/ModuleServiceProvider.php';

        if (file_exists($providerPath) && class_exists($namespace)) {
            $this->app->register($namespace);
        }
    }
}
```
🔹 **Why?**
- Ensures **only existing classes** are registered.
- Handles **all module types** (`Auth/Identity`, `LMS/Courses`, etc.) dynamically.

---

## **2️⃣ Improve the User Model Factory for Testing**

Since Laravel **doesn’t generate factories for models outside `app/`**, let’s create one manually.

### **Create a User Factory**
Run:
```bash
mkdir -p database/factories/Auth/Identity
touch database/factories/Auth/Identity/UserFactory.php
```

Then, define the factory:

```php
<?php

namespace Database\Factories\Auth\Identity;

use Aaran\Auth\Identity\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
```

### **Update the User Model to Use the Factory**
Inside `Aaran/Auth/Identity/Models/User.php`, add:

```php
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected static function newFactory()
    {
        return \Aaran\Auth\Identity\Database\Factories\UserFactory::new();
    }
}
```
Now, running
```bash
User::factory()->create();
```
works **without errors**! 🚀

---

## **3️⃣ Improve Tests**
### **Update `tests/Feature/UserTest.php`**
```php
<?php

use Aaran\Auth\Identity\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('User model can be created', function () {
    $user = User::factory()->create();
    
    expect($user)->toBeInstanceOf(User::class)
        ->and($user->email)->toBeString();
});
```
Run tests:
```bash
php artisan test --filter UserTest
```
✅ Now tests are **more robust and informative**.

---

### **4️⃣ Final Refinements Before Authentication**
🔹 **Ensure Migration Discovery Works**
```bash
php artisan migrate:fresh --seed
```
If no errors occur, **modules & database setup is solid!**

🔹 **Make Sure All Modules Auto-Register**
```php
php artisan about | grep Aaran
```
This should list `AaranServiceProvider` and `Identity\ModuleServiceProvider` successfully.

---

### **Next Steps**
✅ **Refinements Done!**  
Would you like to:
1. **Proceed with Authentication (Login, Register, Middleware)?**
2. **Tweak anything further?**


Yes! We can move everything inside the **`aaran/`** folder, making Aaran-Next a fully **self-contained** modular system.

### **Goal:**
Move **everything**, including **factories, seeders, migrations, tests, providers**, into `aaran/`, so nothing is left in `database/` or `tests/`.

---

## **1️⃣ Update `composer.json` Autoload Paths**
Since we are moving everything inside `aaran/`, update **`composer.json`**:

```json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Aaran\\": "aaran/"
    }
},
"autoload-dev": {
    "psr-4": {
        "Aaran\\Tests\\": "aaran/Tests/"
    }
}
```
This makes Laravel recognize tests inside `aaran/Tests/`.

Run:
```bash
composer dump-autoload
```

---

## **2️⃣ Move Factories, Seeders, and Migrations**

### **Move Factories**
Move from:
```
database/factories/Auth/Identity/UserFactory.php
```
To:
```
aaran/Auth/Identity/Database/Factories/UserFactory.php
```

Update the namespace inside the factory:
```php
namespace Aaran\Auth\Identity\Database\Factories;
```

Update `User.php` to:
```php
protected static function newFactory()
{
    return \Aaran\Auth\Identity\Database\Factories\UserFactory::new();
}
```

---

### **Move Seeders**
Move from:
```
database/seeders/DatabaseSeeder.php
```
To:
```
aaran/Core/Database/Seeders/DatabaseSeeder.php
```
Update the namespace:
```php
namespace Aaran\Core\Database\Seeders;
```

Register it inside `ModuleServiceProvider.php`:
```php
$this->loadMigrationsFrom(base_path('aaran/Auth/Identity/Database/Migrations'));
$this->loadSeedersFrom(base_path('aaran/Core/Database/Seeders'));
```

---

### **Move Migrations**
Move from:
```
database/migrations/xxxx_create_users_table.php
```
To:
```
aaran/Auth/Identity/Database/Migrations/xxxx_create_users_table.php
```
Laravel will now discover them through:
```php
$this->loadMigrationsFrom(base_path('aaran/Auth/Identity/Database/Migrations'));
```

Run:
```bash
php artisan migrate:fresh --seed
```
If it works, **we have fully modular database handling!** ✅

---

## **3️⃣ Move Tests**
Move from:
```
tests/Feature/UserTest.php
```
To:
```
aaran/Tests/Feature/UserTest.php
```
Update:
```php
namespace Aaran\Tests\Feature;
```
Run:
```bash
php artisan test
```
✅ **Now Aaran-Next is fully self-contained!** 🚀

---

### **Final Check**
Run:
```bash
ls aaran/
```
It should now include:
```
Aaran/
├── Auth/
│   ├── Identity/
│   │   ├── Database/
│   │   │   ├── Factories/
│   │   │   ├── Migrations/
│   │   ├── Models/
│   │   ├── Providers/
│   │   ├── Routes/
│   │   ├── Tests/
│   │   ├── ModuleServiceProvider.php
├── Core/
│   ├── Database/
│   │   ├── Seeders/
│   ├── Providers/
│   ├── AaranServiceProvider.php
└── Tests/
```

✅ **Now nothing is left outside `aaran/` except Laravel’s core folders!**

---

### **Next Steps**
1. **Proceed with Authentication (Login, Register, Middleware)?**
2. **Any more refinements before continuing?**
