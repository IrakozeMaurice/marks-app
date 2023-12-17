<?php

namespace App\Imports;

use App\Models\MarkExcel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class MarksExcelImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{

    protected $mark_id;

    public function __construct($mark_id)
    {
        $this->mark_id = $mark_id;
    }

    public function model(array $row)
    {

        // ignore empty rows
        if (!array_filter($row)) {
            return null;
        }

        // Define how to create a model from the Excel row data
        return new MarkExcel([
            'mark_id' => $this->mark_id,
            'column0' => $row[0],
            'column1' => $row[1],
            'column2' => $row[2],
            'column3' => $row[3],
            'column4' => $row[4],
            'column5' => $row[5],
            'column6' => $row[6],
            'column7' => $row[7],
            'column8' => $row[8],
            'column9' => $row[9],
            // Add more columns as needed
        ]);
    }
}
