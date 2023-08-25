<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Student([
            'nisn' => (int) $row['nisn'],
            'name' => $row['name'],
            'classroom_id' => (int) $row['classroom_id'],
            'gender' => $row['gender'],
            'password' => $row['password'],
        ]);
    }

    /**
     * rules
     * 
     * @return array
     */
    public function rules(): array
    {
        return [
            'nisn' => 'unique:students,nisn',
            // classroom_id must exist in classrooms table
            'classroom_id' => 'exists:classrooms,id',
        ];
    }
}
