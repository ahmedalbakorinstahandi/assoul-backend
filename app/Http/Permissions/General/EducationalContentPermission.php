<?php

namespace App\Http\Permissions\General;

use App\Models\General\EducationalContent;

class EducationalContentPermission
{
    public static function index($query)
    {
        return $query;
    }

    public static function show(EducationalContent $content)
    {
        return $content;
    }

    public static function create($data)
    {
        return $data;
    }

    public static function update(EducationalContent $content, $data)
    {
        return $data;
    }

    public static function delete(EducationalContent $content)
    {
        return $content;
    }
}
