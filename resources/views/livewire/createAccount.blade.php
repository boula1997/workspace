<form>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="exampleFormControlInput5">title:</label>
            <input type="text" class="form-control noHide" id="exampleFormControlInput5" placeholder="Enter title" wire:model="title">
            @error('title') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="exampleFormControlInput7">Deadline:</label>
            <input type="date" class="form-control noHide" id="exampleFormControlInput7" placeholder="Enter Deadline" wire:model="deadline">
            @error('deadline') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group col-md-6">
            <label for="exampleFormControlInput132">Last Transaction:</label>
            <input type="date" class="form-control noHide" id="exampleFormControlInput132" placeholder="Enter Last Transaction" wire:model="lastTransaction">
            @error('lastTransaction') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <label for="exampleFormControlInput6">Cost:</label>
            <input type="number" class="form-control noHide" id="exampleFormControlInput6" placeholder="Enter Cost" wire:model="cost">
            @error('cost') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group col-md-4">
            <label for="exampleFormControlInput7">Payed:</label>
            <input type="number" class="form-control noHide" id="exampleFormControlInput9" placeholder="Enter Payed" wire:model="payed">
            @error('payed') <span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group col-md-4">
            <label for="exampleFormControlInput9">Fees:</label>
            <input type="number" class="form-control noHide" id="exampleFormControlInput9" placeholder="Enter Fees" wire:model="fees">
            @error('fees') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="form-group">
        <label for="exampleFormControlInput27">Code Links (May Add current task links):</label>
        <textarea name="codeLinks" id="exampleFormControlInput27" class="form-control " cols="30" rows="3" wire:model="codeLinks"></textarea>
        @error('codeLinks') <span class="text-danger">{{ $message }}</span>@enderror
    </div>


    <button wire:click.prevent="store()" class="btn btn-success">Save</button>
</form>