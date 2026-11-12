{{-- Index-tab modules this admin sees in the app's dropdown. $admin is null on the create page.
     Super admins see every module whatever is ticked here. --}}
@php
    $indexModules = \App\Models\Category::where('type', 'modules')->orderBy('title')->get(['id', 'title']);
    $ticked = session()->hasOldInput()
        ? array_map('intval', (array) old('index_modules', []))
        : ($admin
            ? $admin->indexModules()->pluck('categories.id')->all()
            : $indexModules->whereIn('title', \App\Models\Admin::DEFAULT_INDEX_MODULES)->pluck('id')->all());
@endphp
<div class="col-md-12 mt-3">
    <div class="form-group">
        <input type="hidden" name="index_modules_shown" value="1">
        <label class="d-block">@lang('general.index_modules')</label>
        <small class="text-muted d-block mb-2">@lang('general.index_modules_hint')</small>
        <div class="row">
            @foreach ($indexModules as $module)
                <div class="col-6 col-md-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="module_{{ $module->id }}"
                            name="index_modules[]" value="{{ $module->id }}"
                            @checked(in_array($module->id, $ticked, true))>
                        <label class="form-check-label" for="module_{{ $module->id }}">{{ $module->title }}</label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
