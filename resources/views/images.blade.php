



<div class="row">
    <form action="{{ route('upload.images') }}" method="post" enctype="multipart/form-data">
        @csrf
  
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <div class="col-md-6">
            <h3>Upload your images</h3>
            <input type="file" id="files" name="files[]" multiple /></br>
            <div class="form-group mt-2">
                <input class=" text-white" type="checkbox" name="overwrite" id="overwrite">
                <p class="d-inline">overwrite paths</p>
            </div>
            <button type="submit" class="btn btn-warning">Upload</button>
        </div>
        <div class="col-md-6">
            <p>Note: Get project images and downloaded images to this workspace and start editing and replacing paths in
                porject code and after that copy all images in automation project images folder to your project images
                folder</p>
        </div>
    </form>
</div>


<div class="row  overflow-x-hidden">
    @foreach ($images as $image)
        <div class="col-md-2  "><img style="height: 300px !important; color:black;"  src="{{ asset($image->url) }}"
                class="  img-fluid p-3" alt="{{ $image->url }}"></div>
    @endforeach
</div>
