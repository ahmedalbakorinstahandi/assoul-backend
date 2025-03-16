<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Guardian\AddChildRequest;
use App\Http\Resources\Users\PatientResource;
use App\Http\Services\Users\GuardianService;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    protected $guardianService;

    public function __construct(GuardianService $guardianService)
    {
        $this->guardianService = $guardianService;
    }
}
