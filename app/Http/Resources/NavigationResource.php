<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NavigationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
$link = $this->link;

// Check if the link contains 'www'
if (strpos($link, 'www') !== false) {   
    $link .= '?user=' . urlencode($this->user) . '&password=' . urlencode($this->password);
}

        return [
            "id" => $this->id,
             'link' => $link,

            'title'=>$this->title,

            'user'=>$this->user,

            'password'=>$this->password,
        ];
    }
}
