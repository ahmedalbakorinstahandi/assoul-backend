<?php

namespace App\Http\Services\Patients;

use App\Models\Patient\Instruction;
use App\Models\Users\User;
use App\Services\FilterService;
use App\Services\MessageService;

class InstructionService
{
    public function index($data)
    {
        $query = Instruction::query();

        $searchFields = ['content'];
        $numericFields = [];
        $exactMatchFields = ['added_by', 'patient_id'];
        $dateFields = [];
        $inFields = [];


        return FilterService::applyFilters(
            $query,
            $data,
            $searchFields,
            $numericFields,
            $dateFields,
            $exactMatchFields,
            $inFields,
        );
    }

    public function show($id)
    {
        $instruction = Instruction::find($id);

        if ($instruction) {
            MessageService::abort(404, "السجل غير موجود");
        }

        return $instruction;
    }

    public function create($data)
    {
        $user = User::auth();

        $data['added_by'] = $user->id;

        $instruction  = Instruction::create($data);

        return $instruction;
    }

    public function udpate(Instruction $instruction, $data)
    {
        $instruction->update($data);

        return $instruction;
    }

    public function delete(Instruction $instruction)
    {
        $instruction->delete();
    }
}
