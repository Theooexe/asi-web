<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $order = $request->query('order', 'asc');
        $invoices = Invoice::orderBy('total_amount', $order)->paginate(10);

        return view('invoices.index', ['invoices' => $invoices, 'order' => $order]);
    }
}
