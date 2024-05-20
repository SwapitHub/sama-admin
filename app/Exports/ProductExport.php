<?php

namespace App\Exports;
use App\Models\ProductModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return ProductModel::all();
        $data = ProductModel::all();

        // Get the column names from the database schema
        $columns = Schema::getColumnListing((new ProductModel())->getTable());

        // Map the column names to the actual database columns and remove any unwanted columns
        $columns = array_map(function ($column) {
            // Customize column names if needed
            return $column;
        }, $columns);

        // Add column names as the first row in the collection
        $data->prepend($columns);

        return $data;
    }
}
