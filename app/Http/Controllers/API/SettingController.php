<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class SettingController extends Controller
{
    private $setting;
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function index()
    {
        try {
            $data['settings'] = new SettingResource($this->setting->first());
            return successResponse($data);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }


        public function update(Request $request)
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
}
