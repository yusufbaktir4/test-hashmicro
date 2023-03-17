<?php

namespace App\DataTables\Feature;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProjectDataTable extends DataTable
{
    protected $totalData;

    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable($query)
    {
        return  datatables()
                ->eloquent($query)
                ->setRowAttr(['role' => 'row'])
                ->addIndexColumn()
                ->editColumn('status', function ($query) {
                    return Project::getStatusMap($query->status);
                })
                ->editColumn('payment_status', function ($query) {
                    return Project::getPaymentStatusMap($query->payment_status);
                })
                ->editColumn('start_date', function ($query) {
                    return Project::dateFormat($query->start_date);
                })
                ->editColumn('end_date', function ($query) {
                    return Project::dateFormat($query->end_date);
                })
                ->editColumn('created_at', function ($query) {
                    return Project::dateFormat($query->created_at);
                })
                ->editColumn('updated_at', function ($query) {
                    return Project::dateFormat($query->updated_at);
                })
                ->addColumn('action', function ($query) {
                    $action = [
                        [
                            'title' => 'Edit',
                            'class' => 'bg-indigo-600 hover:bg-indigo-500 focus-visible:outline-indigo-500',
                            'action' => route('feature.project.edit', ['project' => $query->uuid])
                        ],
                        [
                            'title' => 'Show',
                            'class' => 'bg-indigo-600 hover:bg-indigo-500 focus-visible:outline-indigo-500',
                            'action' => route('feature.project.show', ['project' => $query->uuid])
                        ],
                        [
                            'title' => 'Delete',
                            'class' => 'bg-red-600 hover:bg-red-500 focus-visible:outline-red-500',
                            'is_delete' => true,
                            'textConfirmation' => 'Are you sure to delete '.$query->nama_proyek.' ?',
                            'action' => route('feature.project.destroy', ['project' => $query->uuid])
                        ]
                    ];

                    if($query->status == Project::PROJECT_STATUS_NOT_STARTED) {
                        $actionExtend = [   
                            [
                                'title' => 'Start Project',
                                'class' => 'bg-red-600 hover:bg-red-500 focus-visible:outline-red-500',
                                'is_update' => true,
                                'textConfirmation' => 'Are you sure to change project status to '. strtoupper(Project::getStatusMap(Project::PROJECT_STATUS_IN_PROGRESS)) . '?',
                                'action' => route('feature.project.changestate', ['project' => $query->uuid, 'status' => Project::PROJECT_STATUS_IN_PROGRESS])
                            ]
                        ];

                        $action = array_merge($action, $actionExtend);
                    } elseif($query->status == Project::PROJECT_STATUS_IN_PROGRESS) {
                        $actionExtend = [   
                            [
                                'title' => 'Finish Project',
                                'class' => 'bg-indigo-600 hover:bg-indigo-500 focus-visible:outline-indigo-500',
                                'is_update' => true,
                                'textConfirmation' => 'Are you sure to change project status to '. strtoupper(Project::getStatusMap(Project::PROJECT_STATUS_COMPLETED)) . '?',
                                'action' => route('feature.project.changestate', ['project' => $query->uuid, 'status' => Project::PROJECT_STATUS_COMPLETED])
                            ]
                        ];

                        $action = array_merge($action, $actionExtend);
                    }

                    return view('feature.global_components.table_btn', [
                        'q' => $query,
                        'action' => $action
                    ]);
                })
                ->setTotalRecords($this->totalData)
                ->setFilteredRecords($this->totalData)
                ->skipPaging(request()->get('draw'))
                ->rawColumns(['status', 'start_date', 'end_date', 'created_at', 'updated_at', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Project $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Project $model)
    {
        $datas = $model
                ->newQuery();

        $starts = request()->get('start');
        $length = request()->get('length');

        $this->totalData = $datas->get()->count();
        return $datas->skip($starts)->take($length);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('project-table')
                    ->columns($this->getColumns())
                    ->ajax([
                        'type' => 'GET',
                        'url' => route("feature.project.index"),
                    ])
                    ->parameters([
                        'order' =>  [[1, 'asc']]
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('NO')->addClass('border px-4 py-2')->width(20),
            Column::make('nama_proyek')->title('Project Name')->addClass('border px-4 py-2 text-center'),
            Column::make('start_date')->title('Start Date')->addClass('border px-4 py-2 text-center'),
            Column::make('end_date')->title('End Date')->addClass('border px-4 py-2 text-center'),
            Column::make('status')->title('Project Status')->addClass('border px-4 py-2 text-center'),
            Column::make('payment_status')->title('Payment Status')->addClass('border px-4 py-2 text-center'),
            Column::make('created_at')->title('Created At')->addClass('border px-4 py-2 text-center'),
            Column::make('updated_at')->title('Updated At')->addClass('border px-4 py-2 text-center'),
            Column::make('created_by')->title('Created By')->addClass('border px-4 py-2 text-center'),
            Column::make('updated_by')->title('Updated By')->addClass('border px-4 py-2 text-center'),
            Column::computed('action')->title('Action')->width(50)->addClass('border px-4 py-2 text-center all'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Project_' . date('YmdHis');
    }
}
