<?php

namespace App\Listeners;

use App\Services\Workflow\Workflow;


class WorkflowEventSubscriber
{
    /**
     * Handle on new workflow events.
     * @param $event
     * @throws \App\Exceptions\GeneralException
     */
    public function onNewWorkflow($event)
    {
        dd(123);
        $input = $event->input;
        $par = $event->par;
        $extra = $event->extra;
        $resource_id = $input['resource_id'];
        $wf_module_group_id = $input['wf_module_group_id'];
        if (isset($input['type'])) {
            $type = $input['type'];
        } else {
            $type = 0;
        }
        $data = [
            "resource_id" => $resource_id,
            "sign" => 1,
            "user_id" => $input['user'] ?? access()->id(),
        ];
        $data['comments'] = isset($extra['comments']) ? $extra['comments'] : "Recommended";

        $workflow = new Workflow(['wf_module_group_id' => $wf_module_group_id, 'resource_id' => $resource_id, 'type' => $type]);

        $workflow->createLog($data);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
    dd(456);

        $events->listen(
            'App\Events\ApproveWorkflow',
            'App\Listeners\WorkflowEventSubscriber@onApproveWorkflow'
        );

        $events->listen(
            'App\Events\NewWorkflow',
            'App\Listeners\WorkflowEventSubscriber@onNewWorkflow'
        );

        $events->listen(
            'App\Events\RejectWorkflow',
            'App\Listeners\WorkflowEventSubscriber@onRejectWorkflow'
        );
        $events->listen(
            'App\Events\TerminateWorkflow',
            'App\Listeners\WorkflowEventSubscriber@onTerminateWorkflow'
        );
    }
}