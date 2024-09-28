<?php

namespace App\Listeners;

use App\Events\NewWorkflow;
use App\Repositories\WfDefinitionRepository;
use App\Services\Workflow\Workflow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class WorkflowEventSubscriber
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewWorkflow $event): void
    {
        // $event->listen(
        //     'App\Events\NewWorkflow',
        //     'App\Listeners\WorkflowEventSubscriber@onNewWorkflow'
        // );
        $this->onNewWorkflow($event);
    }

    public function onNewWorkflow($event){
        $input = $event->input;
        $par = $event->par;
        $extra = $event->extra;
        $resource_id = $input['resource_id'];
        $wf_module_group_id = $input['wf_module_group_id'];
        $module_id = $input['module_id'];

        if (isset($input['type'])) {
            $type = $input['type'];
        } else {
            $type = 0;
        }
        // dd(Auth()->user);
        $data = [
            "resource_id" => $resource_id,
            "sign" => 1,
            "user_id" => $input['user'],
        ];
        $data['comments'] = isset($extra['comments']) ? $extra['comments'] : "Recommended";

        $wfDefRepo = app(WfDefinitionRepository::class);

        $workflow = new Workflow(['wf_module_group_id' => $wf_module_group_id, 'resource_id' => $resource_id, 'type' => $type, 'wf_module_id' => $module_id], $wfDefRepo);

        $workflow->createLog($data);

    }
}
