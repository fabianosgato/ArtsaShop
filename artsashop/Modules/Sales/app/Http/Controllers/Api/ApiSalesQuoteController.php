<?php

namespace Modules\Sales\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Idea\Framework\Debug;
use Idea\Framework\Repository\Sales\SalesOrderQuoteAddressRepository;
use Idea\Framework\Repository\Sales\SalesOrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\Customers\Services\CheckoutCustomerService;
use Modules\Sales\Emails\SalesOrderCreatedMail;

class ApiSalesQuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $quoteAddress = SalesOrderQuoteAddressRepository::getQuoteAddressByQuote(
            quoteId: 1
        );

        dd($quoteAddress);

        Mail::to('fabianogattoti@gmail.com')
            ->send(new SalesOrderCreatedMail(
                SalesOrderRepository::getOrder(14)->first())
            );

//        event(new OrderCreated(
//            SalesOrderRepository::getOrder(4)->first()
//        ));

        return response()->json([
            'Email enviado'
        ]);

    }

    /**
     * Atualiza uma Quote no Sistema
     */
    public function updateQuote(Request $request)
    {

        if ($request->accepts(['application/json'])) {

            // Array data vindos da API
            $payload = $request->all();

            /** 1. Resolve ou cria cliente */
            $customer = CheckoutCustomerService::resolveOrCreate($payload);


            Debug::Dump($customer->customer_id);

            dd($customer);

        }

        return response()->json([]);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        //

        return response()->json([]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //

        return response()->json([]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //

        return response()->json([]);
    }
}
