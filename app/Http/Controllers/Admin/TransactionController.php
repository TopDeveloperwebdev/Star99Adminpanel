<?php

namespace App\Http\Controllers\Admin;

use App\history;
use App\Currency;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTransactionRequest;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\IncomeSource;
use App\Project;
use App\Transaction;
use App\TransactionType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = history::all();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {

        return view('admin.transactions.create');
    }

    public function store(StoreTransactionRequest $request)
    {
        $currency = history::create($request->all());

        return redirect()->route('admin.transactions.index');
    }

    public function edit(history $currency)
    {
        return view('admin.transactions.edit', compact('currency'));
    }

    public function update(Request $request, history $currency)
    {

        $currency->update($request->all());

        return redirect()->route('admin.transactions.index');
    }

    public function show(history $currency)
    {
        return view('admin.transactions.show', compact('currency'));
    }

    public function destroy(history $currency)
    {

        $currency->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
