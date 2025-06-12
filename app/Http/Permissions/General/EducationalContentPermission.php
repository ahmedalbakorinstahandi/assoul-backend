<?php

namespace App\Http\Permissions\General;

use App\Models\General\EducationalContent;
use App\Models\Users\User;

class EducationalContentPermission
{
    public static function index($query)
    {

        $user = User::auth();

        if (!$user->isAdmin()) {
            return $query->where('is_visible', true);
        }

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
