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
    // Check for both 'images' and 'images[]'
    if (request()->hasFile('images') || request()->hasFile('images[]')) {
        \Log::info('Files detected!');
        
        // Get files from either key
        $files = request()->hasFile('images') 
            ? request()->file('images') 
            : request()->file('images[]');
        
        // Handle single file case
        if (!is_array($files)) {
            $files = [$files];
        }
        
        foreach ($files as $file) {
            if ($file) {
                // Store the file
                $path = $file->store('images', 'public');
                
                // Create file record
                $this->files()->create(['url' => $path]);
            }
        }
        
        return response()->json("Files uploaded: " . count($files));
    }
    
    \Log::info('No files detected');
    return response()->json("No files found");
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
