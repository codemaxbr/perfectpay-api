<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product = [
            'id' => (int) $this->id,
            'name' => $this->name,
            'price' => (float) $this->price,
            'description' => $this->description,
            'visible' => (bool) $this->visible,
            'is_recurrence' => (bool) $this->is_recurrence,
            'payment_cycle' => $this->payment_cycle,
            'external_id' => $this->external_id,
            'created_at' => Carbon::create($this->created_at)->format('Y-m-d H:i:s'),
        ];

        switch ($request->method()) {
            case 'GET': $response = $product;
            break;

            case 'POST': $response = [
                'status' => true,
                'message' => 'Produto criado com sucesso!',
                'product' => $product
            ];
            break;

            case 'PUT': $response = [
                'status' => true,
                'message' => 'Produto atualizado com sucesso!',
                'product' => $product
            ];
            break;

            case 'DELETE': $response = [
                'status' => true,
                'message' => 'Produto removido com sucesso!'
            ];
        }

        return $response;
    }
}
