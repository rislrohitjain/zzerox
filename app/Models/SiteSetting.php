<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    public static function get($key, $default = null)
    {
        try {
            $settings = Cache::rememberForever('site_settings_all', function () {
                return static::pluck('value', 'key')->all();
            });

            return $settings[$key] ?? $default;
        } catch (\Throwable $e) {
            return $default;
        }
    }

    public static function set($key, $value, $group = 'general')
    {
        try {
            $setting = static::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
            Cache::forget('site_settings_all');
            return $setting;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function clearCache()
    {
        try {
            Cache::forget('site_settings_all');
        } catch (\Throwable $e) {}
    }
}
