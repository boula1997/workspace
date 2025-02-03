<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\File;


class SettingController extends Controller
{
    private $setting;
    function __construct(Setting $setting)
    {
        $this->middleware('permission:setting-list|setting-create|setting-edit|setting-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:setting-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:setting-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:setting-delete', ['only' => ['destroy']]);
        $this->setting = $setting;
    }


    public function setting(Request $request)
    {
        try {
            $setting = $this->setting->first();
            $data = $request->except('0', '1', 'profile_avatar_remove');
            if ($request->hasFile('logo'))
                {File::delete($setting->logo);
                $file = $request->file('logo');
                $data['logo'] = $request->logo->store('images');
                $file->move('images', $data['logo']); }

            if ($request->hasFile('tab')){
                File::delete($setting->tab);
                $file2 = $request->file('tab');
                $data['tab'] = $request->tab->store('images');
                $file2->move('images', $data['tab']);
            }
            if ($request->hasFile('white_logo')){
                File::delete($setting->white_logo);
                $file2 = $request->file('white_logo');
                $data['white_logo'] = $request->white_logo->store('images');
                $file2->move('images', $data['white_logo']);
            }
            $setting->update($data);
            return redirect()->route('edit.setting')
                ->with('success', trans('general.update_successfully'));
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }

    public function editSetting()
    {
        try {
            $setting = $this->setting->first();
            return view('admin.crud.setting.setting', compact('setting'));
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
    public function filterDate(Request $request)
    {
        try {
            $setting = $this->setting->first();
            $setting->start_date=$request->start_date;
            $setting->end_date=$request->end_date;
            $setting->save();
            return redirect()->back()->with('success', trans('general.update_successfully'));
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
}
