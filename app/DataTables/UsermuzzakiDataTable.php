<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsermuzzakiDataTable extends DataTable
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
            ->editColumn('userProfile.country', function($query) {
                return $query->userProfile->country ?? '-';
            })
            ->editColumn('userProfile.company_name', function($query) {
                return $query->userProfile->company_name ?? '-';
            })
            ->editColumn('status', function($query) {
                $status = 'warning';
                switch ($query->status) {
                    case 'active':
                        $status = 'primary';
                        break;
                    case 'inactive':
                        $status = 'danger';
                        break;
                    case 'banned':
                        $status = 'dark';
                        break;
                }
                return '<span class="text-capitalize badge bg-'.$status.'">'.$query->status.'</span>';
            })
            ->editColumn('created_at', function($query) {
                return date('Y/m/d',strtotime($query->created_at));
            })
            ->filterColumn('full_name', function($query, $keyword) {
                $sql = "CONCAT(users.first_name,' ',users.last_name)  like ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('userProfile.company_name', function($query, $keyword) {
                return $query->orWhereHas('userProfile', function($q) use($keyword) {
                    $q->where('company_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('userProfile.country', function($query, $keyword) {
                return $query->orWhereHas('userProfile', function($q) use($keyword) {
                    $q->where('country', 'like', "%{$keyword}%");
                });
            })
            ->addColumn('role', function($query) {
                return $query->role_name;
            })
            ->addColumn('action', 'users.userMuzzaki')
            ->rawColumns(['action','status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return User::query() 
        ->where('users.role', '=', NULL)
        ->where('users.user_type', '!=', "admin");
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
                    ->dom('<"row align-items-center"<"col-md-2" l><"col-md-6" B><"col-md-4"f>><"table-responsive my-3" rt><"row align-items-center" <"col-md-6" i><"col-md-6" p>><"clear">')

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
            ['data' => 'nama_lengkap', 'name' => 'nama_lengkap', 'title' => 'Nama Lengkap'],
            ['data' => 'jenis_kelamin', 'name' => 'jenis_kelamin', 'title' => 'Jenis Kelamin'],
            ['data' => 'user_type', 'name' => 'user_type', 'title' => 'User Type', 'class' => 'text-center'],
             ['data' => 'nomor_telp', 'name' => 'nomor_telp', 'title' => 'Nomor Telp'],
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->searchable(false)
                  ->width(60)
                  ->addClass('text-center hide-search'),
        ];
    }
 
}
