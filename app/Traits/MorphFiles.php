<?php

namespace App\Traits;

use App\Models\File as ModelsFile;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\File;

trait  MorphFiles
{
    public function files(): MorphMany
    {
        return $this->morphMany(ModelsFile::class, 'fileable');
    }

    public function uploadFiles()
    {
        if (request()->hasFile('images')) {
            return response()->json("boula test true");
            $files = request()->file('images');
            foreach ($files as $file) {
                $data['image'] = $file->store('images');
                $file->move('images', $data['image']);
                $this->files()->create(['url' => $data['image']]);
            }
        }
            return response()->json("boula test out");

    }
    public function updateFiles()
    {  
        $this->deleteSpecificFiles();
        if (request()->hasFile('images')) {
            $files = request()->file('images');
            foreach ($files as $file) {
                $data['image'] = $file->store('images');
                $file->move('images', $data['image']);
                $this->files()->create(['url' => $data['image']]);
            }
           
        }
    }   

    public function deleteFiles()
    {
        if ($this->files()) {
            foreach ($this->files() as $file) {
                if(file_exists($file->url))
                  File::delete($file->url);
                if(isset($file->url))
                  $file->delete();
            }
        }
    }

    public function deleteSpecificFiles()
    {
        if (request()->has('delimages')) {
            foreach (request()->delimages as $id) {
                $image = ModelsFile::find($id);
                if(file_exists($image->url))
                  File::delete($image->url);
                if(isset($image->url))
                  $image->delete();
            }
        }
    }
}
