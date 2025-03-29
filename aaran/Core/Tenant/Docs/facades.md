### **Why Use a Facade Instead of a Service Directly?**

Facades and services both provide access to logic, but **facades** offer a more convenient and readable way to use a service without manually injecting dependencies. However, both approaches have their pros and cons.

---

## **1. Direct Service Usage (Dependency Injection)**
This is a clean and testable approach that follows **Laravel’s service container**.

### **Example: Injecting Service in Controller**
```php
use Aaran\Core\Tenant\Services\TenantManagerService;

class DashboardController extends Controller
{
    protected $tenantManager;

    public function __construct(TenantManagerService $tenantManager)
    {
        $this->tenantManager = $tenantManager;
    }

    public function dashboard()
    {
        $tenantId = $this->tenantManager->getId();
        return view('dashboard', compact('tenantId'));
    }
}
```

✅ **Pros**:
- Explicit dependencies (clear and testable).
- Uses Laravel's service container properly.
- Easier for unit testing (can mock services easily).

❌ **Cons**:
- Requires adding services to each class manually.
- More boilerplate in controllers and services.

---

## **2. Using a Facade**
Facades act as **static proxies** to service classes, making calls cleaner and more readable.

### **Example: Using Facade in Controller**
```php
use Aaran\Core\Tenant\Facades\TenantManager;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $tenantId = TenantManager::getId();
        return view('dashboard', compact('tenantId'));
    }
}
```

✅ **Pros**:
- **Cleaner and more readable code** (no need for `__construct`).
- Can be used **directly in Blade views**:
  ```php
  Tenant ID: {{ \Aaran\Core\Tenant\Facades\TenantManager::getId() }}
  ```
- No need to manually inject services in controllers or middleware.

❌ **Cons**:
- **Harder to test** (requires `Facade::shouldReceive()` for mocking).
- **Hides dependencies**, making it less explicit.
- **Breaks SOLID principles** if overused.

---

## **When to Use Each?**
| Scenario | Use Service (DI) | Use Facade |
|----------|----------------|-----------|
| **Testability needed** | ✅ | ❌ |
| **Used frequently in views/blade** | ❌ | ✅ |
| **Used inside controllers** | ✅ | ✅ |
| **Requires flexibility (e.g., multiple implementations)** | ✅ | ❌ |
| **Needs global accessibility** | ❌ | ✅ |

---

## **Conclusion**
1. **Use Dependency Injection (Service) when building controllers, services, or command-line scripts.**
    - It follows Laravel’s service container and makes testing easier.

2. **Use Facades for quick access to global services, especially in Blade views or helper functions.**
    - It keeps the code clean but is harder to test.

👉 **For best practices in Aaran-BMS, you can use services in controllers and facades in views/middleware.** 🚀
