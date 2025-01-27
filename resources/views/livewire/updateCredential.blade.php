<form>
    <input type="hidden" wire:model="post_id">
    <div class="row">
        <div class="form-group col-md-12">
            <label for="exampleFormControlInput5">Name:</label>
            <input type="text" class="form-control noHide" id="exampleFormControlInput5" placeholder="Enter Db_name"
                wire:model="db_name">
            @error('db_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="exampleFormControlInput5">Username:</label>
            <input type="text" class="form-control noHide" id="exampleFormControlInput5" placeholder="Enter db_username"
                wire:model="db_username">
            @error('db_username')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="exampleFormControlInput5">Password:</label>
            <input type="text" class="form-control noHide" id="exampleFormControlInput5" placeholder="Enter db_password"
                wire:model="db_password">
            @error('db_password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <button wire:click.prevent="update()" class="btn btn-dark">Update</button>
    <button wire:click.prevent="cancel()" class="btn btn-danger">Cancel</button>
</form>
