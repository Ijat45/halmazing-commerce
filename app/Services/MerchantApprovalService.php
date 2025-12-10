<?php

namespace App\Services;

use App\Events\Merchant\MerchantApproved;
use App\Events\Merchant\MerchantRejected;
use App\Models\User;

class MerchantApprovalService
{
    /**
     * Approve a merchant application.
     */
    public function approve(User $merchant): void
    {
        if ($merchant->isMerchant()) {
            return;
        }

        $merchant->merchant_status = 'approved';
        $merchant->save();

        MerchantApproved::dispatch($merchant);
    }

    /**
     * Reject a merchant application.
     */
    public function reject(User $merchant): void
    {
        $merchant->merchant_status = 'rejected';
        $merchant->save();

        MerchantRejected::dispatch($merchant);
    }
}
