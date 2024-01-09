<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $order = [
            'id' => $this->id,
            'customer' => $this->customer,
            'product' => $this->product,
            'status' => $this->status,
            'amount' => $this->amount,
            'due' => $this->due,
            'external_id' => $this->external_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'payment' => $this->payment
        ];

        switch ($request->method()) {
            case 'GET': $response = $order;
                break;

            case 'POST': $response = [
                'status' => true,
                'message' => 'Pedido criado com sucesso!',
                'order' => $order
            ];
                break;

            case 'PUT': $response = [
                'status' => true,
                'message' => 'Pedido alterado com sucesso!',
                'order' => $order
            ];
                break;

            case 'DELETE': $response = [
                'status' => true,
                'order' => 'Pedido removido com sucesso!'
            ];
        }
        return $response;
    }
}
