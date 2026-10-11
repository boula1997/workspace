{{-- App tabs this admin sees in the mobile/web app. $admin is null on the create page. --}}
<div class="col-md-12 mt-3">
    <div class="form-group">
        <label class="d-block">@lang('general.app_tabs')</label>
        <small class="text-muted d-block mb-2">@lang('general.app_tabs_hint')</small>
        <div class="row">
            @foreach (\App\Models\Admin::APP_TABS as $tab => $label)
                <div class="col-6 col-md-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="tab_{{ $tab }}"
                            name="tabs[{{ $tab }}]" value="1"
                            @checked(session()->hasOldInput() ? old("tabs.$tab") : ($admin?->{$tab} ?? in_array($tab, \App\Models\Admin::APP_TABS_ON_BY_DEFAULT, true)))>
                        <label class="form-check-label" for="tab_{{ $tab }}">{{ $label }}</label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
