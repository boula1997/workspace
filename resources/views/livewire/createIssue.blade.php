<form>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="exampleFormControlInput5">Title:</label>
            <input type="text" class="form-control noHide" id="exampleFormControlInput5" placeholder="Enter Title" wire:model="title">
            @error('title') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput27">Code Links (May Add current task links):</label>
        <textarea name="ai_prompt" id="exampleFormControlInput27" class="form-control " cols="30" rows="3" wire:model="ai_prompt"></textarea>
        @error('ai_prompt') <span class="text-danger">{{ $message }}</span>@enderror
    </div>
    <button wire:click.prevent="store()" class="btn btn-success">Save</button>
</form>