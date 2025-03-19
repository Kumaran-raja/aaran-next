<?php

namespace Aaran\Core\Tenant\Http\Controllers;

use Aaran\Core\Tenant\Models\Tenant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|unique:tenants,name',
            'domain'  => 'required|unique:tenants,domain',
        ]);

        $database = 'tenant_' . strtolower(str_replace(' ', '_', $request->name));

        $tenant = Tenant::create([
            'name'    => $request->name,
            'domain'  => $request->domain,
            'database'=> $database,
            'status'  => 'active',
        ]);

        return response()->json(['message' => 'Tenant created successfully', 'tenant' => $tenant]);
    }
}

