<?php

namespace App\DataTables\Feature;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TaskDataTable extends DataTable
{
    protected $totalData, $projectUuid, $projectId;

    public function __construct($projectUuid="")
    {
        $this->projectUuid = $projectUuid;

        $projectData = Project::where('uuid', $projectUuid)->first();
        $this->projectId = $projectData->id;
    }

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
                    return Task::getStatusMap($query->status);
                })
                ->editColumn('created_at', function ($query) {
                    return Task::dateFormat($query->created_at);
                })
                ->editColumn('updated_at', function ($query) {
                    return Task::dateFormat($query->updated_at);
                })
                ->editColumn('description', function($query) {
                    return $query->description;
                })
                ->editColumn('user_id', function($query) {
                    return $query->user->name;
                })
                ->addColumn('action', function ($query) {
                    $action = [
                        [
                            'title' => 'Edit',
                            'class' => 'btn btn-primary',
                            'action' => route('feature.task.edit', ['task' => $query->uuid])
                        ],
                        [
                            'title' => 'Delete',
                            'class' => 'btn btn-danger',
                            'is_delete' => true,
                            'textConfirmation' => 'Are you sure to delete '.$query->nama_task.' ?',
                            'action' => route('feature.task.destroy', ['task' => $query->uuid])
                        ]
                    ];

                    if($query->project->status == Project::PROJECT_STATUS_IN_PROGRESS && $query->status == Task::TASK_NOT_COMPLETED) {
                        $actionExtend = [   
                            [
                                'title' => 'Completed',
                                'class' => 'btn btn-success',
                                'is_update' => true,
                                'textConfirmation' => 'Are you sure to change task status to '. strtoupper(Task::getStatusMap(Task::TASK_COMPLETED)) . '?',
                                'action' => route('feature.task.changestate', ['task' => $query->uuid, 'status' => Task::TASK_COMPLETED])
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
                ->rawColumns(['status', 'user_id', 'description', 'created_at', 'updated_at', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Task $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Task $model)
    {
        $datas = $model
                ->newQuery()
                ->where('project_id', $this->projectId);

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
                    ->setTableId('task-table')
                    ->columns($this->getColumns())
                    ->ajax([
                        'type' => 'GET',
                        'url' => route("feature.project.show", ['project' => $this->projectUuid]),
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
            Column::make('nama_task')->title('Task Name')->addClass('border px-4 py-2 text-center'),
            Column::make('description')->title('Description')->addClass('border px-4 py-2 text-center'),
            Column::make('user_id')->title('Assign To')->addClass('border px-4 py-2 text-center'),
            Column::make('status')->title('Task Status')->addClass('border px-4 py-2 text-center'),
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
        return 'Task_' . date('YmdHis');
    }
}
