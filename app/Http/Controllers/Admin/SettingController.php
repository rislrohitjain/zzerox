<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->all();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except(['_token', 'site_logo_header', 'site_logo_footer', 'site_favicon']);

        // Handle Site Maintenance Toggle (checkbox)
        $maintenanceState = $request->has('site_under_maintenance') ? '1' : '0';
        $inputs['site_under_maintenance'] = $maintenanceState;
        SiteSetting::set('site_under_maintenance', $maintenanceState);

        // Handle Header Logo Upload
        if ($request->hasFile('site_logo_header')) {
            $file = $request->file('site_logo_header');
            $fileName = 'logo_header_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img'), $fileName);
            SiteSetting::set('site_logo_header', 'img/' . $fileName);
            SiteSetting::set('site_logo', 'img/' . $fileName);
        }

        // Handle Footer Logo Upload
        if ($request->hasFile('site_logo_footer')) {
            $file = $request->file('site_logo_footer');
            $fileName = 'logo_footer_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img'), $fileName);
            SiteSetting::set('site_logo_footer', 'img/' . $fileName);
        }

        // Handle Site Favicon Upload
        if ($request->hasFile('site_favicon')) {
            $file = $request->file('site_favicon');
            $fileName = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img'), $fileName);
            SiteSetting::set('site_favicon', 'img/' . $fileName);
        }

        foreach ($inputs as $key => $value) {
            SiteSetting::set($key, $value);
        }

        SiteSetting::clearCache();
        Cache::flush();

        $statusMsg = ($maintenanceState === '1')
            ? 'MAINTENANCE MODE IS NOW ACTIVE! Visitors will see the maintenance screen. Logged-in admins can still access the site and admin panel.'
            : 'Maintenance mode disabled. Site is live for all visitors.';

        return redirect()->back()->with('success', $statusMsg);
    }
}
