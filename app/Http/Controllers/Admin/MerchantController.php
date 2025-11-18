<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (! $user || ! $user->isAdmin()) {
            abort(403);
        }

        $pending = User::where('merchant_status', 'pending')->orderBy('created_at', 'desc')->get();

        return view('pages.admin.merchants.index', ['pending' => $pending]);
    }

    public function approve(User $user)
    {
        $actor = Auth::user();
        if (! $actor || ! $actor->isAdmin()) {
            abort(403);
        }

        $user->merchant_status = 'approved';
        $user->save();

        return redirect()->back()->with('success', 'Merchant approved.');
    }

    public function reject(User $user)
    {
        $actor = Auth::user();
        if (! $actor || ! $actor->isAdmin()) {
            abort(403);
        }

        $user->merchant_status = 'rejected';
        $user->save();

        return redirect()->back()->with('success', 'Merchant rejected.');
    }
}
