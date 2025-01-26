<?php

namespace App\DataTables;

use App\Models\Muzakkiview;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;  
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;

class MuzakkiDataTable extends DataTable
{
     /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
        ->eloquent($query)
        ->addColumn('DT_RowIndex', function ($row) {
            static $index = 0;
            return ++$index;
        })
        
      
        ->addColumn('action', 'muzakki.action');
     }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
 
 * @return \Illuminate\Database\Eloquent\Builder
 */
public function query(Request $request)
{
    $year = $request->input('year');

    $model = Muzakkiview::query();

    if ($year) {
        $model->whereYear('created_at', $year);
    }

    return $this->applyScopes($model);
}

    

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('dataTable')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('<"row align-items-center"<"col-md-2" l><"col-md-6" B><"col-md-4"f>><"table-responsive my-3" rt><"row align-items-left" <"col-md-6" i><"col-md-6" p>><"clear">')

                    ->parameters([
                        "processing" => true,
                        "autoWidth" => false,
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'No.', 'class' => 'text-center'],
            ['data' => 'code', 'name' => 'code', 'title' => 'code', ], 
            ['data' => 'nama_lengkap', 'name' => 'nama_lengkap', 'title' => 'Di Bayarkan'], 
            ['data' => 'ttl_liter', 'name' => 'ttl_liter', 'title' => 'Total (Liter)'], 
            ['data' => 'ttl_kg', 'name' => 'ttl_kg', 'title' => 'Total (Kg)'], 
            ['data' => 'ttl_rupiah', 'name' => 'ttl_rupiah', 'title' => 'Total (Rp)'], 
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->searchable(false)
                  ->width(60)
                  ->addClass('text-center '),
        ];
    }
 
}
