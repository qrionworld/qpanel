<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'body'      => $this->body,
            'thumbnail' => $this->thumbnail, // accessor

            // tampilkan category_id & nama kategori
            'category_id'   => $this->category_id,
            'category_name' => $this->category?->name, // pakai null safe biar ga error kalau kosong

            'images'    => $this->images->map(fn($img) => [
                'id'  => $img->id,
                'url' => asset('storage/' . $img->path),
            ]),

            'created_at' => $this->created_at->format('d M Y'),
        ];
    }
}
