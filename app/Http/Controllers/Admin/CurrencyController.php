<?php

namespace App\Http\Controllers\Admin;

use App\Bet_set;
use App\Currency;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCurrencyRequest;
use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Bet_set::all();
        return view('admin.currencies.index', compact('currencies'));
    }

    public function create()
    {

        return view('admin.currencies.create');
    }

    public function store(StoreCurrencyRequest $request)
    {
        $currency = Bet_set::create($request->all());

        return redirect()->route('admin.currencies.index');
    }

    public function edit(Bet_set $currency)
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    public function update(UpdateCurrencyRequest $request, Bet_set $currency)
    {

        $currency->update($request->all());

        return redirect()->route('admin.currencies.index');
    }

    public function show(Bet_set $currency)
    {
        return view('admin.currencies.show', compact('currency'));
    }

    public function destroy(Bet_set $currency)
    {
        abort_if(Gate::denies('currency_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $currency->delete();

        return back();
    }

    public function massDestroy(MassDestroyCurrencyRequest $request)
    {
        Bet_set::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
