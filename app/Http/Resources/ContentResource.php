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
            'thumbnail' => $this->thumbnail, // ambil accessor
            'images'    => $this->images->map(fn($img) => [
                'id'  => $img->id,
                'url' => asset('storage/' . $img->path),
            ]),
            'created_at' => $this->created_at->format('d M Y'),
        ];
    }
}
