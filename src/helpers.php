<?php

use Illuminate\Support\Str;


// Get Files List
if (!function_exists('getFiles')) {
    function getFiles(string $dir)
    {
        if (!file_exists($dir)) return [];
        return array_values(array_diff(scandir($dir), ['.', '..']));
    }
}

// Module Path
if (!function_exists('module_path')) {
    function module_path(?string $module = null, ?string $extra = null)
    {
        if (!$module) return app_path('Modules');
        if ($extra) $extra = implode(DIRECTORY_SEPARATOR, explode('/', $extra));

        // Sub-Module
        if (strpos($module, '/') !== false) {
            $module = explode('/', $module);
            $moduleName = array_shift($module);

            $extra = trim(implode(DIRECTORY_SEPARATOR, $module) . DIRECTORY_SEPARATOR . $extra, '/');
            $module = $moduleName;
            unset($moduleName);
        }

        return app_path('Modules') . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $extra;
    }
}

// Modules List
if (!function_exists('modules')) {
    function modules()
    {
        $dir = module_path();
        return file_exists($dir) ? getFiles($dir) : [];
    }
}

// Config Path
if (!function_exists('module_config_path')) {
    function module_config_path(string $module, ?string $extra = null)
    {
        return module_path($module, 'config' . ($extra ? '/' . $extra : null));
    }
}

// Database Path
if (!function_exists('module_database_path')) {
    function module_database_path(string $module, ?string $extra = null)
    {
        return module_path($module, 'database' . ($extra ? '/' . $extra : null));
    }
}

// Resources Path
if (!function_exists('module_resource_path')) {
    function module_resource_path(string $module, ?string $extra = null)
    {
        return module_path($module, 'resources' . ($extra ? '/' . $extra : null));
    }
}

// Convert studly to slug
if (!function_exists('studlyToSlug')) {
    function studlyToSlug(string $text)
    {
        return Str::slug(strtolower(trim(preg_replace('/[A-Z-]/', ' $0', $text))));
    }
}
