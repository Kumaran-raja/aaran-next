<?php

namespace Aaran\Core\Tenant\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeatureManager
{
    /**
     * Check if a feature is enabled for the authenticated tenant.
     */
    public static function hasFeature(string $featureCode): bool
    {
        $tenant = Auth::user()->tenant ?? null;
        if (!$tenant) {
            return false;
        }

        return in_array($featureCode, static::getTenantFeatures($tenant->id, $tenant->industry_code));
    }

    /**
     * Get enabled features for a tenant (cached).
     */
    private static function getTenantFeatures(int $tenantId, ?string $industryCode): array
    {
        return Cache::remember("tenant_{$tenantId}_features", 3600, function () use ($tenantId, $industryCode) {
            // Fetch tenant-specific enabled features
            $tenantFeatures = DB::table('tenants')->where('id', $tenantId)->value('enabled_features');
            $tenantFeatures = json_decode($tenantFeatures ?? '[]', true);

            // Fetch industry-based features
            $industryFeatures = DB::table('industry_features')
                ->join('features', 'industry_features.feature_id', '=', 'features.id')
                ->join('industries', 'industry_features.industry_id', '=', 'industries.id')
                ->where('industries.code', $industryCode)
                ->where('industry_features.is_active', true)
                ->where('features.is_active', true)
                ->pluck('features.code')
                ->toArray();

            return array_unique(array_merge($industryFeatures, $tenantFeatures));
        });
    }

    /**
     * Enable a feature for a specific tenant.
     */
    public static function enableFeature(int $tenantId, string $featureCode): void
    {
        $features = static::getTenantFeatures($tenantId, null);
        if (!in_array($featureCode, $features)) {
            $features[] = $featureCode;
            DB::table('tenants')->where('id', $tenantId)->update(['enabled_features' => json_encode($features)]);
            static::clearCache($tenantId);
        }
    }

    /**
     * Disable a feature for a specific tenant.
     */
    public static function disableFeature(int $tenantId, string $featureCode): void
    {
        $features = array_diff(static::getTenantFeatures($tenantId, null), [$featureCode]);
        DB::table('tenants')->where('id', $tenantId)->update(['enabled_features' => json_encode(array_values($features))]);
        static::clearCache($tenantId);
    }

    /**
     * Clear cached features for a tenant.
     */
    private static function clearCache(int $tenantId): void
    {
        Cache::forget("tenant_{$tenantId}_features");
    }
}
