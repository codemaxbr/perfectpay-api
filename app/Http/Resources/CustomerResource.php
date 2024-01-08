<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $customer = [
            'id' => (int) $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => (int) $this->phone_number,
            'external_id' => $this->external_id,
            'created_at' => Carbon::create($this->created_at)->format('Y-m-d H:i:s'),
            'address' => $this->address,
        ];

        switch ($request->method()) {
            case 'GET': $response = $customer;
            break;

            case 'POST': $response = [
                'status' => true,
                'message' => 'Cliente criado com sucesso!',
                'customer' => $customer
            ];
            break;

            case 'PUT': $response = [
                'status' => true,
                'message' => 'Cliente atualizado com sucesso!',
                'customer' => $customer
            ];
            break;

            case 'DELETE': $response = [
                'status' => true,
                'message' => 'Cliente removido com sucesso!'
            ];
        }

        return $response;
    }
}
