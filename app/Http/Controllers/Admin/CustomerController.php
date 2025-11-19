<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->withCount('orders');

        // ========== SEARCH ==========
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        // ========== FILTER ==========
        if ($request->filter === '30') {
            $query->where('created_at', '>=', now()->subDays(30));
        } elseif ($request->filter === '90') {
            $query->where('created_at', '>=', now()->subDays(90));
        }

        $customers = $query->get();

        return view('admin.customers.index', compact('customers'));
    }

    public function show(\App\Models\User $customer)
    {
        $customer->load('orders');

        return view('admin.customers.show', compact('customer'));
    }


    public function bulkDelete(Request $request)
    {
        User::whereIn('id', $request->ids)->delete();

        return back()->with('success', 'Selected customers deleted.');
    }

    public function bulkExport(Request $request)
    {
        $customers = User::whereIn('id', $request->ids)->get();

        $csv = "Name,Email,Phone,Orders\n";

        foreach ($customers as $c) {
            $csv .= "{$c->name},{$c->email},{$c->phone}," . $c->orders()->count() . "\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="customers.csv"');
    }

    public function exportCsv()
    {
        $customers = User::withCount('orders')->get();
        $csv = "\xEF\xBB\xBF";
        $csv = "Name,Email,Phone,Orders\n";

        foreach ($customers as $c) {
            $csv .= "{$c->name},{$c->email},{$c->phone}," . $c->orders_count . "\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="all_customers.csv"');
    }
}
