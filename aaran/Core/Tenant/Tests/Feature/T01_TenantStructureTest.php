<?php

namespace Aaran\Core\Tenant\Tests\Feature;

use Illuminate\Support\Facades\File;
use ReflectionClass;
use Tests\TestCase;

class T01_TenantStructureTest extends TestCase
{
    /**
     * ✅ Check if all necessary files exist in the Tenant module.
     */
    public function test_tenant_module_files_exist()
    {
        $files = [
            'Aaran/Core/Tenant/Models/Tenant.php',
            'Aaran/Core/Tenant/Services/TenantManager.php',
            'Aaran/Core/Tenant/Http/Controllers/TenantController.php',
            'Aaran/Core/Tenant/Http/Middleware/TenantMiddleware.php',
        ];

        $missingFiles = [];
        $caseMismatchedFiles = [];

        foreach ($files as $file) {
            $fullPath = base_path($file);

            // ❌ Check if file is missing
            if (!File::exists($fullPath)) {
                $missingFiles[] = $file;
                continue;
            }

            // 🔍 Check for case mismatch
            if (basename(realpath($fullPath)) !== basename($file)) {
                $caseMismatchedFiles[] = $file;
            }
        }

        // 🚨 Show detailed error if files are missing or case-mismatched
        $errorMessage = '';

        if (!empty($missingFiles)) {
            $errorMessage .= "\n❌ Missing Files:\n" . implode("\n", $missingFiles);
        }

        if (!empty($caseMismatchedFiles)) {
            $errorMessage .= "\n⚠️ Case Mismatch:\n" . implode("\n", $caseMismatchedFiles);
        }

        $this->assertEmpty($errorMessage, $errorMessage);

    }

    /**
     * ✅ Check if required methods exist in TenantManager.
     */
    public function test_tenant_manager_has_required_methods()
    {
        $methods = ['findByDomain', 'createTenant', 'switchDatabase'];

        $class = new ReflectionClass(\Aaran\Core\Tenant\Services\TenantManager::class);
        $missingMethods = [];

        foreach ($methods as $method) {
            if (!$class->hasMethod($method)) {
                $missingMethods[] = $method;
            }
        }

        // 🚨 If any methods are missing, fail the test with a detailed message
        $this->assertEmpty($missingMethods, "❌ Missing methods in TenantManager: " . implode(', ', $missingMethods));
    }

    /**
     * ✅ Check if required methods exist in TenantController.
     */
    public function test_tenant_controller_has_required_methods()
    {
        $methods = ['index', 'store', 'update', 'destroy'];

        $class = new ReflectionClass(\Aaran\Core\Tenant\Http\Controllers\TenantController::class);

        $missingMethods = [];
        foreach ($methods as $method) {
            if (!$class->hasMethod($method)) {
                $missingMethods[] = $method;

            }
        }

        // 🚨 If any methods are missing, fail the test with a detailed message
        $this->assertEmpty($missingMethods, "❌ Missing methods in TenantController: " . implode(', ', $missingMethods));

    }

    /**
     * ✅ Check if required methods exist in TenantMiddleware.
     */
    public function test_tenant_middleware_has_required_methods()
    {
        $class = new ReflectionClass(\Aaran\Core\Tenant\Http\Middleware\TenantMiddleware::class);
        $this->assertTrue($class->hasMethod('handle'), "Missing method: handle in TenantMiddleware");
    }
}
