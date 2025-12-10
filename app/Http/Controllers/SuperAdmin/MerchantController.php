<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\MerchantApprovalService;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function __construct(protected MerchantApprovalService $approvalService)
    {
    }

    public function index()
    {
        $pending = User::where('merchant_status', 'pending')->latest()->get();
        // We can also fetch approved/rejected for a full list if needed
        $approved = User::where('merchant_status', 'approved')->latest()->take(10)->get();

        return view('pages.superadmin.merchants.index', compact('pending', 'approved'));
    }

    public function approve(User $user)
    {
        $this->approvalService->approve($user);
        return back()->with('success', 'Merchant approved successfully.');
    }

    public function reject(User $user)
    {
        $this->approvalService->reject($user);
        return back()->with('success', 'Merchant rejected.');
    }
}
