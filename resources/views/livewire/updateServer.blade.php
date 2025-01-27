<form>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="title">Title:</label>
            <input type="text" class="form-control noHide" id="title" placeholder="Enter Title" wire:model="title">
            @error('title') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        
        <div class="form-group col-md-1">
            <label for="employee">Employee:</label>
            <select name="employee" id="employee" class="form-control noHide bg-black text-white" wire:model="employee">
                <option value="">Select</option>
                <option value="both">Both</option>
                <option value="boula">Boula</option>
                <option value="ibrahim">Ibrahim</option>
                <option value="ahmed">Ahmed</option>
                <option value="zeyad">Zeyad</option>
                <option value="melad">Melad</option>
            </select>
            @error('employee') <span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group col-md-1">
            <label for="project">Project:</label>
            <select name="project" id="project" class="form-control noHide bg-black text-white" wire:model="project">
                <option value="">Select</option>
                <option value="all">All</option>
                @foreach (activeWebsites() as $project)
                <option value="{{ $project->client }}">{{ $project->client }}</option>
                @endforeach
            </select>
            @error('project') <span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group col-md-1 mt-4">
            <input type="checkbox" value="1" name="personal" id="personal" class="mt-3" wire:mode   l="personal">
            <label for="personal">Personal:</label>
        </div>

        <div class="form-group col-md-2">
            <button wire:click.prevent="update()" class="btn btn-warning mt-4 mx-2">Update</button>
        </div>
    </div>
</form>
