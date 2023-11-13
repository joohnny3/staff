<?php

namespace App\Exports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;

class StaffExport implements FromQuery
{

    private $id;

    function __construct($id)
    {
        $this->id = $id;
    }

    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    
    public function query()
    {
        return Staff::query()->whereIn('id', $this->id);
    }
}
