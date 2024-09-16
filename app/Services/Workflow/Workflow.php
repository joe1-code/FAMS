<?php

namespace App\Services\Workflow;

use App\Models\MonthlyPayment;
use App\Models\User;
use App\Models\Workflow\WfTrack;
use App\Models\Workflow_track;
use App\Repositories\PaymentsRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class Workflow
 *
 * Class to process all application workflows at different levels. It controls swiftly
 * the process of forwarding the application process and handle the proper completion of
 * each workflow.
 *
 * @author     Erick Chrysostom <e.chrysostom@nextbyte.co.tz>
 * @category   MAC
 * @package    App\Services\Workflow
 * @subpackage None
 * @copyright  Copyright (c) Workers Compensation Fund (WCF) Tanzania
 * @license    Not Applicable
 * @version    Release: 1.02
 * @link       None
 * @since      Class available since Release 1.0.0
 */

class Workflow
{

    /**
     * @var
     */
    private $level;

    /**
     * @var
     */
    private $wf_module_group_id;

    /**
     * @var
     */
    public $wf_module_id;

    /**
     * @var
     */
    private $resource_id;

    /**
     * @var
     */
    public $wf_definition_id;

    /**
     * @var WfDefinitionRepository
     */
    private $wf_definition;
    
    /**
     * @var PaymentsRepository
     */
    private $paymentsRepository;

    /**
     * @var WfModuleRepository
     */
    private $wf_module;

    /**
     * @var WfTrackRepository
     */
    public $wf_track;



    /**
     * Workflow constructor.
     * @param array $input
     * @throws GeneralException
     */
    public function __construct(array $input)
    {
        // $this->paymentsRepository = $paymentRepository;

        $this->resource_id = (isset($input['resource_id']) ? $input['resource_id'] : null);
        foreach ($input as $key => $value) {
            switch ($key) {
                case 'wf_module_group_id':
                $this->wf_module_group_id = $input['wf_module_group_id'];
                $this->wf_module_id = $input['wf_module_id'];
                break;
                case 'wf_module_id':
                $wf_module_id = $input['wf_module_id'];
                $this->wf_module_id = $wf_module_id;
                $this->wf_module_group_id = $input['wf_module_group_id'];
                break;
            }
        }
        /**
         * Get current values .....
         */
        $monthlyPayment = new MonthlyPayment();

        $this->wf_definition_id = (new PaymentsRepository($monthlyPayment))->getDefinition($this->wf_module_id, $this->resource_id);
    }

    /**
     * @param bool $skip
     * @param int $wf_definition
     * @return null
     */
    public function nextLevel($skip = false, $wf_definition = 0)
    {
        if ($wf_definition) {
            $definition = $this->wf_definition->getCurrentLevel($wf_definition);
            $return = $definition->level;
        } else {
            $return = $this->wf_definition->getNextLevel($this->wf_definition_id, $skip);
        }
        return $return;
    }

    /**
     * @return null
     */
    public function prevLevel()
    {
        return $this->wf_definition->getPrevLevel($this->wf_definition_id);
    }

    /**
     * @return mixed
     */
    public function lastLevel()
    {
        return $this->wf_definition->getLastLevel($this->wf_module_id);
    }

    /**
     * @return mixed
     */
    public function currentLevel()
    {
        $wf_definition = $this->wf_definition->getCurrentLevel($this->wf_definition_id);
        return $wf_definition->level;
    }

    /**
     * @return bool
     */
    public function hasRecentApproval()
    {
        return $this->wf_track->hasRecentApproval($this->resource_id, $this->wf_module_id);
    }

    public function getApprovalLevel()
    {
        return $this->wf_definition->getApprovalLevel($this->wf_module_id);
    }

    /**
     * @return mixed
     */
    public function previousLevels()
    {
        $levels = $this->wf_definition->getPreviousLevels($this->wf_definition_id, $this->resource_id);
        return $levels;
    }

    /**
     * @return mixed
     */
    public function selectiveLevels()
    {
        $levels = $this->wf_definition->getSelectiveLevels($this->wf_definition_id);
        return $levels;
    }

    public function getUsersToSelect()
    {
        $users = $this->wf_definition->getUsersToSelect($this->wf_definition_id);
        return $users;
    }

    /**
     * @param bool $accuracy | if accuracy is set true, fetch accurate module depend on the resource_id. This happen when same group and type have active workflow modules still pending.
     * @return mixed
     */
    public function getModule($accuracy = false)
    {
        $return = $this->wf_module_id;
        if ($accuracy) {
            switch ($this->wf_module_group_id) {
                case 3:
                case 4:
                if (!is_null($this->resource_id)) {
                        //$incident = (new NotificationReportRepository())->query()->where("id", $this->resource_id)->first();
                    $workflow = (new NotificationWorkflowRepository())->query()->where("id", $this->resource_id)->first();
                    $incident = $workflow->notificationReport;
                    if ($incident->isprogressive) {
                            //Progressive Notification Report
                        $module = $this->wf_module->query()->select(["type", "wf_module_group_id"])->where("id", $this->wf_module_id)->first();
                        $moduleIds = $this->wf_module->query()->where(["type" => $module->type, "wf_module_group_id" => $module->wf_module_group_id])->pluck("id")->all();
                        $workflow = $incident->workflows()->whereIn("notification_workflows.wf_module_id", $moduleIds)->select(["wf_module_id"])->limit(1)->first();
                        $return = $workflow->wf_module_id;
                    } else {

                    }
                }
                break;
            }
        }
        return $return;
    }

    /**
     * Level for performing claim assessment level
     * @return int|null
     */
    public function claimAssessmentLevel()
    {
        $assessment_level = null;
        switch ($this->wf_module_id) {
            // Basic Procedure - wf_module
            case 3:
            $assessment_level = 4;
            break;
            // Proposed Procedure 1 Occupation Accident, Disease & Death
            case 10:
            $assessment_level = 7;
            break;
            case 18:
            case 76:
                //Claim Benefits
            $assessment_level = 7;
            break;
        }
        return $assessment_level;
    }


    /**
     * Level for performing payroll payment level
     * @return int|null
     */
    public function payrollFinancePaymentLevel()
    {
        $finance_level = null;
        switch ($this->wf_module_id) {
            // Basic Procedure - wf_module
            case 28:
            $finance_level = 12;
            break;

            /*Procedure: 9L*/
            case 63:
            $finance_level = 9;
            break;

        }
        return $finance_level;
    }

    /**
     * @param $sign
     * @param $skip
     * @return mixed
     */
    public function nextDefinition($sign, $skip = false)
    {
        return $this->wf_definition->getNextDefinition($this->wf_module_id, $this->wf_definition_id, $sign, $skip);
    }

    /**
     * @param $level
     * @return mixed
     */
    public function levelDefinition($level)
    {
        return $this->wf_definition->getLevelDefinition($this->wf_module_id, $level);
    }

    /**
     * @param $level
     * @return mixed
     */
    public function previousLevelUser($level)
    {
        return $this->wf_track->previousLevelUser($this->wf_module_id, $level, $this->resource_id);
    }

    /**
     * @param $sign
     * @param $skip
     * @return mixed
     */
    public function nextWfDefinition($sign, $skip = false)
    {
        return $this->wf_definition->getNextWfDefinition($this->wf_module_id, $this->wf_definition_id, $sign, $skip);
    }

    /**
     * @return mixed
     */
    public function currentWfDefinition()
    {
        $wf_definition = $this->wf_definition->getCurrentLevel($this->wf_definition_id);
        return $wf_definition;
    }

    public function hasActiveWfDefinition()
    {
        $count = $this->wf_track->query()->where(['resource_id' => $this->resource_id, 'wf_definition_id' => $this->wf_definition_id, 'status' => 0])->count();
        return $count;
    }

    /**
     * @return mixed
     */
    public function currentWfTrack()
    {
        return $this->wf_track->getRecentResourceTrack($this->wf_module_id, $this->resource_id);
    }

    /**
     * @return mixed
     */
    public function currentTrack()
    {
        $wfTrack = $this->currentWfTrack();
        return $wfTrack->id;
    }

    /**
     * @param $level
     * @throws GeneralException
     * @description check if the resource is at specified workflow and has already assigned ...
     */
    public function checkLevel($level)
    {
        //dd($this->wf_definition_id);
        $wfTrack = $this->currentWfTrack();

        if ((int) $level == (int) $this->currentLevel()) {
            if ($wfTrack->assigned == 1) {
                $return = ['success' => true];
            } else {
                $return = ['success' => false, 'message' => trans('exceptions.backend.workflow.level_not_assigned')];
            }
            //dd($return);
        } else {
            $return = ['success' => false, 'message' => trans('exceptions.backend.workflow.level_error')];
        }
        if (!$return['success']) {
            throw new GeneralException($return['message']);
        };
    }

    /**
     * @param array ...$levels
     * @throws GeneralException
     * @description Check for Multi level, if the resource is at specified workflow and has already assigned
     */
    public function checkMultiLevel(...$levels)
    {
        $wfTrack = $this->currentWfTrack();
        $return = [];
        foreach ($levels as $level) {
            if ($level == $this->currentLevel()) {
                if ($wfTrack->assigned == 1) {
                    $return = ['success' => true];
                } else {
                    $return = ['success' => false, 'message' => trans('exceptions.backend.workflow.level_not_assigned')];
                }
                break;
            }
        }
        if (empty($return)) {
            $return = ['success' => false, 'message' => trans('exceptions.backend.workflow.level_error')];
        }
        if (!$return['success']) {
            throw new GeneralException($return['message']);
        };
    }

    /**
     * @param $id
     * @param $level
     * @return bool
     * @description check if user has access to a specific level
     */
    public function userHasAccess($id, $level)
    {
        if (env("TESTING_MODE", 0)) {
            $return = true;
        } else {

            $return = $this->wf_definition->userHasAccess($id, $level, $this->wf_module_id);
        }
        return $return;
    }

    /**
     * @description check if current definition has restrictive to only allocated user
     * @return bool
     */
    public function restrictiveCheck()
    {
        $return = true;
        $definition = $this->currentWfDefinition();
        if ($definition) {
            if ($definition->isrestrictive) {
                $track = $this->currentWfTrack();
                if ($track) {
                    if ($track->user_id != access()->id()) {
                        $return = false;
                    }
                }
            }
        }
        return $return;
    }

    public function createLogs($inputs){

        // DB::transaction(function() use($inputs){
            $data = new Workflow_track();

            $data->user_id = $inputs['user_id'];
            $data->status = 1;
            $data->resource_id = $inputs['resource_id'];
            $data->wf_definition_id = $this->wf_definition_id;
            $data->comments = $inputs['comments'];
            $data->assigned = 0;
            $data->receive_date = Carbon::now();
            $data->forward_date = Carbon::now();
            $data->assigned = 0;

            $data->save();

            DB::commit();
            dd('<======================end transaction====================================>');

            
        // });
        

        return true;

    }

    /**
     * Write a workflow for the first time
     * @param $input
     * @param int $source, determine whether source is 2 => online or 1 => internally.
     * @throws GeneralException
     * @description Create a new workflow log
     */
    public function createLog($input, $source = 1)
    {
        // dd($input, $source, $this->wf_definition_id);

            DB::getQueryLog();
                // $insert->status = 1;
                // $insert->resource_id = $input['resource_id'];
                // $insert->assigned = 0;
                // $insert->comments = $input['comments'];
                // $insert->wf_definition_id = $this->wf_definition_id;
                // $insert->receive_date = Carbon::now();
                // $insert->forward_date = Carbon::now();
                // $insert->user_id = $input['user_id'];

               
                /*Check if definition for this resource already created to avoid duplicate*/
                $check_if_already_created = $this->checkIfResourceDefinitionIsAlreadyPending();
                if($check_if_already_created == false) {
                    
                    $Wf_Track = new WfTrack();

                    // $data->user_id = $input['user_id'];
                    // $data->status = 1;
                    // $data->resource_id = $input['resource_id'];
                    // $data->wf_definition_id = $this->wf_definition_id;
                    // $data->comments = $input['comments'];
                    // $data->assigned = 0;
                    // $data->receive_date = Carbon::now();
                    // $data->forward_date = Carbon::now();
                    // $data->payment_type = null;
                    // $data->resource_type = null;
                    // $data->allocated = null;

                    // $data->save();

                    // DB::commit();



                       $wf_track = WfTrack::create([
                            'user_id' => $input['user_id'],
                             'status' => 1,
                             'resource_id' => $input['resource_id'],
                             'wf_definition_id' => $this->wf_definition_id,
                             'comments' => $input['comments'],
                             'assigned' => 0,
                             'parent_id' => null,
                             'receive_date' => Carbon::now(),
                             'forward_date' => Carbon::now(),
                             'payment_type' => null,
                             'resource_type' => null,
                             'allocated' => null,
                             'created_at' => Carbon::now(),
                             'updated_at' => Carbon::now(),
                             'deleted_at' => null

                         ]);
                         DB::commit();

                    // dd('<======================end transaction====================================>');

                    // });

                    // DB::listen(function($query){
                    //     logger($query->sql, $query->bindings);
                    //     logger(DB::connection()->getDatabaseName());
                    // });


                    
            // switch ($source) {
            //     case 1:
            //         if ($input['user_id']) {
            //             $user = new User();

            //             $userRepo = new UserRepository($user);

            //             $user = $userRepo->find($input['user_id']);
                    
            //         } else {
            //             $user = Auth()->user();
            //         }

            //         $Wf_Track->user_id = $user;
            //         $Wf_Track->assigned = 1;
            //         $user->wfTracks()->save($wf_track);
            //         break;
            //     case 2:
            //         $userRepo = new PortalUserRepository();
            //         $user = $userRepo->query()->find($input['user_id']);
            //         $wf_track->user_id = $input['user_id'];
            //         $wf_track->assigned = 1;
            //         $user->wfTracks()->save($wf_track);
            //         break;
            //     case 3:
            //         $user = HcpUser::find($input['user_id']);
            //         $wf_track->user_id = $input['user_id'];
            //         $wf_track->assigned = 1;
            //         $user->wfTracks()->save($wf_track);
            //         break;
            // }
            //update Resource Type for the current wftrack
            $this->updateResourceType($wf_track);

            $nextInsert = $this->upNew($input);
            $wf_track = $track->query()->create($nextInsert); // changed

            //update Resource Type for the next wftrack
            $this->updateResourceType($wf_track);
        }
    }

    /**
     * @param Model $wfTrack
     * @throws GeneralException
     * @description Update the resource type form different resources.
     */
    private function updateResourceType(Model $wfTrack)
    {
        $resourceId = $wfTrack->resource_id;
        $wfModule = $wfTrack->wfDefinition->wfModule;
        $moduleGroupId = $wfModule->WfModuleGroup->id;
        $type = $wfModule->type;

        //$this->wf_module_group_id
        switch ($moduleGroupId) {
            case 1:
                //Monthly Payments
            $monthlypaymentModel = new MonthlyPayment();

            $monthlyPayment = (new PaymentsRepository($monthlypaymentModel))->find($resourceId);

            $monthlyPayment->wfTracks()->save($wfTrack);
            break;
            
            default:
            break;
        }


    }

    /**
     * @param $input_update
     * @description Update the existing workflow
     */
    public function updateLog($input_update)
    {
        $track = new WfTrackRepository();
        $wf_track = $track->find($this->currentTrack());
        $wf_track->update($input_update);
    }

    /**
     * Assigning a workflow
     * @deprecated since version 1.00
     */
    public function assign()
    {
        $track = new WfTrackRepository();
        $wf_track = $track->find($this->currentTrack());
        $wf_track->user_id = access()->id();
        $wf_track->save();
    }

    /**
     * @param array $input
     * @throws GeneralException
     * @description create the next level information/workflow log.
     */
    public function forward(array $input)
    {
        $wf_track = new WfTrackRepository();
        //Process for optional workflow level, check if has been selected...
        $currentTrack = $this->currentWfTrack();
        $select_next_start_optional = (($currentTrack->status == 4) ? 1 : 0);
        $currentDefinition = $currentTrack->wfDefinition;
        $skip = false;
        switch (true) {
            case ($currentDefinition->has_next_start_optional And !$select_next_start_optional And !$currentDefinition->is_optional):
            case (!$currentDefinition->has_next_start_optional And !$select_next_start_optional And !$currentDefinition->is_optional):
            case ($currentDefinition->has_next_start_optional And !$select_next_start_optional And $currentDefinition->is_optional): //Added Recently
                //This logic computed from the truth table, may need re-design.
                //Skip Optional level
            $skip = true;
            break;
            default:
                //Continue Regular
            $skip = false;
            break;
        }

        //update notification assessor workflows and checker status for assessment officer level for benefit workflows and validation workflows
        // if($currentDefinition->level == 3 and in_array($currentDefinition->wf_module_id, [108, 116, 117, 105, 106, 112, 113]))       //seeder changes reengineering
        if($currentDefinition->level == 3 and in_array($currentDefinition->wf_module_id, [143, 151, 152, 237, 140, 141, 147, 148]))
        {
            (new AssessmentRepository())->updateNotificationAssessorWorkflowAttended($currentTrack->resource_id);

            //generate vendor form and send sms notification to beneficiary
            // if(in_array($currentDefinition->wf_module_id, [108, 116, 117]))          //seeder changes reengineering
            if(in_array($currentDefinition->wf_module_id, [143, 151])) (new NotificationReportRepository())->notifyForBeneficiaryBankDetailsCollection($currentTrack->resource_id);
        }
        //update checker status for benefit workflow after claim computation by CADO
        if($currentDefinition->level == 6 and $currentDefinition->wf_module_id == 143 and $currentTrack->status == 1)
        {
            (new NotificationReportRepository())->updateClaimComputationStatusInChecker($currentTrack->resource_id);
        }
        //assigning status to input variable array to reuse in upNew method to trigger forward to next level when seeking advice.

        // Close Inbox and task for Online Notification Application checker ==CCONTFCAPPCTN
        if($currentDefinition->wf_module_id == 36 && $currentDefinition->level == 2){
             (new CheckerRepository())->closeRecently([
                'resource_id' => $currentTrack->resource_id,
                'checker_category_cv_id' =>(new CodeValueRepository())->findIdByReference('CCONTFCAPPCTN'),
            ], 1);
        }

        $input['status'] = $currentTrack->status;
        $nextInsert = $this->upNew($input, $skip);
        $newTrack = $wf_track->query()->create($nextInsert);

        //update Resource Type for the next wftrack
        $this->updateResourceType($newTrack);
    }

    /**
     * Create the next workflow for the next level to be assigned
     * to the next available user/staff
     * @param $input
     * @param $skip
     * @return array
     */
    public function upNew(array $input, $skip = false)
    {
        $insert = [
            'status' => 0,
            'resource_id' => $input['resource_id'],
            'assigned' => 0,
            'parent_id' => $this->currentTrack(),
            'receive_date' => Carbon::now(),
            //'wf_definition_id' => $this->nextDefinition($input['sign']),
        ];

        if ($input['sign'] == -1) {
            $level = $input['level'];
            $insert['wf_definition_id'] = $this->levelDefinition($level);
            $checklist_user = null;
            if($input['status'] == 12 and $input['level'] == 1){
                $checklist_user = (new NotificationReportRepository())->returnFileChecklistUser($input['resource_id']);
            }

            if(!is_null($checklist_user)){
                $user = $checklist_user;
            } else{
                $user = $this->previousLevelUser($level);
            }
            if (is_null($user)) {
                $nextWfDefinition = $this->wf_definition->find($insert['wf_definition_id']);
                $user = (new WfAllocationRepository())->getAllocation($nextWfDefinition,  $this->currentLevel(), $input['resource_id']);
            }

            if ($user) {
                $insert['user_id'] = $user;
                $insert['allocated'] = $user;
            }

            $insert['assigned'] = 1;
            if ($input['source'] == 1) {
                $insert['user_type'] = "App\Models\Auth\User";
            } elseif ($input['source'] == 2) {
                $insert['user_type'] = "App\Models\Auth\PortalUser";
            }
            elseif ($input['source'] == 3) {
                $insert['user_type'] = "App\Models\Auth\HcpUser";
            }

        } else {
            $wf_definition = 0;  //if user specified a specific level to forward
            $assigned = 0;
            if (isset($input['wf_definition'])) {
                if ($input['wf_definition']) {
                    $wf_definition = $input['wf_definition'];
                    $insert['wf_definition_id'] = $wf_definition;
                } else {
                    //reengineering caprturing of next workflow definition to jump a resource to.
                    // Re-engineering  then go to upNew for updation
                    $current_wfDefinition = $this->currentWfDefinition();
                    // dd($input);
                    if ($current_wfDefinition->is_override == 1 && $input['status'] == 1) {
                        $next_wf_definition = $this->wf_definition->jumpToDefinition($current_wfDefinition);
                        //check if next wf definition to recommend exists
                        // dd($next_wf_definition);
                        if ($next_wf_definition) {
                            //if yes, then
                            $insert['wf_definition_id'] = $next_wf_definition->id;
                        } else {
                            //if no, then
                            $insert['wf_definition_id'] = $this->nextDefinition($input['sign'], $skip);
                        }
                    } else {
                        // dd('not there hehehe');
                        $insert['wf_definition_id'] = $this->nextDefinition($input['sign'], $skip);
                    }
                }
            } else {
                $insert['wf_definition_id'] = $this->nextDefinition($input['sign'], $skip);
            }
            $level = $this->nextLevel($skip, $insert['wf_definition_id']);

            $user =$this->previousLevelUser($level);
            if (isset($input['select_user'])) {
                if ($input['select_user']) {
                    $user = $input['select_user'];
                    $assigned = 1;
                }
            }

            if (!$user) {
                $group = (new WfGroupRepository())->query()->where("id", $this->wf_module_group_id)->first();

                if ($group->autolocate) {
                    $nextWfDefinition = $this->wf_definition->find($insert['wf_definition_id']);
                    switch ($nextWfDefinition->user_selector) {
                        case 1:
                            // Using Incident User Allocations ...
                            switch ($this->wf_module_group_id) {
                                case 3:
                                    // Notification & Claim Processing
                                    $incident = (new NotificationReportRepository())->find($input['resource_id']);
                                    $iuc_cv_id = (new CodeValueRepository())->IUCASSMALCN(); // Incident User Category : Notification & Claim Checklist
                                    $user = (new UserRepository())->getNewAllocatedForNotificationChecklistLocation($incident->district, $iuc_cv_id);
                                    break;
                            }
                            break;
                        default:

                            break;
                    }

                    if(!$user){
                        if(in_array($nextWfDefinition->wf_module_id,[226,228,211,227,229,230,225,231,209,210,211,212,213,214,215,216,217,218])){
                            switch($nextWfDefinition->wf_module_id){
                                case 209:
                                   switch($nextWfDefinition->level){
                                       case 2:
                                       case 7:
                                           $user = (new ReviewBenefitReengineeringRepository())->reviewWorkflowAllocationUser($input['resource_id'],$nextWfDefinition->unit_id);

                                       break;
                                       //get review computation officer
                                       case 4;
                                           $allocation = new WfAllocationRepository();
                                           $user = $allocation->getReviewComputationOfficer();
                                       break;
                                   }
                               break;
                               case 212:
                               case 214:
                               case 215:
                               case 216:
                               case 217:
                               case 218:
                               case 228:
                                   switch($nextWfDefinition->level){
                                       case 2:
                                       case 5:
                                           $user = (new ReviewBenefitReengineeringRepository())->reviewWorkflowAllocationUser($input['resource_id'],$nextWfDefinition->unit_id);
                                       break;
                                   }
                               break;
                                case 211:
                                   switch($nextWfDefinition->level){
                                       case 2:
                                       case 4:
                                       case 10:
                                           $user = (new ReviewBenefitReengineeringRepository())->reviewWorkflowAllocationUser($input['resource_id'],$nextWfDefinition->unit_id);
                                       break;
                                       case 7;
                                           $allocation = new WfAllocationRepository();
                                           $user = $allocation->getReviewComputationOfficer();
                                       break;
                                   }
                               break;

                            case 231:
                                switch($nextWfDefinition->level){
                                    case 2:
                                    case 8:
                                        $user = (new ReviewBenefitReengineeringRepository())->reviewWorkflowAllocationUser($input['resource_id'],$nextWfDefinition->unit_id);
                                    break;
                                    case 5;
                                        $allocation = new WfAllocationRepository();
                                        $user = $allocation->getReviewComputationOfficer();
                                    break;

                                }
                            break;
                            case 210:
                                switch($nextWfDefinition->level){
                                    case 2:
                                    case 5:
                                    case 10:
                                        $user = (new ReviewBenefitReengineeringRepository())->reviewWorkflowAllocationUser($input['resource_id'],$nextWfDefinition->unit_id);
                                    break;
                                    case 7;
                                        $allocation = new WfAllocationRepository();
                                        $user = $allocation->getReviewComputationOfficer();
                                    break;
                                }
                                break;
                            case 213:
                                switch($nextWfDefinition->level){
                                    case 2:
                                    case 4:
                                    case 6:
                                        $user = (new ReviewBenefitReengineeringRepository())->reviewWorkflowAllocationUser($input['resource_id'],$nextWfDefinition->unit_id);
                                    break;
                                    case 9;
                                        $allocation = new WfAllocationRepository();
                                        $user = $allocation->getReviewComputationOfficer();
                                    break;
                                }
                            break;
                            }

                        }
                    }
                    if (!$user) {
                        // Using Workflow User Defaults ...
                        if ($nextWfDefinition->ref_level){
                            /* Get allocation by ref level */
                            $user = (new WfAllocationRepository())->getAllocationByRefLevel($nextWfDefinition, $input['resource_id']);
                        } else  {
                            /*Get allocation*/
                            $user = (new WfAllocationRepository())->getAllocation($nextWfDefinition,  $this->currentLevel(), $input['resource_id']);
                        }
                        $assigned = 1;
                    }
                }
            }
            if (!is_null($user)) {
                $assigned = 1;
                $insert['assigned'] = $assigned;
                $insert['user_id'] = $user;
                $insert['allocated'] = $user;
                $insert['user_type'] = "App\Models\Auth\User";
            }
        }

        //override user_id and allocated in wftrack for reversed workflow which are re-assigned to another user
        if (isset($input['level']) and (new WfDefinitionRepository())->canReverseToSelectedUser($input)) {
            if (isset($input['select_user'])) {
                if ($input['select_user']) {
                    $insert['assigned'] = 1;
                    $insert['user_id'] = $input['select_user'];
                    $insert['allocated'] = $input['select_user'];
                }
            }
        }

        //throw new WorkflowException($insert['status']);
        event(new BroadcastWorkflowUpdated($this->wf_module_id, $this->resource_id, $level));
        return $insert;
    }

    /**
     * Check if user has participated in the previous module level.
     * User should not participate twice in the same module.
     * @return bool
     */
    public function hasParticipated()
    {
        $return = $this->wf_track->hasParticipated($this->wf_module_id, $this->resource_id, $this->currentLevel());
        if ($return And env("TESTING_MODE")) {
            $return = false;
        }
        return $return;
    }

    /**
     * @param $input
     * @param $input_update
     * @throws GeneralException
     * @description Workflow Approve Action -- Forward to next level or complete level
     * @deprecated since version 1.00
     */
    public function wfApprove($input,$input_update)
    {
        $this->updateLog($input_update);
        if (!is_null($this->nextLevel())) {
            $this->forward($input);
        }
    }

    /**
     * @description Remove/Deactivate wf_tracks when resource id is cancelled / undone / removed.
     */
    public function wfTracksDeactivate()
    {
        $track = new WfTrackRepository();
        $wf_tracks = $track->query()->where('resource_id', $this->resource_id)->whereHas('wfDefinition', function ($query) {
            $query->where('wf_module_id', $this->wf_module_id);
        })->orderBy('id','desc');
        $wf_tracks->delete();
    }

    /**
     * @return bool
     * @description check if resource has workflow
     */
    public function checkIfHasWorkflow()
    {
        if ($this->currentWfTrack()){
            $return = true;
        } else {
            $return = false;
        }
        return $return;
    }

    /**
     * @return bool
     * @description Check if the workflow resource have had a completed workflow module trip
     */
    public function checkIfExistWorkflowModule()
    {
        $return = false;
        switch ($this->wf_module_group_id) {
            case 4:
            case 3:
                //Claim & Notification Processing
            $notificationReport = (new NotificationReportRepository())->query()->select(['isprogressive', 'id'])->find($this->resource_id);
            if ($notificationReport->isprogressive) {
                    //This is progressive notification
                if ($notificationReport->workflows()->where(["wf_module_id" => $this->wf_module_id, "wf_done" => 1])->limit(1)->count()) {
                    $return = true;
                }
            } else {
                    //This is legacy notification report
                $return = $this->wf_track->checkIfExistWorkflowModule($this->resource_id, $this->wf_module_id);
            }
            break;
            default:
            $return = $this->wf_track->checkIfExistWorkflowModule($this->resource_id, $this->wf_module_id);
            break;
        }
        return $return;
    }

    /**
     * @return bool
     * @deprecated
     */
    public function checkIfExistDeclinedWorkflowModule()
    {
        $return = false;
        switch ($this->wf_module_group_id) {
            case 4:
            case 3:
                //Claim & Notification Processing
            $notificationReport = (new NotificationReportRepository())->query()->select(['isprogressive', 'id'])->find($this->resource_id);
            if ($notificationReport->isprogressive) {
                    //This is progressive notification
                if ($notificationReport->workflows()->where(["wf_module_id" => $this->wf_module_id, "wf_done" => 2])->limit(1)->count()) {
                    $return = true;
                }
            } else {
                    //This is legacy notification report
                $return = $this->wf_track->checkIfExistDeclinedWorkflowModule($this->resource_id, $this->wf_module_id);
            }
            break;
            default:
            $return = $this->wf_track->checkIfExistDeclinedWorkflowModule($this->resource_id, $this->wf_module_id);
            break;
        }
        return $return;
    }

    /**
     * @description Check if is at Level 1 Pending
     * @return bool
     */
    public function checkIfIsLevel1Pending()
    {
        $return = $this->checkIfIsLevelPending(1);
        return $return;
    }

    /**
     * @description Check if is at defined Level Pending
     * @param $level_id
     * @return bool
     */
    public function checkIfIsLevelPending($level_id)
    {
        $current_level  = $this->currentLevel();
        $current_status = $this->currentWfTrack()->status;
        if ((int) $current_level == $level_id && $current_status == 0){
            $return = true;
        } else {
            $return = false;
        }
        return $return;
    }

    /**
     * @param $level
     * @throws GeneralException
     * @description check if can initiate a level
     */
    public function checkIfCanInitiateAction($level)
    {

        if ($this->checkIfHasWorkflow()) {
            $this->checkLevel($level);
        }
    }

    /**
     * @param $level1
     * @param null $level2
     * @throws GeneralException
     */
    public function checkIfCanInitiateActionMultiLevel($level1, $level2 = null)
    {
        if ($this->checkIfHasWorkflow()) {
            $this->checkMultiLevel($level1, $level2);
        }
    }

    /*Check if current resource definition is pending - when creating new log wf*/
    public function checkIfResourceDefinitionIsAlreadyPending()
    {
        $wf_track = new WfTrack();

        $wf_track =  $wf_track->query()->where('resource_id', $this->resource_id)->where('wf_definition_id', $this->wf_definition_id)->where('status',0)->count();

        if($wf_track > 0){
            return true;
        }else{
            return false;
        }
    }

    public function nextWfDefinitionReengineer($sign, $skip = false, $action = NULL)
    {
        return $this->wf_definition->getNextWfDefinitionReengineer($this->wf_module_id, $this->wf_definition_id, $sign, $skip, $action,$this->resource_id);
    }

    public function getNextWfDefinitionReview($sign, $skip = false, $action = NULL)
    {
        return $this->wf_definition->getNextWfDefinitionReview($this->wf_module_id, $this->wf_definition_id, $sign, $skip, $action,$this->resource_id);
    }




}
