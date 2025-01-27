<form>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="exampleFormControlInput5">Name:</label>
            <input type="text" class="form-control noHide" id="exampleFormControlInput5" placeholder="Enter Name" wire:model="db_name">
            @error('db_name') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="exampleFormControlInput5">Username:</label>
            <input type="text" class="form-control noHide" id="exampleFormControlInput5" placeholder="Enter Name" wire:model="db_username">
            @error('db_username') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="exampleFormControlInput5">Password:</label>
            <input type="text" class="form-control noHide" id="exampleFormControlInput5" placeholder="Enter Name" wire:model="db_password">
            @error('db_password') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>



    <button wire:click.prevent="store()" class="btn btn-success">Save</button>
</form>