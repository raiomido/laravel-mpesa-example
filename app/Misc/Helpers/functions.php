<?php

use Illuminate\Support\Str;

if (!function_exists('site_details')) {
	function site_details ()
	{
		$siteDetails = ($details = config('misc.site')) ? $details : [];

		return json_decode(json_encode($siteDetails));
	}
}

if (!function_exists('icons')) {
    function icons ()
    {
        $siteIcons = ($icons = config('misc.icons')) ? $icons : [];

        return json_decode(json_encode($siteIcons));
    }
}

if (!function_exists('is_active')) {
    function is_active ($uri): string
    {
        return request()->is($uri) || request()->is($uri.'/*') ? 'bg-indigo-900 text-white' : 'hover:text-white hover:bg-indigo-900 text-blue-100 focus:bg-indigo-900';
    }
}
