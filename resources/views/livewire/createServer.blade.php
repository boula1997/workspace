<form>
    <div class="container-fluid d-flex flex-wrap align-items-center">
        <div class="w-25 me-2">
            <input type="text" class="form-control noHide" id="exampleFormControlInput5" placeholder="task1,task2,task3" wire:model="title">
        </div>
        <div class="me-2">
            <select name="employee" id="" class="form-control noHide bg-black text-white" wire:model="employee">
                <option value="">Select</option>
                <option value="both">Both</option>
                <option value="boula">Boula</option>
                <option value="ibrahim">Ibrahim</option>
                <option value="ahmed">Ahmed</option>
                <option value="zeyad">Zeyad</option>
                <option value="melad">Melad</option>
            </select>
        </div>
        <div class="me-2">
            <select name="project" id="" class="form-control noHide bg-black text-white" wire:model="project">
                <option value="">Select</option>
                <option value="all">All</option>
                @foreach (activeWebsites() as $project)
                    <option value="{{ $project->client }}">{{ $project->client }}</option>
                @endforeach
            </select>
        </div>
        <div class="me-2">
            <input type="checkbox" value="1" name="personal" id="personal" class="" wire:model="personal">
            <label for="personal">Personal:</label>
        </div>
        <div class="me-2">
            <button wire:click.prevent="store()" class="btn btn-success mx-2">Save</button>
        </div>
        <div class="me-2">
            <input wire:model="searchFilter" type="text" class="form-control noHide" placeholder="Search by title, project, employee...">
        </div>
        <div class="me-2">
            <input type="checkbox" id="searchFinishedTasks" class="" wire:model="searchFinishedTasks">
            <label for="searchFinishedTasks">Finished:</label>
        </div>
        <div class="me-2">
            <input type="checkbox" id="searchPersonalTasks" class="" wire:model="searchPersonalTasks">
            <label for="searchPersonalTasks">Personal:</label>
        </div>
        <div class="me-2">
            <input type="checkbox" id="searchNecessaryTasks" class="" wire:model="searchNecessaryTasks">
            <label for="searchNecessaryTasks">Necessary:</label>
        </div>
        <div class="me-2">
            <input type="checkbox" id="searchAutomationTasks" class="" wire:model="searchAutomationTasks">
            <label for="searchAutomationTasks">Automation:</label>
        </div>
        <div class="me-2">
            <input type="checkbox" id="searchEasyTasks" class="" wire:model="searchEasyTasks">
            <label for="searchEasyTasks">Easy:</label>
        </div>
        {{-- <div class="me-2">
            <button wire:click.prevent="store()" class="btn btn-success mx-2">Filter</button>
        </div>         --}}
    </div>
</form>
