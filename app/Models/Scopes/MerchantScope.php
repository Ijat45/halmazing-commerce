<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class MerchantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (app()->runningInConsole()) {
            return;
        }

        $user = auth()->user();

        // If no user is logged in, or user is Admin, do NOT filter.
        // If user is Merchant, filter by vendor_id.
        // Standard users (buyers) generally view products via public methods which might bypassing this 
        // OR we want them to see ALL products. 
        // WAIT: Buyers should see ALL products. This scope protects MERCHANT views.
        // We need to be careful here. Global Scopes apply to FRONTEND too unless removed.

        // This scope is intended for "Tenant Isolation", usually this means Backend.
        // But for a marketplace, "Product::all()" on frontend should show everything.
        // So we only apply this if the user IS A MERCHANT and NOT an ADMIN.
        // But wait, if a Merchant visits the homepage, they should see other people's products?
        // Typically a Merchant viewing "My Products" (Backend) vs "Marketplace" (Frontend).

        // The user's request was "no merchants see other merchants products".
        // This implies the ADMIN/Back-office context.
        // If we apply this globally, a Merchant logged in effectively sees a filtered Marketplace.

        // However, looking at the user's snippet:
        // if ($user && !$user->isAdmin()) { $query->where('vendor_id', $user->id); }
        // This implies that if you are a User (Buyer), you also get filtered? 
        // No, Buyers are not Admins, so they would be filtered to "vendor_id = their_id", seeing nothing!
        // So we must check if user is a MERCHANT.

        if ($user && $user->isMerchant() && !$user->isAdmin()) {
            // Check if we are in a "merchant" route or context? 
            // Or is the "Bulletproof" request implying that Merchants *never* see other products?
            // Assuming this is for the definition of "Product Management". 
            // Let's refine:
            // If we are strictly "Tenancy", then yes.
            // But for a Public Marketplace, we usually rely on "Published" scopes.

            // To be SAFE and follow instructions:
            // We apply this scope ONLY if we are in the Merchant Dashboard context?
            // OR we check if the request is an "admin/merchant" route?

            // Actually, the user's specific code was: 
            // if ($user && !$user->isAdmin()) { ... }
            // This code is dangerous for a public frontend if generic users trigger it.

            // Better implementation for a MARKETPLACE:
            // Only filter if request path starts with 'merchant/' or 'api/merchant'.
            // OR, cleaner: define it but only register it in the MerchantMiddleware?
            // NOTE: Global Scopes are usually registered in Model::booted().

            // Let's do this: check route prefix using request().
            if (request()->is('merchant/*') || request()->is('api/merchant/*')) {
                $builder->where('vendor_id', $user->id);
            }
        }
    }
}
