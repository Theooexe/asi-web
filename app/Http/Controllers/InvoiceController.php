<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function search(Request $request)
    {
        $query = Invoice::with(['client', 'tools']);

        if ($request->filled('email')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->email . '%');
            });
        }

        if ($request->filled('price_higher_than')) {
            $query->where('total_amount', '>=', $request->price_higher_than);
        }

        if ($request->filled('price_lower_than')) {
            $query->where('total_amount', '<=', $request->price_lower_than);
        }

        if ($request->filled('tool_name')) {
            $query->whereHas('tools', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->tool_name . '%');
            });
        }

        if ($request->filled('send_date')) {
            $query->whereDate('send_at', $request->send_date);
        }

        if ($request->filled('acquitted')) {
            if ($request->acquitted === 'yes') {
                $query->whereNotNull('acquitted_at');
            } elseif ($request->acquitted === 'no') {
                $query->whereNull('acquitted_at');
            }
        }

        $invoices = $query->withCount('tools')->paginate(10)->appends($request->query());

        return view('search', compact('invoices'));
    }
}
