<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->where('role', 'user')
            ->withCount('orders');

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter durasi
        if ($request->filter == '30') {
            $query->where('created_at', '>=', now()->subDays(30));
        }
        if ($request->filter == '90') {
            $query->where('created_at', '>=', now()->subDays(90));
        }

        $customers = $query->paginate(10)->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::with(['orders' => function ($q) {
            $q->with('orderItems.product')->latest();
        }])->findOrFail($id);

        return view('admin.customers.show', compact('customer'));
    }

    // Bulk delete
    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        User::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', 'Selected customers deleted.');
    }

    // Bulk export
    public function bulkExport(Request $request)
    {
        $ids = explode(',', $request->ids);
        $customers = User::whereIn('id', $ids)->get();

        return response()->streamDownload(function () use ($customers) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Name', 'Email', 'Phone']);

            foreach ($customers as $customer) {
                fputcsv($file, [
                    $customer->name,
                    $customer->email,
                    $customer->phone ?? '-'
                ]);
            }

            fclose($file);
        }, 'customers.csv');
    }
}
