<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ProductResource|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        try {
            $products = $this->service->all();
            return ProductResource::collection($products);
        } catch (Exception $e) {
            return $this->responseError($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return ProductResource|JsonResponse|\Illuminate\Support\MessageBag
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required | min:3',
                'price' => 'required | numeric',
                'visible' => 'required | boolean',
                'is_recurrence' => 'required | boolean',
                'payment_cycle' => 'required_if:is_recurrence,true | in:monthly,yearly',
            ]);

            if ($validator->fails()) {
                return $validator->errors();
            }

            $fields = $this->service->fields();
            $values = $request->only($fields);
            $product = $this->service->create($values);

            return new ProductResource($product);

        } catch (Exception $e) {
            return $this->responseError($e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return ProductResource|JsonResponse|\Illuminate\Support\MessageBag
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required | min:3',
                'price' => 'required | numeric',
                'visible' => 'required | boolean',
                'is_recurrence' => 'required | boolean',
                'payment_cycle' => 'required_if:is_recurrence,true | in:monthly,yearly',
            ]);

            if ($validator->fails()) {
                return $validator->errors();
            }

            $fields = $this->service->fields();
            $values = $request->only($fields);
            $product = $this->service->update($values, $id);

            return new ProductResource($product);
        } catch (Exception $e) {
            return $this->responseError($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return ProductResource|JsonResponse
     */
    public function destroy($id)
    {
        try {
            $product = $this->service->delete($id);
            return new ProductResource($product);
        } catch (Exception $e) {
            return $this->responseError($e);
        }
    }
}
