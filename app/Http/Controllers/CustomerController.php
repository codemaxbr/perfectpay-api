<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Services\CustomerService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    private CustomerService $service;

    public function __construct(CustomerService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index()
    {
        try {
            $customers = $this->service->all();
            return CustomerResource::collection($customers);
        } catch (Exception $e) {
            return $this->responseError($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CustomerResource|JsonResponse|\Illuminate\Support\MessageBag
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required | min:3',
                'email' => 'required | email | unique:customers,email',
                'phone_number' => 'required | numeric',
                'cpf_cnpj' => 'required | numeric',
                'zipcode' => 'numeric',
                'street' => 'required_with:zipcode',
                'number' => 'required_with:zipcode',
                'neighborhood' => 'required_with:zipcode',
                'city' => 'required_with:zipcode',
                'state' => 'required_with:zipcode',
            ]);

            if ($validator->fails()) {
                return $validator->errors();
            }

            $fields = $this->service->fields();
            $values = $request->only($fields);
            $customer = $this->service->create($values);

            return new CustomerResource($customer);
        } catch (Exception $e) {
            return $this->responseError($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
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
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        //
    }
}
