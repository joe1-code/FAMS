<?php

namespace App\Http\Controllers\Backend\System;

use App\Models\Access\Permission;
use App\Models\Certification\Certification;
use App\Models\Certification\CertificationDetail;
use App\Models\Certification\CertificationResult;
use App\Models\Reporting\ConfigurableReport;
use App\Repositories\Backend\Certification\CertificationRepository;
use App\Repositories\Backend\Reporting\DashboardRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Workflow\WfTrack;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Yajra\Datatables\Datatables;
use App\Models\Workflow\WfArchive;
use Illuminate\Support\Facades\DB;
use App\Services\Workflow\Workflow;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Exceptions\WorkflowException;
use App\Models\Workflow\WfDefinition;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Null_;
use App\DataTables\WorkflowTrackDataTable;
use App\Mail\ExternalAssessorNotification;
use Propaganistas\LaravelPhone\PhoneNumber;
use App\Models\Assessment\ExternalAssessor;
use App\Models\Notifications\NotificationLogs;
use App\DataTables\Sysdef\UsersReviewDataTable;
use App\Models\Operation\Claim\NotificationReport;
use App\Repositories\Backend\Access\UserRepository;
use App\Models\Operation\Claim\NotificationWorkflow;
use App\Repositories\Backend\Sysdef\RegionRepository;
use App\Models\Assessment\NotificationExternalAssessment;
use App\Repositories\Backend\Workflow\WfTrackRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Backend\Location\DistrictRepository;
use App\Repositories\Backend\Workflow\WfModuleRepository;
use App\Http\Requests\Backend\System\UpdateWorkflowRequest;
use App\Repositories\Backend\Workflow\WfDefinitionRepository;
use App\Repositories\Backend\Workflow\WfModuleGroupRepository;
use App\Repositories\Notifications\NotificationLogsRepository;
use App\Http\Requests\Backend\System\UpdateArchiveWorkflowRequest;
use App\Models\Auth\User;
use App\Models\Workflow\Wf_definition;
use App\Repositories\Backend\Assessment\ExternalAssessorRepository;
use App\Repositories\Backend\Operation\Claim\IncidentTypeRepository;
use App\Repositories\Backend\Reporting\ConfigurableReportRepository;
use App\Repositories\Backend\Workflow\WfArchiveReasonCodeRepository;
use App\Repositories\Backend\Operation\Claim\NotificationReportRepository;
use App\Repositories\Backend\Operation\Claim\MedicalPractitionerRepository;
use App\Repositories\Backend\Sysdef\CodeValueRepository;
use App\Repositories\Backend\Task\CheckerRepository;

class WorkflowController extends Controller
{

    /**
     * @var
     */
    protected $moduleGroup;

    /**
     * @var WfDefinition
     */
    protected $definitions;

    /**
     * @var wf tracks
     */
    protected $wf_tracks;

    /**
     * @var
     */
    protected $users;

    /**
     * workflowController constructor.
     * @param WfModuleGroupRepository $moduleGroup
     * @param WfDefinitionRepository $definitions
     * @param UserRepository $users
     */
    // public function __construct(WfModuleGroupRepository $moduleGroup, WfDefinitionRepository $definitions, UserRepository $users)
    public function __construct()
    {
        /* $this->middleware('access.routeNeedsPermission:assign_workflows'); */
        $this->moduleGroup = $moduleGroup;
        $this->definitions = $definitions;
        $this->users = $users;
        $this->wf_tracks = new WfTrack();
        //allocation
        // $this->middleware('access.routeNeedsPermission:workflow_allocation', ['only' => ['assignAllocation']]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function defaults()
    {
        return view('backend.system.workflow.defaults')
            ->with("groups", $this->moduleGroup->getAll())
            ->with("users", $this->users->query()->where('active', 1)->get());
    }

    /**
     * @param WfDefinition $definition (Workflow definition id)
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers(Wf_definition $definition)
    {
        return response()
            ->json($definition->users->pluck("id")->all());
    }

    public function updateDefinitionUsers(Wf_definition $definition)
    {
        $this->definitions->updateDefinitionUsers($definition, ['users' => request()->input('users')]);
        return response()->json(['success' => true]);
    }

    /**
     * @param WfArchive $wf_archive
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws GeneralException
     */
    public function editArchiveWorkflow(WfArchive $wf_archive)
    {
        $wfArchiveReasonCodeRepo = new WfArchiveReasonCodeRepository();
        $regions = (new RegionRepository())->getForSelect();
        $wf_track = $wf_archive->wfTrack;
        $module = $wf_track->wfDefinition->wfModule;
        $action = 1;
        $workflow = new Workflow(['wf_module_group_id' => $module->wf_module_group_id, 'resource_id' => $wf_track->resource_id, 'type' => $module->type]);
        access()->hasWorkflowModuleDefinition($module->wf_module_group_id, $module->type, $workflow->currentLevel());
        $record_users = (new UserRepository())->query()->where('unit_id', 16)->get()->pluck('name', 'id')->all();
        $wfArchiveReasonCode = $wfArchiveReasonCodeRepo->query()->where('wf_module_group_id', $module->wf_module_group_id)->first();
        if ($wfArchiveReasonCode) {
            $archive_reasons = $wfArchiveReasonCode->reasons()->pluck("name", "id")->all();
        } else {
            $archive_reasons = [];
        }
        $prevUrl = url()->previous();

        $assessors = $assessors = (new ExternalAssessorRepository())->getAssessors();
        if ($assessors) {
            $assessors = collect($assessors)->pluck('full_name', 'id')->all();
        } else {
            $assessors = [];
        }

        return view('backend/system/workflow/edit_archive')
            ->with('wf_track', $wf_track)
            ->with('wf_archive', $wf_archive)
            ->with('prevurl', $prevUrl)
            ->with('record_users', $record_users)
            ->with('action', $action)
            ->with('regions', $regions)
            ->with('archive_reasons', $archive_reasons)
            ->with('assessors', $assessors)
            ->with('external_assessor_code_value', (new CodeValueRepository())->SENTTOEXTASS());
    }

    /**
     * @param $resource_id
     * @param $wf_module_group_id
     * @param $type
     * @param $action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws GeneralException
     */
    public function archiveWorkflow($resource_id, $wf_module_group_id, $type, $action)
    {
        $wfModule = new WfModuleRepository();
        $wfArchiveReasonCodeRepo = new WfArchiveReasonCodeRepository();
        $regions = (new RegionRepository())->getForSelect();
        $module = $wfModule->getModule(['wf_module_group_id' => $wf_module_group_id, 'type' => $type]);

        if ($action) {
            $status = 0;
        } else {
            $status = 6;
        }
        $wftrackModel = $this->wf_tracks->getLastWorkflowModel($resource_id, $module, $status);
        if (!$wftrackModel->count()) {
            throw new GeneralException('There is no any pending level for archive process in this workflow');
        }
        $workflow = new Workflow(['wf_module_group_id' => $wf_module_group_id, 'resource_id' => $resource_id, 'type' => $type]);
        access()->hasWorkflowModuleDefinition($wf_module_group_id, $type, $workflow->currentLevel());
        $wf_track = $wftrackModel->first();
        if (!$action) {
            //un-archiving workflow
            $return = $this->wf_tracks->postArchiveWorkflow($wf_track, $action);
            return redirect()->back()->withFlashSuccess('Success, Workflow has been un-archived.');
        }
        $wfArchiveReasonCode = $wfArchiveReasonCodeRepo->query()->where('wf_module_group_id', $wf_module_group_id)->first();
        if ($wfArchiveReasonCode) {
            $archive_reasons = $wfArchiveReasonCode->reasons()->pluck("name", "id")->all();
        } else {
            $archive_reasons = [];
        }
        $record_users = (new UserRepository())->query()->where('unit_id', 16)->get()->pluck('name', 'id')->all();
        $assessors = $assessors = (new ExternalAssessorRepository())->getAssessors();
        if ($assessors) {
            $assessors = collect($assessors)->pluck('full_name', 'id')->all();
        } else {
            $assessors = [];
        }

        $prevUrl = url()->previous();
        $workflow = new Workflow(['wf_module_id' => $wf_track->wfDefinition->wfModule->id, 'resource_id' => $wf_track->resource_id]);

       $unit = $wf_track->wfDefinition->unit_id;
        $group=$wf_track->wfDefinition->wfModule->wf_module_group_id;

        if($group == 69 || $group == 42){
            switch($unit){
                case 14:
                    $archive_reasons = (new CodeValueRepository())->CADSARCREAS()->pluck("name", "id")->all();
                    break;

                case 15:
                    $archive_reasons = (new CodeValueRepository())->COMPARCREAS()->pluck("name", "id")->all();
                    break;

                case 6:
                        $archive_reasons = (new CodeValueRepository())->LSUARCREAS()->pluck("name", "id")->all();
                    break;

                case 17:
                        $archive_reasons = (new CodeValueRepository())->CASSARCREAS()->pluck("name", "id")->all();
                    break;

                default:
                    break;
            }
        }
        return view('backend/system/workflow/archive')
            ->with('wf_track', $wf_track)
            ->with('prevurl', $prevUrl)
            ->with('record_users', $record_users)
            ->with('action', $action)
            ->with('regions', $regions)
            ->with('archive_reasons', $archive_reasons)
            ->with('assessors', $assessors)
            ->with('external_assessor_code_value', (new CodeValueRepository())->SENTTOEXTASS());
    }

    /**
     * @param $resource_id
     * @param $wf_module_group_id
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     * @throws GeneralException
     */
    public function canArchiveWorkflow($resource_id, $wf_module_group_id, $type)
    {
        $wfModule = new WfModuleRepository();
        $group = (new WfModuleGroupRepository())->find($wf_module_group_id);
        $success = $group->can_archive;
        $view = '';
        if ($success) {
            $module = $wfModule->getModule(['wf_module_group_id' => $wf_module_group_id, 'type' => $type]);
            $wf_track = $this->wf_tracks->getLastWorkflow($resource_id, $module);
            $view = (string) view('backend/system/workflow/includes/archive_option')
                ->with('wf_track', $wf_track)
                ->with('resource_id', $resource_id)
                ->with('wf_module_group_id', $wf_module_group_id)
                ->with('type', $type)
                ->with('module', $module);
        }
        return response()->json(['success' => $success, 'view' => $view]);
    }

    /**
     * @param WfTrack $wf_track
     * @param $action
     * @param UpdateArchiveWorkflowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postArchiveWorkflow(WfTrack $wf_track, $action, UpdateArchiveWorkflowRequest $request)
    {
        // dd($request->all());
        $input = $request->all();

        //check if archive days is in range of 7 working days for Claim Administration Section only
        if(in_array(access()->user()->unit_id, [14]))
        {
            $fromDate = Carbon::createFromFormat('Y-m-d', $input['from_date']);
            $toDate = Carbon::createFromFormat('Y-m-d', $input['to_date']);
            // Calculate the number of working days
            $workingDays = $this->wf_tracks->calculateWorkingDays($fromDate, $toDate);
            if ($workingDays > 7) {
                return response()->json(["success" => false, "message" => "Action Failed: Failed to Archive as Maximum Archiving days exceed 7 working days... Archiving days are {$workingDays}"]);
            }
        }
        $return = $this->wf_tracks->postArchiveWorkflow($wf_track, $action, $input);
        return response()->json(['success' => true]);

    }

    /**
     * @param WfArchive $wf_archive
     * @param UpdateArchiveWorkflowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateArchiveWorkflow(WfArchive $wf_archive, UpdateArchiveWorkflowRequest $request)
    {
        $input = $request->all();

        //check if archive days is in range of 7 working days for Claim Administration Section only
        if(in_array(access()->user()->unit_id, [14]))
        {
            $fromDate = Carbon::createFromFormat('Y-m-d', $input['from_date']);
            $toDate = Carbon::createFromFormat('Y-m-d', $input['to_date']);
            // Calculate the number of working days
            $workingDays = $this->wf_tracks->calculateWorkingDays($fromDate, $toDate);
            if ($workingDays > 7) {
                return response()->json(["success" => false, "message" => "Action Failed: Failed to Archive as Maximum Archiving days exceed 7 working days... Archiving days are {$workingDays}"]);
            }
        }

        $return = $this->wf_tracks->updateArchiveWorkflow($wf_archive, $input);
        return response()->json(['success' => true]);
    }

    /**
     * @param $resource_id
     * @param $wf_module_group_id
     * @param $type
     * @return $this
     * @throws \App\Exceptions\GeneralException
     */
    public function getCompletedWfTracks($resource_id, $wf_module_group_id, $type)
    {
        $wf_tracks = $this->wf_tracks->getCompletedWfTracks($resource_id, $wf_module_group_id, $type);
        $module = (new WfModuleRepository())->getModuleInstance(['wf_module_group_id' => $wf_module_group_id, 'type' => $type]);
        return view("backend.includes.workflow.completed_tracks")
            ->with("wf_tracks", $wf_tracks)
            ->with("resource_id", $resource_id)
            ->with("wf_module_group_id", $wf_module_group_id)
            ->with("type", $type)
            ->with("module", $module);
    }

    /**
     * @param $resource_id
     * @param $wf_module_group_id
     * @param $type
     * @return $this
     * @throws \App\Exceptions\GeneralException
     */
    public function getListWfTracks($resource_id, $wf_module_group_id, $type)
    {
        $wf_tracks = $this->wf_tracks->getCompletedWfTracks($resource_id, $wf_module_group_id, $type);
        return view("backend.includes.workflow.list_tracks")
            ->with("wf_tracks", $wf_tracks);
    }

    public function getWfTracksForHtml($resource_id, $wf_module_group_id, $type)
    {
        $tracks = $this->wf_tracks->getPendingWfTracksForDatatable($resource_id, $wf_module_group_id, $type);
        //logger($tracks);
        $current_track = view("backend/includes/workflow/current_track")
            ->with("wf_tracks", $tracks);
        $completed_tracks = $this->getCompletedWfTracks($resource_id, $wf_module_group_id, $type);
        //return ['current_track' => (string) $current_track, 'completed_tracks' => (string) $completed_tracks];
        return response()->json(['current_track' => (string) $current_track, 'completed_tracks' => (string) $completed_tracks]);
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Exception
     */
    public function getWfTracksForDatatable($resource_id, $wf_module_group_id, $type)
    {
        return Datatables::of($this->wf_tracks->getPendingWfTracksForDatatable($resource_id, $wf_module_group_id, $type))
            ->editColumn('user_id', function ($wf_track) {
                return $wf_track->username_formatted;
            })
            ->editColumn('receive_date', function ($wf_track) {
                return $wf_track->receive_date_formatted;
            })
            ->editColumn('forward_date', function ($wf_track) {
                return $wf_track->forward_date_formatted;
            })
            ->editColumn('status', function ($wf_track) {
                return $wf_track->status_narration;
            })
            ->editColumn('wf_definition_id', function ($wf_track) {
                return $wf_track->wfDefinition->level;
            })
            ->addColumn('action', function ($wf_track) {
                return $wf_track->status_narration;
            })
            ->addColumn('description', function ($wf_track) {
                return $wf_track->wfDefinition->description;
            })
            ->addColumn("aging", function ($wf_track) {
                return $wf_track->getAgingDays();
            })
            ->addColumn('rectify_action', function ($wf_track) {
                return $wf_track->rectify_duplicate_entries_button;
            })
            ->rawColumns(['user_id', 'rectify_action'])
            ->make(true);
    }

    public static function getWfTracks($resource_id, WorkflowTrackDataTable $dataTable)
    {
        $dataTable->with('resource_id', $resource_id)->render('backend.includes.workflow_track');
    }

    /**
     * @param $resource_id
     * @param $wf_module_group_id
     * @return mixed
     * @throws \Exception
     */
    public function getDeactivatedWfTracksForDataTable($resource_id, $wf_module_group_id)
    {

        return Datatables::of($this->wf_tracks->getDeactivatedWfTracksForDataTable($resource_id, $wf_module_group_id))
            ->editColumn('user_id', function ($wf_track) {
                return $wf_track->username_formatted;
            })
            ->editColumn('receive_date', function ($wf_track) {
                return $wf_track->receive_date_formatted;
            })
            ->editColumn('forward_date', function ($wf_track) {
                return !is_null($wf_track->forward_date) ? $wf_track->forward_date_formatted : ' ';
            })
            ->editColumn('status', function ($wf_track) {
                return $wf_track->status_narration;
            })
            ->editColumn('wf_definition_id', function ($wf_track) {
                return $wf_track->wfDefinition->level;
            })
            ->addColumn('action', function ($wf_track) {
                return $wf_track->status_narration;
            })
            ->addColumn('description', function ($wf_track) {
                return $wf_track->wfDefinition->description;
            })
            ->addColumn("aging", function ($wf_track) {
                return $wf_track->getAgingDays();
            })
            ->rawColumns(['user_id'])
            ->make(true);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     * @description  Get Deactivated Claim workflow Tracks for this resource id
     */
    public function getDeactivatedClaimWfTracksForDataTable($id)
    {

        return Datatables::of($this->wf_tracks->getDeactivatedClaimWfTracksForDataTable($id))
            ->editColumn('user_id', function ($wf_track) {
                return $wf_track->username_formatted;
            })
            ->editColumn('receive_date', function ($wf_track) {
                return $wf_track->receive_date_formatted;
            })
            ->editColumn('forward_date', function ($wf_track) {
                return !is_null($wf_track->forward_date) ? $wf_track->forward_date_formatted : ' ';
            })
            ->editColumn('status', function ($wf_track) {
                return $wf_track->status_narration;
            })
            ->editColumn('wf_definition_id', function ($wf_track) {
                return $wf_track->wfDefinition->level;
            })
            ->addColumn('action', function ($wf_track) {
                return $wf_track->status_narration;
            })
            ->addColumn('description', function ($wf_track) {
                return $wf_track->wfDefinition->description;
            })
            ->addColumn("aging", function ($wf_track) {
                return $wf_track->getAgingDays();
            })
            ->rawColumns(['user_id'])
            ->make(true);
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function getWorkflowModalContent()
    {
        dd(123);
        $wf_track_id = request()->input("wf_track_id");
        $statuses = [];
        $statuses[''] = "";
        $wf_track = $this->wf_tracks->find($wf_track_id);
        $workflow = new Workflow(['wf_module_id' => $wf_track->wfDefinition->wfModule->id, 'resource_id' => $wf_track->resource_id]);
        $wf_definition = $wf_track->wfDefinition;
        $assignStatus = $this->wf_tracks->assignStatus($wf_track_id);
        $is_optional = $wf_definition->is_optional;
        $isrestrictive = 0;
        if (!env("TESTING_MODE")) {
            $isrestrictive = $wf_definition->isrestrictive;
        }
        $has_next_start_optional = $wf_definition->has_next_start_optional;
        $next_level_designation = "";
        $next_level_description = "";
        $selective_levels = [];
        $isselective = 0;
        $isselectuser = 0;
        $select_users = [];
        $isselectprevuser = 0;
        $select_prev_user = [];
        $currentLevel = $workflow->currentLevel();
        $wf_module_id = $wf_track->wfDefinition->wfModule->id;
        if ($wf_definition->isselective) {
            //query selective levels
            $isselective = 1;
            $selective_levels = $workflow->selectiveLevels();
            // dump($selective_levels);
        }
        if ($wf_definition->assign_next_user) {
            //query users to select
            $isselectuser = 1;
            $select_users = $workflow->getUsersToSelect();
        }
        if ($wf_definition->assign_prev_user) {
            //query users to select
            $isselectprevuser = 1;
            // $select_prev_user = $workflow->getPrevUsersToSelect();
        }
        //logger($wf_definition->id);
        if ($wf_definition->is_approval) {
            // if(in_array($wf_module_id, [105, 106, 112, 113]))   //validation workflow reengineering          seeder changes reengineering
            if (in_array($wf_module_id, [140, 141, 147, 148]))   //validation workflow reengineering
            {
                $statuses['1'] = "Accept";
                $statuses['3'] = "Decline";
                $statuses['8'] = "Terminate";   //pop up a modal for document suspension and wf termination
            }
            // elseif (in_array($wf_module_id, [108, 116, 117]))        //seeder changes reengineering
            elseif (in_array($wf_module_id, [143, 151, 152, 237]))   //benefit workflows TD, PD, MAE and Survivovr/FG reengineering
            {
                $statuses['1'] = "Approve Payment";
               // $statuses['3'] = "Decline Payment";
            }
            // elseif (in_array($wf_module_id, [115, 125]))   //Rejection workflow reengineering
            elseif (in_array($wf_module_id, [150, 160, 162]))        //seeder changes
            {
                $statuses['1'] = "Accept to Reject";
                $statuses['3'] = "Decline to Reject";
            }
            // elseif (in_array($wf_module_id, [118]))      //seeder changes reengineering
            elseif (in_array($wf_module_id, [153]))         //Seek guidance legal by CADO
            {
                $statuses['1'] = "Approve (Advice Leads to Suspension of Chosen Document(s))";
                $statuses['9'] = "Approve (Advice Leads to Claim Rejection)";
                $statuses['3'] = "Decline (Proceed with Previous State)";
            }
            // elseif (in_array($wf_module_id, [119]))      //seeder changes reengineering
            elseif (in_array($wf_module_id, [154]))   //Reporting fraudulent incident by CADO
            {
                $statuses['1'] = "Fraudulent Incident Confirmed";
                $statuses['3'] = "No Fraudulent Incident Confirmed";
            }
            // elseif (in_array($wf_module_id, [126]))      //seeder changes reengineering
            elseif (in_array($wf_module_id, [161, 169, 170])) {
                $statuses['1'] = "Accept";
                $statuses['3'] = "Decline";
            } elseif (in_array($wf_module_id, [31]))  //claim missing contribution approval by SCO
            {
                $statuses['1'] = "Recommended";
                $statuses['3'] = "Declined";
            } elseif (in_array($wf_module_id, [6, 45]))  //Employer Registration and online verification
            {
                $statuses['1'] = "Approved";
                $statuses['9'] = "Approved (Review Commencement Date)";
                $statuses['2'] = "Reversed to level";
                $statuses['3'] = "Declined";
            } elseif (in_array($wf_module_id, [47])){
                $statuses['1'] = "Approved";
                $statuses['7'] = "Approve Re-inspection";
                $statuses['4'] = "Recommend re-inspection";
                $statuses['3'] = "Declined";
            }
            else {
                $statuses['1'] = "Approved";
                $statuses['3'] = "Declined";
            }
        } else {
            if ($wf_definition->assign_next_user) {
                $statuses['1'] = "Recommended";
                // } elseif(in_array($wf_definition->id, [774, 796, 863, 884, 917])){       seeder changes reengineering
            } elseif (in_array($wf_definition->id, [1080, 1102, 1169, 1190, 1328, 2061, 2062, 2063, 2064])) {
                $statuses[''] = "";
            } elseif(in_array($wf_definition->id,[340])){
                $statuses['1'] = "Recommended";
                $statuses['15'] = "Request for Re-Inspection";
            }elseif(in_array($wf_definition->id, [2135])){
                $statuses['1'] = "Recommended";
            } else {
                $statuses['1'] = "Recommended";
            }

            // if(in_array($wf_definition->id, [1510])){
            //     $statuses['8'] = "Terminate";
            //resolving merging conflict

            if(in_array($wf_definition->id, [1448])){
                $statuses['8'] = "Terminate";

            }
        }

        //controls for seeking advice by CADO workflow when rejecting
        // if(in_array($wf_module_id, [118, 119]))      //seeder changes reengineering
        if (in_array($wf_module_id, [153, 154])) {
            // if($wf_definition->id == 972)        //seeder changes reengineering
            if ($wf_definition->id == 1278) {
                $statuses['3'] = "No Need of Legal Guidance";
            }
            // if($wf_definition->id == 977)        //seeder changes reengineering
            if ($wf_definition->id == 1283) {
                $statuses['3'] = "No Suspicious Fraudulent Incident";
            }
        }
        // to control Incident new workflow
        if ($currentLevel <> 1) {
            //check if reverse is in optional level or not to reverse to previous level
            $wf_definition->is_optional ? $prevWfDefinition = $workflow->nextWfDefinition(-1, false) : $prevWfDefinition = $workflow->nextWfDefinition(-1, true);
            // $prevWfDefinition = $workflow->nextWfDefinition(-1, true);
            // dd($prevWfDefinition);
            // reengineer wfdefinition, allow assigned officer not to reverse to previous level
            // if((in_array($wf_definition->wf_module_id, [105,106,108,116,117,111]) && ($wf_definition->designation_id == 4))){        //seeder changes reengineering
            // if((in_array($wf_definition->wf_module_id, [140, 141, 143, 151, 152, 146]) && ($wf_definition->designation_id == 4))){
            //     // dd($prevWfDefinition);
            // }
            // else{
            if ($prevWfDefinition->allow_rejection) {
                $statuses['2'] = "Reverse to level";
            }
            // if(in_array($wf_definition->id, [785, 873])) $statuses['2'] = "Reverse to level";        seeder changes reengineering
            // if(in_array($wf_definition->id, [1088, 1177])) $statuses['2'] = "Reverse to level";

            // }
        }
        if ($workflow->hasRecentApproval() and $currentLevel < $workflow->getApprovalLevel()) {
            $statuses['7'] = "Recommend to after Approved Level";
        }
        if ($wf_definition->has_next_start_optional) {
            // if CADM return the label as seek guidance, if CADO computation return the label as seek contribution clarification
            (in_array($wf_definition->wf_module_id, [140, 141, 143, 147, 148]) and  $wf_definition->unit_id == 14 and $wf_definition->designation_id == 5) ? $statuses['4'] = "Seek Guidance" : ((in_array($wf_definition->wf_module_id, [143]) and $wf_definition->level == 6) ? $statuses['4'] = "Seek Contribution Clarification" : $statuses['4'] = "Seek Advice");
            //CADM seek advice to DO only ==> Reengineering validations and benefits(Except survivor) and document suspension workflows
            // if($wf_definition->level == 2 and in_array($wf_definition->wf_module_id, [105, 108, 110, 112, 113, 116]))        //seeder changes reengineering
            if ($wf_definition->level == 2 and in_array($wf_definition->wf_module_id, [140, 143, 145, 147, 148, 151])) {
                $isselective = 1;
                $selective_levels =  (new WfDefinitionRepository())->getSelectiveLevelToDO($wf_definition->id);
            }
            // elseif($wf_definition->level == 6 and in_array($wf_definition->wf_module_id, [106, 113]))        //seeder changes reengineering
            elseif ($wf_definition->level == 6 and in_array($wf_definition->wf_module_id, [141, 148])) {
                $isselective = 1;
                $selective_levels =  (new WfDefinitionRepository())->getSelectiveLevelToDO($wf_definition->id);
            } elseif ($wf_definition->level == 3 and in_array($wf_definition->wf_module_id, [170])) {
                $isselective = 1;
                $selective_levels =  (new WfDefinitionRepository())->getSelectiveLevelToDO($wf_definition->id);     //return DAS for seek guidance
            }
        }
        // if(in_array($wf_definition->wf_module_id, [143]) and $wf_definition->level == 6) $statuses['12'] = "Return to Checklist User";

        // if(in_array($wf_definition->wf_module_id, [143]) and $wf_definition->level == 12) $statuses['12'] = "Return to Checklist User";

        if(in_array($wf_definition->wf_module_id, [18, 17, 76]) and $wf_definition->level == 14) $statuses['17'] = "Recommend to Checklist User for Vendor Form Follow-up";

        if(in_array($wf_definition->wf_module_id, [143]) and $wf_definition->level == 6) $statuses['17'] = "Recommend to Checklist User for Vendor Form Follow-up";

        // if(in_array($wf_definition->wf_module_id, [18, 17, 76]) and $wf_definition->level == 14.1) $statuses['16'] = "Return to Finance Officer";

        // if(in_array($wf_definition->wf_module_id, [151]) and $wf_definition->level == 10) $statuses['12'] = "Return to Checklist User";
//dd($statuses);
        if($wf_definition->wf_module_id == 143 && $wf_definition->level == 1)
        {
            $computation_track = $this->wf_tracks->checkReversedToChecklistUser($wf_track->resource_id, $wf_track->resource_type, 1);
            if($computation_track) $statuses['13'] = "Return to Computation Officer";
        }

        // if($wf_definition->wf_module_id == 143 && $wf_definition->level == 1)
        // {

        //     $finance_track = $this->wf_tracks->checkReversedToChecklistUser($wf_track->resource_id, $wf_track->resource_type, 2);
        //     if($finance_track)
        //     {
        //         $statuses['14'] = "Return to Finance Officer";
        //     }
        // }

        if(in_array($wf_definition->wf_module_id,  [18,76,17]) && $wf_definition->level == 1)
        {

            $finance_track = $this->wf_tracks->checkReversedToChecklistUser($wf_track->resource_id, $wf_track->resource_type, 3);
            if($finance_track) {
                $statuses['16'] = "Return to Finance Officer";
            }
        }

        // if(in_array($wf_definition->wf_module_id,  [151]) && $wf_definition->level == 1)
        // {

        //     $finance_track = $this->wf_tracks->checkReversedToChecklistUser($wf_track->resource_id, $wf_track->resource_type, 4);
        //     if($finance_track) {
        //         $statuses['16'] = "Return to Finance Officer";
        //     }
        // }

        //control suspend documents by CASM/CADM in benefit workflow (TD, TD Refund, PD and MAE Refund)
        // if(in_array($wf_module_id, [108, 116, 117]))          //seeder changes reengineering
        if (in_array($wf_module_id, [143, 151, 152, 237])) {
            // if(in_array($wf_definition->id, [927, 1033]))        seeder changes reengineering
            if (in_array($wf_definition->id, [1233, 1339]))    //CASM
            {
                $statuses['8'] = "Decline(Suspend Document(s))";
            }
            // if(in_array($wf_definition->id, [916, 948, 1021]))       //seeder changes reengineering
            if (in_array($wf_definition->id, [1222, 1254, 1327, 1981]))    //CADM
            {
                $statuses['8'] = "Decline(Suspend Document(s))";
                $statuses['10'] = "Decline(Not Work Related)";           //decline benefit, file not work related
            }
        }
        // dd($next_level_designation);
        //$has_participated = $workflow->hasParticipated();
        // dd($workflow->previousLevels());
        $has_participated = false;
        $user_has_access = $workflow->userHasAccess(access()->id(), $currentLevel);

        //$restrictive_check = $workflow->restrictiveCheck();
        return view("backend/includes/workflow_process_modal")
            ->with("assign_status", $assignStatus)
            ->with("wf_track", $wf_track)
            ->with("has_participated", $has_participated)
            ->with("user_has_access", $user_has_access)
            ->with("previous_levels", $workflow->previousLevels())
            ->with("statuses", $statuses)
            ->with("next_level_designation", $next_level_designation)
            ->with("next_level_description", $next_level_description)
            ->with("isselective", $isselective)
            ->with("isselectuser", $isselectuser)
            ->with("isrestrictive", $isrestrictive)
            ->with("selective_levels", $selective_levels)
            ->with("is_optional", $is_optional)
            ->with("select_users", $select_users)
            ->with("incident_id", $incident_id)
            ->with("isselectprevuser", $isselectprevuser);
    }

    /**
     * @param WfTrack $wf_track
     * @param $action
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\GeneralException
     * @description Show the next level designation title
     */
    public function nextLevelDesignation(WfTrack $wf_track, $action)
    {

        $wf_definition = $wf_track->wfDefinition;
        $is_optional = $wf_definition->is_optional;
        $has_next_start_optional = $wf_definition->has_next_start_optional;
        if ($action == '4') {
            $select_next_start_optional = 1;
        } else {
            $select_next_start_optional = 0;
        }

        logger($has_next_start_optional);
        logger($select_next_start_optional);
        logger($is_optional);
        logger($action);

        switch (true) {
            case ($has_next_start_optional and !$select_next_start_optional and !$is_optional):
            case (!$has_next_start_optional and !$select_next_start_optional and !$is_optional):
            case ($has_next_start_optional and !$select_next_start_optional and $is_optional): //Added recently
                //This logic computed from the truth table, may need re-design.
                //Skip Optional level
                $skip = true;
                break;
            default:
                //Continue Regularly
                $skip = false;
                break;
        }
        $next_level_designation = "";
        $next_level_description = "";
        $workflow = new Workflow(['wf_module_id' => $wf_track->wfDefinition->wfModule->id, 'resource_id' => $wf_track->resource_id]);
        if (!$wf_definition->isselective) {
        }

        //$nextWfDefinition = $workflow->nextWfDefinition(1, $skip);

        // if($action == 1 && in_array($wf_definition->wf_module_id, [105, 106, 108, 110, 112, 113, 114, 115, 116, 117, 118, 119, 125]))       seeder changes reengineering
        if ($action == 1 && in_array($wf_definition->wf_module_id, [140, 141, 143, 145, 146, 147, 148, 149, 150, 151, 152, 153, 154, 160, 146, 162, 173, 174, 175, 237])) {
            // if($wf_definition->is_approval == 1)    //approval level, don't show next user the workflow to jump to.
            // {
            //     $nextWfDefinition = NULL;   //display nothing
            // }
            // else{
            $nextWfDefinition = $workflow->nextWfDefinitionReengineer(1, $skip, $action);
            // }

        }
        elseif($action == 1 && in_array($wf_definition->wf_module_id, [207,209, 210, 211, 213])){
            logger("inside");
            $nextWfDefinition = $workflow->getNextWfDefinitionReview(1, $skip, $action);
            logger($nextWfDefinition);
        } else {
            $nextWfDefinition = $workflow->nextWfDefinition(1, $skip);
        }

        //$nextWfDefinition = $action == 1 ?  $workflow->nextWfDefinitionReengineer(1, $skip, $action) : $workflow->nextWfDefinition(1, $skip);
        if ($nextWfDefinition) {
            $next_level_designation = $nextWfDefinition->definition_designation;
            $next_level_description = $nextWfDefinition->description;
        }

        logger($skip);

        return response()->json(['next_level_designation' => $next_level_designation, 'success' => true, 'skip' => $skip, 'next_level_description' => $next_level_description]);
    }

    /**
     * @param WfTrack $wf_track
     * @param UpdateWorkflowRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws WorkflowException
     */
    public function updateWorkflow(WfTrack $wf_track, UpdateWorkflowRequest $request)
    {
        // dump($wf_track);
        if ($wf_track->status) {
            throw new WorkflowException("This workflow has already been forwarded! Please reload the workflow table.");
        }
        $action = $request->input("action");

        switch ($action) {
            case 'assign':
                $input = ['user_id' => access()->id(), 'assigned' => 1];
                $success = true;
                $message = trans('alerts.backend.workflow.assigned');
                break;
            case 'approve_reject':
                $status = $request->input("status");

                $input = ['user_id' => access()->id(), 'status' => $status, 'comments' => $request->input("comments"), 'forward_date' => Carbon::now(), 'wf_definition' => $request->input("wf_definition"), 'select_user' => $request->input('select_user'), 'incident_id' => $request->input("incident_id")];
                if ($status == '2') {
                    $input['level'] = (string) $request->input("level");
                }
                $success = true;
                $message = trans('alerts.backend.workflow.updated');
                break;
        }
        $wfModule = $this->wf_tracks->updateWorkflow($wf_track, $input, $action);
        if ($request->ajax()) {
            return response()->json(['success' => $success, 'message' => $message, 'action' => $action, 'resource_id' => $wf_track->resource_id, 'wf_module_group_id' => $wfModule->wf_module_group_id, 'type' => $wfModule->type]);
        } else {
            return redirect()->back()->withFlashSuccess("Workflow Updated Successfully!!!")->with('refresh',true);
        }
        //Heavy Duty Call

    }

    /**
     * @param Request $request
     * @param string $cr
     * @return array
     */
    public function listControl(Request $request, $category = NULL): array
    {
        $wfModuleRepo = new WfModuleRepository();
        $crRepo = new ConfigurableReportRepository();
        $control = [
            'wf_mode' => 1,
            'cr' => NULL,
            'show' => 0,
            'wfname' => 'Workflow',
            'wf_module_id' => NULL,
            'wf_definitions' => [],
            'filters' => [],
        ];
        $has_wf_module = $request->has('wf_module_id');
        if ($has_wf_module) {
            $control['show'] = 1;
            $wfmoduleid = $request->input('wf_module_id');
            $control['wf_module_id'] = $wfmoduleid;
            $wfmodule = $wfModuleRepo->find($wfmoduleid);
            if ($wfmodule) {
                $control['wfname'] = $wfmodule->name;
                if ($wfmodule->wf_mode == 2) {
                    $crid = $wfModuleRepo->getCR($wfmoduleid);
                    //manupulate report rendering ...
                    switch ($category) {
                        case "attended":
                            if ($crid == 38) {
                                $crid = 72;
                            }
                            break;
                    }
                    //control the data to be rendered to view ...
                    switch ($category) {
                        case "progress":
                            $wf_definitions = [];
                            break;
                        default:
                            $wf_definitions = access()->allWfDefinitions();
                            break;
                    }
                    $cr = $crRepo->query()->find($crid);
                    //dd($wf_definitions);
                    $control['wf_definitions'] = $wf_definitions;
                    if ($cr) {
                        $control['wf_mode'] = 2;
                        //$filters = $crRepo->setDataForSelectFilter(json_decode($cr->filter ?? '[]', true));
                        $control['cr'] = $cr;
                        //$control['filters'] = $filters;
                    }
                }
            }
        }
        //dd($control);
        return $control;
    }

    /**
     * Pending Workflow
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pending(Request $request)
    {
        $input = $request->all();
        $wfModuleRepo = new WfModuleRepository();
        $user = access()->user();
        $status_fetch = [0];
        if ($user->designation_id == 1) {
            $status_fetch = [0];
        }
        $control = $this->listControl($request);
        //Log::info($has_wf_module);
        return view("backend/system/workflow/pending")
            ->with("wf_modules", $wfModuleRepo->getAllActive()->pluck('name', 'id')->all())
            ->with("group_counts", $wfModuleRepo->getActiveUser())
            ->with("state", "all")
            ->with("statuses", ['2' => 'All', '1' => 'Assigned to Me', '0' => 'Not Assigned', '3' => 'Assigned to User'])
            ->with("status_fetch", $status_fetch)
            ->with("unregistered_modules", $wfModuleRepo->unregisteredMemberNotificationIds())
            ->with("users", $this->users->query()->where("id", "<>", access()->id())->get()->pluck('name', 'id'))
            ->with('control', $control)
            ->with('request', $input);
    }

    public function getPending()
    {
        $datatables = $this->wf_tracks->getForWorkflowDatatable();
        return $datatables->make(true);
    }

    /**
     * Assigned Workflow
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myPending(Request $request)
    {
        $input = $request->all();

        //$wf_module_groups = new WfModuleGroupRepository();
        $wfModuleRepo = new WfModuleRepository();
        $control = $this->listControl($request);
        return view("backend/system/workflow/my_pending")
            ->with("wf_modules", $wfModuleRepo->getAllActive()->pluck('name', 'id', 'id')->all())
            ->with("group_counts", $wfModuleRepo->getAssignedActiveUser())
            ->with("unregistered_modules", $wfModuleRepo->unregisteredMemberNotificationIds())
            ->with("state", "assigned")
            ->with("control", $control)
            ->with('request', $input);
    }

    /**
     * Archived Workflow
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function archived(Request $request)
    {
        $wfModuleRepo = new WfModuleRepository();
        $control = $this->listControl($request);
        return view('backend/system/workflow/archived')
            ->with('wf_modules', $wfModuleRepo->getAllActive()->pluck('name', 'id')->all())
            ->with('group_counts', $wfModuleRepo->getAssignedActiveUser(6))
            ->with('state', 'archived')
            ->with('statuses', ['2' => 'All', '1' => 'Archived by Me', '3' => 'Archived by User'])
            ->with('unregistered_modules', $wfModuleRepo->unregisteredMemberNotificationIds())
            ->with("users", $this->users->query()->where("id", "<>", access()->id())->get()->pluck('name', 'id'))
            ->with("control", $control);
    }

    /**
     * @return mixed
     * My pending with workflow pending type
     */
    public function myPendingWithType()
    {
        $wf_module_groups = new WfModuleGroupRepository();
        $wf_modules = new WfModuleRepository();
        return view("backend/system/workflow/my_pending")
            ->with("wf_modules", $wf_modules->getAllActive()->pluck('name', 'id')->all())
            ->with("group_counts", $wf_modules->getAssignedActiveUser())
            //            ->with("unregistered_modules", $wf_modules->unregisteredMemberNotificationIds())
            ->with("state", "assigned");
    }

    /**
     * Attended Workflow
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function attended(Request $request)
    {
        $wfModuleRepo = new WfModuleRepository();
        $control = $this->listControl($request, "attended");
        return view("backend/system/workflow/attended")
            ->with("wf_modules", $wfModuleRepo->getAllActive()->pluck('name', 'id')->all())
            ->with("group_counts", $wfModuleRepo->getMyAttendedActiveUser())
            ->with("state", "attended")
            ->with("statuses", ['1' => 'Attended by Me', '3' => 'Attended by User'])
            ->with("unregistered_modules", $wfModuleRepo->unregisteredMemberNotificationIds())
            ->with("users", $this->users->query()->where("id", "<>", access()->id())->get()->pluck('name', 'id'))
            ->with("control", $control);
    }

    public function progress(Request $request)
    {
        $wfModuleRepo = new WfModuleRepository();
        $control = $this->listControl($request, "progress");
        $user = access()->user();
        $unit_id = $user->unit_id;
        return view("backend/system/workflow/progress")
            ->with("wf_modules", $wfModuleRepo->getAllActive()->pluck('name', 'id')->all())
            ->with("group_counts", $wfModuleRepo->getMyUnitActiveUser($unit_id))
            ->with("unit_id", $unit_id)
            ->with("state", "progress")
            ->with("statuses", ['2' => 'All', '1' => 'Assigned to Me', '0' => 'Not Assigned', '3' => 'Assigned to User'])
            ->with("unregistered_modules", $wfModuleRepo->unregisteredMemberNotificationIds())
            ->with("users", $this->users->query()->where("id", "<>", access()->id())->get()->pluck('name', 'id'))
            ->with("control", $control);
    }

    public function allocation()
    {
        $user = Auth::user();
        $users=null;
        $review_modules = null;
        $wf_modules = new WfModuleRepository();
        if(in_array($user->unit_id,[14,15,17,6]) && (($user->designation_id != 4) && ($user->designation_id != 9)) ){
            $groups = $wf_modules->getAllActive()->where('wf_module_group_id',69)->pluck('name', 'id')->all();
            $module =  $wf_modules->claimReviewBenefitModule();
            $review_modules = $wf_modules->claimReviewBenefitModule();
           switch($user->unit_id){
               case 6:
                   $users = $this->users->query()->where('unit_id',6)->where('active',1)->get()->pluck('name', 'id');

                   break;

               case 14:
                   $users = $this->users->query()->where('unit_id',14)->where('active',1)->get()->pluck('name', 'id');
                   break;

               case 15:
                   $users = $this->users->query()->where('unit_id',15)->where('active',1)->get()->pluck('name', 'id');
                   break;

               case 17:
                   $users = $this->users->query()->where('unit_id',17)->where('active',1)->get()->pluck('name', 'id');
                   break;
           }
        }elseif($user->unit_id == 3){
            $users = $this->users->query()->get()->pluck('name', 'id');
            $groups = $wf_modules->getAllActive()->pluck('name', 'id')->all();
            $module =  $wf_modules->unregisteredMemberNotificationIds();
        }else{
            return redirect()->back()->withFlashWarning("Access Denied!");
        }

        $wf_module_groups = new WfModuleGroupRepository();
        $wf_modules = new WfModuleRepository();
        return view("backend/system/workflow/allocation")
            ->with("wf_modules", $groups)
            //->with("group_counts", $wf_modules->getActiveUser())
            ->with("state", "full")
            ->with("statuses", ['2' => 'All', '1' => 'Assigned to Me', '0' => 'Not Assigned', '3' => 'Assigned to User'])
            ->with("unregistered_modules", $module)
            ->with("review_modules", $review_modules? true:false)
            ->with("users", $users);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws WorkflowException
     */
    public function assignAllocation()
    {
        $input = request()->all();
        $this->wf_tracks->assignAllocation($input);
        return response()->json(['success' => true, 'message' => 'Success, user have been assigned to the selected resource(s)']);
    }

    public function initiate()
    {
        $input = request()->all();
        $return = $this->wf_tracks->initiateWorkflow($input);
        return redirect()->back()->withFlashSuccess("Success, Workflow has been initialized.");
    }


    public function getUsersReview(UsersReviewDataTable $dataTable)
    {
        return $dataTable->render('backend.system.workflow.users_review');
    }


    public function reversed(Request $request)
    {
        $wfModuleRepo = new WfModuleRepository();
        $control = $this->listControl($request);
        return view("backend/system/workflow/reversed")
            ->with("wf_modules", $wfModuleRepo->getAllActive()->pluck('name', 'id')->all())
            ->with("group_counts", $wfModuleRepo->getReversedActiveUser())
            ->with("state", "all")
            ->with("statuses", ['2' => 'All', '1' => 'Assigned to Me', '0' => 'Not Assigned', '3' => 'Assigned to User'])
            ->with("unregistered_modules", $wfModuleRepo->unregisteredMemberNotificationIds())
            ->with("users", $this->users->query()->where("id", "<>", access()->id())->get()->pluck('name', 'id'))
            ->with('control', $control);
    }


    public function getReversedPending()
    {
        $datatables = $this->wf_tracks->getReversedForWorkflowDatatable();
        return $datatables->make(true);
    }



    public function subordinatesSummaryView()
    {
        return view("backend/system/workflow/subordinates/subordinates_summary");
    }


    public function subordinatesSummaryDatatable()
    {
        $datatables = $this->wf_tracks->getSubordinatesSummaryDatatable();
        return $datatables->make(true);
    }


    public function subordinatePending($user_id, Request $request)
    {
        $user = $this->users->findOrThrowException($user_id);
        $wfModuleRepo = new WfModuleRepository();
        $control = $this->listSubControl($user_id, $request);

        $checkers = new CheckerRepository();
        $data = [
            'users' => [$user_id],
            'references' => ['PCRMBDOC', 'NSOPIA', 'PCRMVDOC']
        ];
       // return $checkers->getReadyToInitiateActiveUser($zoi_checklist_users);
        $stage_counts = array_merge($checkers->getTaskCount($data['users']),$checkers->getAllocatedActiveUser('CHCNOTN', $data['users']));
        return view("backend/system/workflow/subordinates/index")
            ->with("wf_modules", $wfModuleRepo->getAllActive()->pluck('name', 'id')->all())
            ->with("group_counts", $wfModuleRepo->getActiveSubordinates($user_id))
            ->with("state", "all")
            ->with("user_id", $user_id)
            ->with("user", $user)
            ->with("statuses", ['2' => 'All', '1' => 'Assigned to Me', '0' => 'Not Assigned', '3' => 'Assigned to User'])
            ->with("unregistered_modules", $wfModuleRepo->unregisteredMemberNotificationIds())
            ->with("users", $this->users->query()->where("id", "<>", $user_id)->get()->pluck('name', 'id'))
            ->with('stage_counts',$stage_counts)
            ->with('control', $control);
    }

    public function getSubordinatePending($user_id)
    {
        $datatables = $this->wf_tracks->getSubordinatesForWorkflowDatatable($user_id);
        return $datatables->make(true);
    }


    public function listSubControl($user_id, Request $request, $crid = NULL): array
    {
        $wfModuleRepo = new WfModuleRepository();
        $crRepo = new ConfigurableReportRepository();
        $control = [
            'wf_mode' => 1,
            'cr' => NULL,
            'show' => 0,
            'wfname' => 'Workflow',
            'wf_module_id' => NULL,
            'wf_definitions' => [],
            'filters' => [],
        ];
        $has_wf_module = $request->has('wf_module_id');
        if ($has_wf_module) {
            $control['show'] = 1;
            $wfmoduleid = $request->input('wf_module_id');
            $control['wf_module_id'] = $wfmoduleid;
            $wfmodule = $wfModuleRepo->find($wfmoduleid);
            if ($wfmodule) {
                $control['wfname'] = $wfmodule->name;
                if ($wfmodule->wf_mode == 2) {
                    if (!$crid) {
                        $cr = $crRepo->query()->find($wfModuleRepo->getCR($wfmoduleid));
                    } else {
                        $cr = $crRepo->query()->find($crid);
                    }
                    $wf_definitions = access()->allSubordinateWfDefinitions($user_id);
                    $control['wf_definitions'] = $wf_definitions;
                    if ($cr) {
                        $control['wf_mode'] = 2;
                        //$filters = $crRepo->setDataForSelectFilter(json_decode($cr->filter ?? '[]', true));
                        $control['cr'] = $cr;
                        //$control['filters'] = $filters;
                    }
                }
            }
        }
        //dd($control);
        return $control;
    }

    //starting of re-engineering

    /**
     * @param WfTrack $wfTrack
     * Deactivate wf track
     */
    public function deactivatePendingWfTrack(WfTrack $wfTrack)
    {
        if ($wfTrack->status == 0) {
            $wfTrack->delete();
        }
        return redirect()->back()->withFlashSuccess('Success, Entry has been removed');
    }

    public function sendingNotifications(Request $request)
    {
        //$wf_module_groups = new WfModuleGroupRepository();
        $wfModuleRepo = new WfModuleRepository();
        $control = $this->listControl($request);
        $control['wf_mode'] = 1;        //overriding wf_mode to display notification

        return view("backend/system/workflow/send_notification")
            ->with("wf_modules", $wfModuleRepo->getAllActive()->pluck('name', 'id')->all())
            ->with("group_counts", $wfModuleRepo->getAssignedNotifications())
            ->with("unregistered_modules", $wfModuleRepo->unregisteredMemberNotificationIds())
            ->with("state", "assigned")
            ->with("control", $control);
    }

    public function getNotification()
    {
        $input = request()->all();
        $notify_data = new NotificationLogsRepository();

        return DataTables::of($notify_data->getForWorkflowNotificationDatatable($input['wf_module_id']))
            ->editColumn('status', function ($notify_data) {

                if ($notify_data->status  == "Seen") {
                    return '<span class="label label-sm label-success">Seen</span>';
                } else {
                    return '<span class="tag tag-warning white_color">New Notification</span>';
                }
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function notifications(Request $request)
    {
        $wfModuleRepo = new WfModuleRepository();
        $control = $this->listControl($request);
        //Log::info($has_wf_module);
        return view("backend/system/workflow/pending")
            ->with("wf_modules", $wfModuleRepo->getAllActive()->pluck('name', 'id')->all())
            ->with("group_counts", $wfModuleRepo->getActiveUser())
            ->with("state", "all")
            ->with("statuses", ['2' => 'All', '1' => 'Assigned to Me', '0' => 'Not Assigned', '3' => 'Assigned to User'])
            ->with("unregistered_modules", $wfModuleRepo->unregisteredMemberNotificationIds())
            ->with("users", $this->users->query()->where("id", "<>", access()->id())->get()->pluck('name', 'id'))
            ->with('control', $control);
    }

    public function viewNotification($resource_id, $log_id)
    {
        // $resource_id = new NotificationLogsRepository();
        $notification_wf = NotificationWorkflow::find($resource_id);
        $incident = NotificationReport::find($notification_wf->notification_report_id);
        $wfModuleRepo = new WfModuleRepository();
        $message = DB::table('wf_notification_logs')->select('message')->where('id', $log_id)->first();

        $updateNotificationLogs = (new NotificationLogsRepository)->updateOpenedNotification($log_id);
        return view('backend/operation/claim/notification_report/reengineer/incidents/index_incident')
            ->with("wf_modules", $wfModuleRepo->getAllActive()->pluck('name', 'id')->all())
            ->with("group_counts", $wfModuleRepo->getActiveUser())
            ->with("statuses", ['3' => 'Assigned to User'])
            // ->with('incident',$incident->unregisteredMemberNotificationIds())
            ->with('incident', $incident)
            ->with('message', $message->message)
            ->with("user", $this->users->query()->where("id", "<>", access()->id())->get()->pluck('name', 'id'));
    }

    public function getPrevUsers($level, $resource_id)
    {
        $users = null;
        $input = [
            'level' => $level,
            'resource_id' => $resource_id,
        ];
        $check = (new WfDefinitionRepository())->canReverseToSelectedUser($input);
        if ($check) {
            $users = (new WfDefinitionRepository())->getPrevUsers($level, $resource_id);
        }

        return $users;
    }

    public function nextAdviceLevel($wf_definition_id)
    {
        $wf_definition = (new WfDefinitionRepository())->getCurrentLevel($wf_definition_id);
        return response()->json(['next_level_designation' => $wf_definition->definition_designation, 'success' => true, 'next_level_description' => $wf_definition->description]);
    }

    public function ReviewSubordinatesSummaryView()
    {
        return view("backend/system/workflow/subordinates/review/review_subordinate_summary");
    }
    public function informationDashboardReview(Request $request)
    {

        $dashboard = new DashboardRepository();
        $claim = $dashboard->getClaimReviewSummary(1,$request->all());
        $reengineered_summary = $dashboard->claimReviewSummaryReengineered(); // claim summary reengineered
        $selector = 6;

        return view("backend/system/workflow/subordinates/review/review_aging_analysis")
            ->with('claim',$claim)
            ->with('claim_summary2',$reengineered_summary)
            ->with('requests',$request->all())
            ->with('selector',$selector);
    }
    public function ReviewSubordinatesSummaryDatatable()
    {
        $data = $this->wf_tracks->getSubordinatesReviewSummaryDatatable();
        return app('datatables')->of($data->get())->make(true);
    }

    public function subordinaReviewtePending($user_id, Request $request)
    {
        $user = $this->users->findOrThrowException($user_id);
        $wfModuleRepo = new WfModuleRepository();
        $control = $this->reviewSubControl($user_id, $request);
       // dd( $wfModuleRepo->getReviewActiveSubordinates($user_id));
        //dd($wfModuleRepo->getAllActive()->pluck('name', 'id')->all());

        return view("backend/system/workflow/subordinates/review/index")
            ->with("wf_modules", $wfModuleRepo->getAllActive()->pluck('name', 'id')->all())
            ->with("group_counts", $wfModuleRepo->getReviewActiveSubordinates($user_id))
            ->with("state", "all")
            ->with("user_id", $user_id)
            ->with("user", $user)
            ->with("statuses", ['2' => 'All', '1' => 'Assigned to Me', '0' => 'Not Assigned', '3' => 'Assigned to User'])
            ->with("unregistered_modules", $wfModuleRepo->unregisteredMemberNotificationIds())
            ->with("users", $this->users->query()->where("id", "<>", $user_id)->get()->pluck('name', 'id'))
            ->with('control', $control);
    }
    public function getSubordinateReviewPending($user_id)
    {

        $datatables = $this->wf_tracks->getReviewSubordinatesForWorkflowDatatable($user_id);
        return $datatables->make(true);
    }

    public function reviewSubControl($user_id, Request $request, $crid = NULL): array
    {
        $wfModuleRepo = new WfModuleRepository();
        $crRepo = new ConfigurableReportRepository();
        $control = [
            'wf_mode' => 1,
            'cr' => NULL,
            'show' => 0,
            'wfname' => 'Workflow',
            'wf_module_id' => NULL,
            'wf_definitions' => [],
            'filters' => [],
        ];
        $has_wf_module = $request->has('wf_module_id');
        if ($has_wf_module) {
            $control['show'] = 1;
            $wfmoduleid = $request->input('wf_module_id');
            $control['wf_module_id'] = $wfmoduleid;
            $wfmodule = $wfModuleRepo->find($wfmoduleid);
            if ($wfmodule) {
                $control['wfname'] = $wfmodule->name;
                if ($wfmodule->wf_mode == 2) {
                    if (!$crid) {
                        $cr = $crRepo->query()->find($wfModuleRepo->getCR($wfmoduleid));
                    } else {
                        $cr = $crRepo->query()->find($crid);
                    }
                    $wf_definitions = access()->reviewSubordinateWfDefinitions($user_id,$control['wf_module_id']);
                    $control['wf_definitions'] = $wf_definitions;

                    if ($cr) {
                        $control['wf_mode'] = 2;
                        //$filters = $crRepo->setDataForSelectFilter(json_decode($cr->filter ?? '[]', true));
                        $control['cr'] = $cr;
                        //$control['filters'] = $filters;
                    }
                }
            }
        }
        return $control;
    }
    public function downloadReportReview(Request $request)
    {
        $cr = ConfigurableReport::find($request['cr_id']);
        $crRepo = new ConfigurableReportRepository();
        $input = $request->all();
         $filtersql = $crRepo->getWhereQuery($cr, $input);
        return $crRepo->download($cr->id, 0, $filtersql);
    }


    public function updateDefinitionUsersFromCertification(Request $request)
    {
        $workflows = $request->input('workflows');
        $accesss = $request->input('accesses');
        $unselected_wf = $request->input('unselectedWorkflows');
        $unselected_access = $request->input('unselectedAccesses');
        $userId = $request->input('userId');
        $user_repo = new UserRepository();
        if(!is_null($workflows)){
            $this->definitions->editCertifiedDefinitionUser($workflows);
        }
        if(!is_null($accesss)){
            $user_repo->updatePermissionUser($accesss,1);
        }
        if(!is_null($unselected_wf)){
            $this->definitions->editCertifiedDefinitionUser($unselected_wf);
        }
        if(!is_null($unselected_access)){
            $user_repo->updatePermissionUser($unselected_access,null);
        }
        if(is_null($workflows) && is_null($accesss) && is_null($unselected_wf) && is_null($unselected_access)){
            $this->certifyNon($userId);
        }

        return response()->json(['success' => true]);
    }


    public function certifyNon($userId)
    {
        $user_id = $userId;
        $user = (new UserRepository())->findOrThrowException($user_id);
        $certification = Certification::where('user_id', access()->user()->id)
            ->whereMonth('month', Carbon::parse(now())->format('m'))
            ->where('status', 0)
            ->whereNull('deleted_at')
            ->first();

        $detail = null;
        if (is_null($certification)) {
            $certification = Certification::create([
                'status' => 0,
                'user_id' => access()->user()->id,
                'month' => Carbon::now(),
                'unit_id' => access()->user()->unit_id
            ]);
            $detail = CertificationDetail::create([
                'certification_id' => $certification->id,
                'user_id' => $user_id,
                'conflict_access'=>null,
            ]);
        } else {
            $detail = CertificationDetail::where(
                'certification_id', $certification->id)->where(
                'user_id', $user_id)->first();
            if($detail){
                if($detail->conflict_access){
                    $detail->conflict_access = null;
                    $detail->save();
                }
            }

            if(!$detail){
                $detail = CertificationDetail::create([
                    'certification_id' => $certification->id,
                    'user_id' => $user_id,
                    'conflict_access'=>null,
                ]);
            }
        }
          CertificationResult::create([
            'certification_detail_id' => $detail->id,
            'permission_id' => null,
            'attended_by' => access()->user()->id,
            'certification_status' => 1,
            'implementation_status' => 0,
            'wf_definition_id' => null

        ]);

    }
    public function removeWfAccess(Request $request)
    {

        $definition = WfDefinition::find($request['workflow_id']);
        $this->definitions->updateDefinitionUsersCertification($definition, ['users' => $request['user_id'],'certification_id'=>$request['certification_id']]);
        return response()->json(['success' => true]);
    }
    public function removeAccess(Request $request)
    {

        $user_repo = new UserRepository();
        $permission = Permission::find($request['access_id']);
       $request= $request->all();
        $user_repo->updateAccess($permission,  $request);
        return response()->json(['success' => true]);
    }
    public function getUserWorkflows(Request $request)
    {
        $user_id = $request->input('user_id');
        $data =DB::table('user_wf_definition')->select('user_wf_definition.*','wf_definitions.*','users.*','user1.firstname as f1','user1.lastname as l1','wf_module.*','units.name as unit_name','cd.*')
            ->distinct()
            ->join('wf_definitions','wf_definitions.id','=','user_wf_definition.wf_definition_id')
            ->join('main.users','users.id','=','user_wf_definition.user_id')
            ->join('main.units','units.id','=','users.unit_id')
            ->join('main.wf_modules as wf_module','wf_module.id','=','wf_definitions.wf_module_id')
            ->join('main.users as user1','user1.id','=','user_wf_definition.attended')
            ->join('main.certification_details as cd','cd.user_id','=','user_wf_definition.user_id')
            ->join('main.certification_results as cr','cr.certification_detail_id','=','cd.id')
            ->where('cr.certification_status',false)
            ->whereNotNull('cr.wf_definition_id')
            ->where('user_wf_definition.user_id',$user_id)->get();

        return response()->json(['workflows' => $data]);
    }

    public function removeUser(Request $request){
        (new CertificationRepository())->removeUser($request);
        return response()->json(['success' => true]);
    }
}
