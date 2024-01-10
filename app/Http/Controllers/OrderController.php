<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class OrderController extends Controller
{
    private OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return OrderResource|JsonResponse|MessageBag
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customer_id' => 'required | exists:customers,id',
                'product_id' => 'required | exists:products,id',
                'payment_method' => 'required | in:CREDIT_CARD,PIX,BOLETO',
                'credit_card.number' => 'numeric | required_if:payment_method,CREDIT_CARD',
                'credit_card.expireMonth' => 'numeric | required_if:payment_method,CREDIT_CARD',
                'credit_card.expireYear' => 'numeric | required_if:payment_method,CREDIT_CARD',
                'credit_card.ccv' => 'numeric | required_if:payment_method,CREDIT_CARD',
                'credit_card.holder' => 'required_if:payment_method,CREDIT_CARD',
            ]);

            if ($validator->fails()) {
                return $validator->errors();
            }

            $fields = $this->service->fields();
            $fields = array_merge($fields, ['payment_method', 'credit_card']);
            $values = $request->only($fields);
            $values = array_merge($values, ['ip' => getUserIP()]);

            $order = $this->service->create($values);

            return new OrderResource($order);
        } catch (Exception $e) {
            return $this->responseError($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
