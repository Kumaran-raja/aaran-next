<?php

namespace Aaran\Core\Setup\Livewire\Class;

use Aaran\Core\Tenant\Helpers\TenantHelper;
use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class TenantSetupWizard extends Component
{
    public $step = 1;
    public $b_name;
    public $t_name;
    public $email;
    public $contact;
    public $phone;
    public $db_name;
    public $db_user;
    public $db_pass;
    public $plan = 'free';
    public $subscription_start;
    public $subscription_end;
    public $storage_limit = 10;
    public $user_limit = 5;
    public $is_active = true;
    public $two_factor_enabled = false;
    public $allow_sso = false;

    protected $rules = [
        'b_name' => 'required|string|max:255',
        't_name' => 'required|string|max:255|unique:tenants,t_name',
        'email' => 'required|email|unique:tenants,email',
        'contact' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:255',
        'db_name' => 'required|string|max:255|unique:tenants,db_name',
        'db_user' => 'required|string|max:255',
        'db_pass' => 'required|string',
        'plan' => 'required|string',
        'storage_limit' => 'required|numeric|min:1',
        'user_limit' => 'required|integer|min:1',
        'is_active' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'allow_sso' => 'boolean',
    ];

    public function nextStep()
    {
        $this->validateStep();
        if ($this->step < 3) { // Prevent invalid step
            $this->step++;
        }
    }

    public function prevStep()
    {
        if ($this->step > 1) { // Prevent negative step count
            $this->step--;
        }
    }

    public function validateStep()
    {
        if ($this->step == 1) {
            $this->validate([
                'b_name' => $this->rules['b_name'],
                't_name' => $this->rules['t_name'],
                'email' => $this->rules['email'],
                'contact' => $this->rules['contact'],
                'phone' => $this->rules['phone'],
            ]);
        } elseif ($this->step == 2) {
            $this->validate([
                'db_name' => $this->rules['db_name'],
                'db_user' => $this->rules['db_user'],
                'db_pass' => $this->rules['db_pass'],
                'plan' => $this->rules['plan'],
                'storage_limit' => $this->rules['storage_limit'],
                'user_limit' => $this->rules['user_limit'],
                'is_active' => $this->rules['is_active'],
                'two_factor_enabled' => $this->rules['two_factor_enabled'],
                'allow_sso' => $this->rules['allow_sso'],
            ]);
        }
    }

    public function createTenant()
    {
        $this->validate();

        Log::info('🚀 Tenant setup started.', [
            'tenant_name' => $this->t_name,
            'email' => $this->email
        ]);


        DB::beginTransaction();
        try {

            // Step 1: Create Tenant Entry
            Log::info('📌 Creating tenant in database.', ['tenant_name' => $this->t_name]);

            // Create Tenant Entry in Main Database
            $tenant = Tenant::create([
                'b_name' => $this->b_name,
                't_name' => $this->t_name,
                'email' => $this->email,
                'contact' => $this->contact,
                'phone' => $this->phone,
                'db_name' => $this->db_name,
                'db_host' => '127.0.0.1',
                'db_port' => '3306',
                'db_user' => $this->db_user,
                'db_pass' => $this->db_pass,
                'plan' => $this->plan,
                'subscription_start' => $this->subscription_start ?? now(),
                'subscription_end' => $this->subscription_end ?? null,
                'storage_limit' => $this->storage_limit,
                'user_limit' => $this->user_limit,
                'is_active' => $this->is_active,
                'two_factor_enabled' => $this->two_factor_enabled,
                'allow_sso' => $this->allow_sso,
            ]);

            Log::info('✅ Tenant created successfully.', ['tenant_id' => $tenant->id]);


            // Step 2: Run Tenant Migrations (Only if DB Exists)
            Log::info('📂 Running tenant database migrations.', ['db_name' => $tenant->db_name]);


            // Ensure Database Exists Before Running Migrations
            $this->runTenantMigrations($tenant);


            Log::info('✅ Migrations executed successfully.');

            DB::commit();

            session()->flash('success', '🎉 Tenant created and migrations executed successfully!');

            $this->dispatch('notify', ...['type' => 'success', 'content' => "Migrations executed successfully for {$tenant->t_name}!"]);

            Log::info('🎉 Tenant setup completed.', ['tenant_id' => $tenant->id]);

            session()->flash('success', '🎉 Tenant created successfully! Enjoy the fireworks!');

            $this->dispatch('tenant-created');


//            return redirect()->route('dashboard');



        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('❌ Error during tenant setup.', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            session()->flash('error', '❌ Error: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * Run migrations on an existing database for the tenant.
     */
    protected function runTenantMigrations(Tenant $tenant)
    {
        try {
            // Check if the database exists before proceeding
            $dbExists = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$tenant->db_name]);

            if (!$dbExists) {
                throw new \Exception("Database '{$tenant->db_name}' does not exist.");
            }

            // Switch to the tenant connection
            TenantHelper::switchTenant($tenant->id);

            // Run Migrations for Tenant
            Artisan::call("aaran:migrate", [
                'tenant' => $tenant->t_name,
                '--fresh' => true
            ]);

            $this->dispatch('notify', ...['type' => 'success', 'content' => "Migrations executed successfully for {$tenant->t_name}!"]);


        } catch (\Exception $e) {
            throw new \Exception("Migration failed: " . $e->getMessage());
        }
    }

    #[Layout('Ui::components.layouts.web')]
    public function render()
    {
        return view('setup::tenant-setup-wizard', [
            'steps' => [
                'Tenant Details',
                'Database Setup',
                'Subscription & Security'
            ]
        ]);
    }
}
