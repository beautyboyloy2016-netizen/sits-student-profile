<?php

use Illuminate\Support\Str;

if (! function_exists('current_branch_id')) {
    /**
     * Return the branch ID stored in the current session, or null if none selected.
     */
    function current_branch_id(): ?int
    {
        $id = session('current_branch_id');
        if ($id) {
            return (int) $id;
        }

        $user = auth()->user();

        return $user?->branch_id ? (int) $user->branch_id : null;
    }
}

if (! function_exists('create_slug')) {
    /**
     * description
     *
     * @param  string  $str
     * @return string lowercase
     */
    function create_slug($string)
    {
        $t = $string;
        $specChars = [
            ' ' => '-',
            '!' => '',
            '"' => '',
            '#' => '',
            '$' => '',
            '%' => '',
            '&' => 'and',
            '\'' => '',
            '(' => '',
            ')' => '',
            '*' => '',
            '+' => '',
            ',' => '',
            '₹' => '',
            '.' => '',
            '/-' => '',
            ':' => '',
            ';' => '',
            '<' => '',
            '=' => '',
            '>' => '',
            '?' => '',
            '@' => '',
            '[' => '',
            '\\' => '',
            ']' => '',
            '^' => '',
            '_' => '',
            '`' => '',
            '{' => '',
            '|' => '',
            '}' => '',
            '~' => '',
            '-----' => '-',
            '----' => '-',
            '---' => '-',
            '/' => '',
            '--' => '-',
            '/_' => '-',
        ];
        foreach ($specChars as $k => $v) {
            $t = str_replace($k, $v, $t);
        }

        return Str::lower($t);
    }
}

if (! function_exists('setting')) {
    function setting($key = false, $defaultValue = false)
    {
        $setting = app('Setting');
        if ($key === false) {
            return $setting;
        }

        $value = $setting->get($key);

        return $value ? $value : $defaultValue;
    }
}

if (! function_exists('assetUrl')) {
    function assetUrl(string $path = '')
    {
        $host = $_SERVER['HTTP_HOST'] ?? null;
        $config = request()->getScheme().'://'.$host;
        // $config .= '/lara11adminlte/public/';
        $config .= '/assets/backend';   // use for localhost:8000 or 127.0.0.1:8000

        return $config.($path ? '/'.ltrim($path, '/') : '');
    }
}

if (! function_exists('uploadUrl')) {
    function uploadUrl()
    {
        return asset('public/uploads/');
    }
}

if (! function_exists('errorImageUrl')) {
    function errorImageUrl()
    {
        // return asset('public/images/avatar3.png');
        return asset('/images/avatar3.png'); // for using localhost:8000 or 127.0.0.1:8000
    }
}
