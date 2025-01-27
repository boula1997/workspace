<form>
    <div class="">
        <div class="row">
            <div class="form-group col-md-12">
                <label for="exampleFormControlInput5">Type:</label>
                <select name="type" id="" class="form-control noHide bg-black text-white" wire:model="type">
                    <option value="">Select</option>
                    <option value="all">All</option>
                    <option value="input">Input</option>
                    <option value="inputtrans">Inputtrans</option>
                    <option value="textarea">Textarea</option>
                    <option value="textareatrans">Textareatrans</option>
                    <option value="select">Select</option>
                    <option value="multiselect">Multiselect</option>
                    <option value="staticselect">Static Select</option>
                    <option value="multistaticselect">Multi Static Select</option>
                    <option value="radio">Radio</option>
                    <option value="file">File</option>
                    <option value="multifile">Multifile</option>
                    <option value="image">Image</option>
                    <option value="multimage">Multimage</option>
                    <option value="date">Date</option>
                    <option value="time">Time</option>
                    <option value="datetime">Datetime</option>
                    <option value="number">Number</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="email">Email</option>
                    <option value="tel">Tel</option>
                    <option value="url">Url</option>
                </select>
                @error('type') <span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput5">Title:</label>
                <select name="title" id="" class="form-control noHide bg-black text-white" wire:model="title">
                    <option value="">Select</option>
                    <option value="index1">Index1</option>
                    <option value="index2">Index2</option>
                    <option value="create">Create</option>
                    <option value="edit">Edit</option>
                    <option value="show">Show</option>
                    <option value="resource">Resource</option>
                    <option value="request">Request</option>
                    <option value="model">Model</option>
                    <option value="seeder">Seeder</option>
                    <option value="migration">Migration</option>
                    <option value="json">Json</option>

                </select>
                @error('title') <span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput5">Stack:</label>
                <select name="stack" id="" class="form-control noHide bg-black text-white" wire:model="stack">
                    <option value="">Select</option>
                    <option value="DashAloo">DashAloo</option>
                    <option value="dashfastkart">DashFastKart</option>
                    <option value="dashlaravel">Dashlaravel</option>
                    <option value="frontlaravel">Frontlaravel</option>
                    <option value="react">React</option>
                    <option value="reactNative">ReactNative</option>
                    <option value="template">Template</option>
                </select>
                @error('stack') <span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput2">Create:</label>
                <textarea name="script" id="" class="form-control noHide " cols="30" rows="2" wire:model="script"></textarea>
                @error('script') <span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>
    <button wire:click.prevent="store()" class="btn btn-success">Save</button>
</form>


