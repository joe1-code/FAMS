<?php

namespace App\Repositories;

use App\Repositories\WfDefinitionRepositoryInterface;
use Adldap\Models\User;
use App\Models\Certification\Certification;
use App\Models\Certification\CertificationDetail;
use App\Models\Certification\CertificationResult;
use App\Models\Workflow\WfDefinitionAccess;
use App\Models\Workflow\WfTrack;
use App\Repositories\Backend\Access\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use App\Models\Workflow\WfDefinition;
use Illuminate\Database\Eloquent\Model;
//use App\Repositories\Backend\Workflow\WfTrackRepository;
use App\Models\Operation\Claim\NotificationWorkflow;
use App\Models\Workflow\Wf_definition;
use App\Repositories\Backend\Finance\BouncedChequeRepository;
use App\Repositories\Backend\Operation\Claim\NotificationReportRepository;
use App\Repositories\Backend\Workflow\WfTrackRepository;
use App\Repositories\Backend\Operation\Claim\Review\ReviewBenefitReengineeringRepository;


/**
 * Class WfDefinitionRepository
 * @package App\Repositories\Backend\Workflow
 * @author Erick M. Chrysostom <e.chrysostom@nextbyte.co.tz>
 */
class WfDefinitionRepository implements WfDefinitionRepositoryInterface
{

    /**
     * Associated Repository Model.
     */
    const MODEL = Wf_definition::class;

    /**
     * @param $wf_definition_id
     * @return mixed
     * 
     */
    public function getCurrentLevel($wf_definition_id)
    {
        $wf_definition = $this->find($wf_definition_id);
        // dump($wf_definition); // changed

        return $wf_definition;

    }

    public function find($id)
    {
        return Wf_definition::find($id);
    }

    /**
     * @param $wf_definition_id
     * @return mixed
     */
    public function getPreviousLevels($wf_definition_id, $resource_id = NULL)
    {
        /*
 Previous Levels Algorithm
+--------------+-----------+--------------+--------------+------------------------------------------------------------+
|Criteria 1                                                                               |
+--------------+--------------+--------------+--------------+---------------------------------------------------------+
/ 1. If the previous level is the same unit group,
    a. If the current designation level is between 3 to 1 inclusive reverse to any one withing the same unit
    b. If the current designation level is greater than 3, reverse to only one step
/ 2. If the previous level is another unit, reverse to one higher designation level
+--------------+-----------+--------------+--------------+------------------------------------------------------------+
 */
        //$user = access()->user();
        $wf_definition = $this->getCurrentLevel($wf_definition_id);
        $processedWfDefinitionIds = (new WfTrackRepository())->query()->where(['resource_id' => $resource_id])->select(['wf_definition_id'])->pluck('wf_definition_id')->all();
        //logger($processedWfDefinitionIds);
        $levelsQuery = $this->query()
            ->select([
                'wf_definitions.id',
                'wf_definitions.unit_id',
                'wf_definitions.designation_id',
                'wf_definitions.level',
                DB::raw("'Level ' || wf_definitions.level || ' ( ' || designations.name || ' - ' || units.name || ' )'  as name")
            ])
            ->join("units", "units.id", "=", "wf_definitions.unit_id")
            ->join("designations", "designations.id", "=", "wf_definitions.designation_id")
            ->where(['wf_module_id' => $wf_definition->wf_module_id])
            ->where("wf_definitions.level", "<", $wf_definition->level)
            ->whereIn("wf_definitions.id", $processedWfDefinitionIds)
            //->where("is_optional", 0)
            ->where("allow_rejection", 1)
            //->orderByDesc("wf_definitions.level")
        ;
        //logger($wf_definition->wf_module_id);
        //logger($wf_definition->level);
        //logger($processedWfDefinitionIds);
        //logger($levelsQuery->toSql());
        if ($levelsQuery->count()) {
            //logger($levelsQuery->count());
            //$prevDefinition  = $this->getNextWfDefinition($wf_definition->wf_module_id, $wf_definition->id, -1);

            $prevDefinition  = with(clone $levelsQuery)->orderByDesc("wf_definitions.level")->first();
            //logger($levelsQuery->toSql());
            $prev_unit_id = $prevDefinition->unit->id;
            $top_relatives = collect(DB::select("with recursive results as( select ct.id, ct.parent_id, array[ct.parent_id] as path from units ct where ct.id = {$prev_unit_id} union all select n.id, n.parent_id, n.parent_id || tp.path from units n inner join results tp on tp.parent_id = n.id) select rs.id::bigint parent, path parent_path from results rs;"))->pluck("parent")->all();
            $down_relatives = collect(DB::select("with recursive results as( select ct.id, array[ct.id] as path from units ct where ct.id = {$prev_unit_id} union all select n.id, n.id || tp.path from units n inner join results tp on tp.id = n.parent_id) select rs.id::bigint child, rs.path parent_path from results rs;"))->pluck("child")->all();
            $all_relatives = array_merge($top_relatives, $down_relatives);

            //logger($all_relatives);
            $designation = $wf_definition->designation;
            if (in_array($wf_definition->unit_id, $all_relatives)) {
                //Same Unit ...

                //logger($designation->level);
                if (in_array($designation->level, [1, 2, 3, 5])) {
                    //logger("I have passed here ...");
                    //if current level is executive ... reverse to any one withing the same unit
                    /*
                    1	Director General
                    2	Head
                    3	Director
                    5	Manager
                     */
                    //logger($all_relatives);

                    //add reverse to CADM by CASM and DAS as requested by management in validation and benefit workflow
                    if(in_array($wf_definition->wf_module_id, [141, 143, 148, 151]) and $wf_definition->unit_id == 17 and $wf_definition->is_optional == 0)
                    {
                        $cadm = [14];
                        $all_relatives = array_merge($all_relatives, $cadm);
                        $levelsQuery->where("wf_definitions.is_optional", 0)->whereIn("unit_id", $all_relatives)->where("wf_definitions.level", "<>", 1)->orderByDesc("wf_definitions.level");
                    }
                    else
                    {
                        if(in_array($wf_definition->wf_module_id, [140,141,147,143,148,151,152,237]) and $wf_definition->is_optional == 0)
                        {
                            $levelsQuery->where("wf_definitions.is_optional", 0)->where("designations.id", "<>", $designation->id)->orderByDesc("wf_definitions.level")->limit(1);
                        }
                        else
                        {
                            $levelsQuery->whereIn("unit_id", $all_relatives)->where("designations.id", "<>", $designation->id)->orderByDesc("wf_definitions.level");
                        }

                    }
                    //logger($all_relatives);
                    //logger($designation->id);
                } else {
                    //the current level is not executive ... reverse to only one step
                    if(in_array($wf_definition->wf_module_id, [140,141,147,143,148,151,152,237]) and $wf_definition->is_optional == 0)
                    {
                        $levelsQuery->where("wf_definitions.is_optional", 0)->orderByDesc("wf_definitions.level")->limit(1);
                    }
                    else
                    {
                        $levelsQuery->orderByDesc("wf_definitions.level")->limit(1);
                    }

                }
            } else {
                //Different Unit ...
                if (in_array($designation->level, [1, 2, 3, 5])) {
                    //Temporary solution for "Payment By Installment II" module on reversing back to online employer
                    if(in_array($wf_definition->wf_module_id, [111]) and $wf_definition->level == 2)
                    {
                        $levelsQuery->orderByDesc("wf_definitions.level")->orderByDesc("designations.level")->limit(1);
                    }
                    else if(in_array($wf_definition->wf_module_id, [139]))
                    {
                        $levelsQuery->orderByDesc("wf_definitions.level")->orderByDesc("designations.level")->limit(1);
                    }
                    else if(in_array($wf_definition->wf_module_id, [192]))
                    {
                        $levelsQuery->orderByDesc("wf_definitions.level")->orderByDesc("designations.level")->limit(1);
                    }
                    else{
                        // Excecutives
                        //TODO: to be reviewed ...
                        // $levelsQuery->where("designations.id", "<>", $designation->id)->orderByDesc("wf_definitions.level");
                        $levelsQuery->where("designations.level", "<", 4)->whereRaw("(designations.level::int, units.id::int) not in ((?,?))", [$designation->level, $wf_definition->unit_id])->orderByDesc("wf_definitions.level");
                    }

                } else {
                    $levelsQuery->orderByDesc("wf_definitions.level")->orderByDesc("designations.level")->limit(1);
                }
            }
        }
        $levels = $levelsQuery
                        ->get()
                        ->pluck('name', 'level')
                        ->all();
        return $levels;
    }

    /**
     * @param $wf_definition_id
     * @return mixed
     */
    public function getSelectiveLevels($wf_definition_id)
    {
        $wf_definition = $this->getCurrentLevel($wf_definition_id);
        /*$levels = $this->query()->select(['wf_definitions.designation_id', DB::raw("'Level ' || wf_definitions.level || ' ( ' || designations.name || ' - ' || units.name || ' )'  as name")])->join("units", "units.id", "=", "wf_definitions.unit_id")->join("designations", "designations.id", "=", "wf_definitions.designation_id")->where(['wf_module_id' => $wf_definition->wf_module_id])->where("wf_definitions.level", ">", $wf_definition->level)->where("selective", 1)->where(function ($query) use ($wf_definition) {
            $query->where("unit_id", "<>", $wf_definition->unit_id)->where("designation_id", "<>", $wf_definition->designation_id);
        })->distinct()->toSql();*/
        //->pluck('name', 'id')->all();
        $levels = collect(DB::select("select wf_definitions.id, designations.name || ' - ' || units.name  as name from wf_definitions inner join units on units.id = wf_definitions.unit_id inner join designations on designations.id = wf_definitions.designation_id where (wf_module_id = {$wf_definition->wf_module_id}) and wf_definitions.level > {$wf_definition->level} and wf_definitions.level < ({$wf_definition->level} + 1) and selective = 1 and (unit_id, designation_id) not in (select {$wf_definition->unit_id}, {$wf_definition->designation_id})"))->pluck('name', 'id')->all();
        return $levels;
    }

    public function getUsersToSelect($wf_definition_id)
    {
        $wf_definition = $this->getCurrentLevel($wf_definition_id);
        $users = collect(DB::select("select id, concat_ws(' ', firstname, lastname) as name from users where unit_id = {$wf_definition->unit_id}"))->pluck('name', 'id')->all();
        return $users;
    }

    /**
     * @param int $sign | -1 or 1
     * @param $wf_definition_id
     * @param bool $skip | Skip optional levels
     * @return null
     */
    /* reenginering*/

    public function getLevelReengineer($sign = 1, $wf_definition_id = null, $skip = false, $action = null)
    {
        $wf_definition = $this->getCurrentLevel($wf_definition_id);
        // dd($wf_definition);
        switch (true) {
            case ($action == 1 and $wf_definition->is_override == 1):
                // $nextLevel =  $this->query()->where(['wf_module_id' => $wf_definition->wf_module_id])->where("level", ">", $wf_definition->level)->where('is_override', 2)->orderBy("id", "asc")->limit(1)->first();
                $nextLevel =  $this->query()->where(['wf_module_id' => $wf_definition->wf_module_id])->where("level", "<", $wf_definition->level)->where('has_next_start_optional', 1)->orderBy("id", "desc")->limit(1)->first();
                break;
            // case ($action == 1 and $wf_definition->is_override == 2):
            //     //display nothing
            //     break;
            // default:
            //     //$nextLevel = $this->query()->where(['wf_module_id' => $wf_definition->wf_module_id])->where("level", ">", //$wf_definition->level)->where('is_override', true)->where('is_optional', 1)->orderBy("id", "asc")->limit(1)->first();
            //     $nextLevel = $this->query()->where(['wf_module_id' => $wf_definition->wf_module_id])->where("level", ">", $wf_definition->level)->orderBy("id", "asc")->limit(1)->first();
            //     break;
        }
        if (empty($nextLevel)) {
            $return = null;
        } else {
            $return = $nextLevel->level;
        }
        return $return;
    }

    public function jumpToDefinition($wf_definition)
    {
        // $next_wf_definition = $this->query()->where(['wf_module_id' => $wf_definition->wf_module_id])->where("level", ">", $wf_definition->level)->where('is_override', 2)->orderBy("id", "asc")->limit(1)->first();
        $next_wf_definition = $this->query()->where(['wf_module_id' => $wf_definition->wf_module_id])->where("level", "<", $wf_definition->level)->where('has_next_start_optional', 1)->orderBy("id", "desc")->limit(1)->first();
        return $next_wf_definition;
    }


    /* end of Reenginering */
    public function getLevel($sign = 1, $wf_definition_id = null, $skip = false)
    {
        $wf_definition = $this->getCurrentLevel($wf_definition_id);


        if ($sign == 1) {
            if ($skip) {
                //skip optional level
                $nextLevel = Wf_definition::query()->where(['wf_module_id' => $wf_definition->wf_module_id, 'is_optional' => 0])->where("level", ">", $wf_definition->level)->orderBy("id", "asc")->limit(1)->first();
            } else {
                //proceed regularly
                $nextLevel = Wf_definition::query()->where(['wf_module_id' => $wf_definition->wf_module_id])->where("level", ">", $wf_definition->level)->orderBy("id", "asc")->limit(1)->first();
            }
            //dd($nextLevel);
        } else {
            if ($skip) {
                //skip optional level
                // if (in_array($wf_definition->wf_module_id, [141,143])) {
                //     $nextLevel = $this->query()->where(['wf_module_id' => $wf_definition->wf_module_id, 'allow_rejection' => 1])->where("level", "<", $wf_definition->level)->orderBy("id", "desc")->limit(1)->first();
                // } else {
                    $nextLevel = Wf_definition::query()->where(['wf_module_id' => $wf_definition->wf_module_id, 'is_optional' => 0])->where("level", "<", $wf_definition->level)->orderBy("id", "desc")->limit(1)->first();
                // }
            } else {
                //proceed regularly
                $nextLevel = Wf_definition::query()->where(['wf_module_id' => $wf_definition->wf_module_id])->where("level", "<", $wf_definition->level)->orderBy("id", "desc")->limit(1)->first();
            }
        }
        if (empty($nextLevel)) {
            $return = null;
        } else {
            $return = $nextLevel->level;
        }
        return $return;
    }

    public function getNextLevel($wf_definition_id, $skip = false)
    {
        return $this->getLevel(1, $wf_definition_id, $skip);
    }

    public function getPrevLevel($wf_definition_id)
    {
        return $this->getLevel(-1, $wf_definition_id);
    }

    public function getLastLevel($module_id)
    {
        $maxLevel = $this->query()->where('wf_module_id', $module_id)->max('level');
        return $maxLevel;
    }

    public function updateDefinitionUsers(Model $definition, array $input)
    {
        $users = $input['users'];

        DB::transaction(function () use ($definition, $users, $input) {
            $definition->users()->sync([]);
            $users = [];
            if (is_array($input['users']) and count($input['users'])) {
                foreach ($input['users'] as $user) {
                    array_push($users, $user);
                }
            }
            $definition->attachUsers($users);
            /*
             * Put audits and logs here for updating a users in the workflow definition
             */
            return true;
        });
    }

    public function hasUsers($wf_definition_id)
    {
        if ($this->find($wf_definition_id)->users()->count()) {
            return true;
        } else {
            return false;
        }
    }

    public function getDefinition($module_id, $resource_id)
    {
        $wf_track = new WfTrackRepository();
        $track = $wf_track->getRecentResourceTrack($module_id, $resource_id);
        if (empty($track)) {
            $definition = $this->query()->where(['wf_module_id' => $module_id, 'level' => 1])->first();
            $wf_definition_id = $definition->id;
        } else {
            $wf_definition_id = $track->wf_definition_id;
        }
        //dd($track);
        return $wf_definition_id;
    }

    /**
     * @param $module_id
     * @param $wf_definition_id
     * @param $sign
     * @param bool $skip
     * @return mixed
     */
    public function getNextDefinition($module_id, $wf_definition_id, $sign, $skip = false)
    {
        $nextLevel = $this->getLevel($sign, $wf_definition_id, $skip);
        $definition = Wf_definition::where(['wf_module_id' => $module_id, 'level' => $nextLevel])->first();
        return $definition->id;
    }

    /**
     * @param $module_id
     * @param $level
     * @return null
     */
    public function getLevelDefinition($module_id, $level)
    {
        $definition = $this->query()->where(['wf_module_id' => $module_id, 'level' => $level])->first();
        if ($definition) {
            $return = $definition->id;
        } else {
            $return = NULL;
        }
        return $return;
    }

    //Reenginering
    public function getNextWfDefinitionReengineer($module_id, $wf_definition_id, $sign, $skip = false, $action = null,$resource_id=null)
    {
        $moduleRepo = new WfModuleRepository();
        $wf_definition = $this->getCurrentLevel($wf_definition_id);
        if($wf_definition->is_optional == 1 and $wf_definition->is_override == 1 and $action == 1)
        {
            $nextLevel = $this->getLevelReengineer($sign, $wf_definition_id, $skip, $action);
        }
        else
        {
            if($module_id == $moduleRepo->bouncedPaymentModule()[0] and $wf_definition->level == 3 and !(new NotificationReportRepository())->bouncedHasBankChanges($resource_id)){
                $nextLevel = $moduleRepo->jumpLevel($moduleRepo->bouncedPaymentModule()[0]);
            }else{
                $nextLevel = $this->getLevelReengineerNext($sign, $wf_definition_id, $skip);
            }

        }

        //Log::error($nextLevel);
        //Log::info($module_id);
        $definition = $this->query()->where(['wf_module_id' => $module_id, 'level' => $nextLevel])->first();
        //Log::info($definition->toArray());
        return $definition;
    }
    //Reenginering
    public function getNextWfDefinitionBounced($module_id, $wf_definition_id, $sign, $skip = false, $action = null)
    {
        $wf_definition = $this->getCurrentLevel($wf_definition_id);

        $nextLevel = $this->getLevelReengineerNext($sign, $wf_definition_id, $skip);

        $definition = $this->query()->where(['wf_module_id' => $module_id, 'level' => $nextLevel])->first();
        //Log::info($definition->toArray());
        return $definition;
    }
    //end of reenginering

    public function getNextWfDefinition($module_id, $wf_definition_id, $sign, $skip = false)
    {
        $nextLevel = $this->getLevel($sign, $wf_definition_id, $skip);
        //Log::error($nextLevel);
        //Log::info($module_id);

        $definition = $this->query()->where(['wf_module_id' => $module_id, 'level' => $nextLevel])->first();
        //Log::info($definition->toArray());
        return $definition;
    }
    public function userHasAccess($id, $level, $module_id)
    {
        $inArray = array_merge(access()->allUsers(), access()->alternateUsers());

        $users = $this->query()->where(['level' => $level, 'wf_module_id' => $module_id])->first()->users()->whereIn('users.id', $inArray)->first();
        if (!$users) {
            $return = false;
        } else {
            $return = true;
        }

        return $return;
    }

    public function getApprovalLevel($module_id)
    {
        $_rtn = NULL;
        $check = $this->query()
            ->select([
                DB::raw('level'),
            ])
            ->where('wf_module_id', $module_id)
            ->where('is_approval', 1)
            ->first();
        if ($check) {
            $_rtn = $check->level;
        }
        return $_rtn;
    }

    /**
     * @param $from_module
     * @param $to_module
     * @param array $level_map
     * @return bool
     */
    public function transferUsers($from_module, $to_module, array $level_map)
    {
        foreach ($level_map as $level) {
            $fromdefinition = $this->query()->where(['level' => $level, 'wf_module_id' => $from_module])->first();
            $todefinition = $this->query()->where(['level' => $level, 'wf_module_id' => $to_module])->first();
            if ($fromdefinition && $todefinition) {
                $users = $fromdefinition->users()->pluck("users.id")->all();
                $todefinition->users()->syncWithoutDetaching($users);
            }
        }
        return true;
    }
     // Start of Re-engineering

    public function getLevelReengineerNext($sign = 1, $wf_definition_id = null, $skip = false)
    {
        $wf_definition = $this->getCurrentLevel($wf_definition_id);
        if ($sign == 1) {
            if ($skip) {
                //skip optional level
                $nextLevel = $this->query()->where(['wf_module_id' => $wf_definition->wf_module_id, 'is_optional' => 0])->where("level", ">", $wf_definition->level)->orderBy("id", "asc")->limit(1)->first();
            } else {
                //proceed regularly
                //dd($wf_definition->level);
                $nextLevel = $this->query()->where(['wf_module_id' => $wf_definition->wf_module_id])->where("level", ">", $wf_definition->level)->orderBy("id", "asc")->limit(1)->first();
            }
        } else {
            if ($skip) {
                //skip optional level
                $nextLevel = $this->query()->where(['wf_module_id' => $wf_definition->wf_module_id, 'allow_rejection' => 1 ])->where("level", "<", $wf_definition->level)->orderBy("id", "desc")->limit(1)->first();
                // dd($nextLevel);

            } else {
                //proceed regularly
                $nextLevel = $this->query()->where(['wf_module_id' => $wf_definition->wf_module_id])->where("level", "<", $wf_definition->level)->orderBy("id", "desc")->limit(1)->first();
            }
        }
        if (empty($nextLevel)){
            $return = null;
        } else {
            $return = $nextLevel->level;
        }
        return $return;
    }

    public function getPrevUsers($level, $resource_id)
    {
        $wf = NotificationWorkflow::select('wf_definitions.id as wf_definition_id')->where('notification_workflows.id', $resource_id)
                ->join('wf_modules', 'wf_modules.id', '=', 'notification_workflows.wf_module_id')
                ->join('wf_definitions', 'wf_definitions.wf_module_id', '=', 'wf_modules.id')
                ->where('level', $level)
                ->first();

        return $this->getPrevUsersToSelect($wf->wf_definition_id);
    }

    public function getPrevUsersToSelect($wf_definition_id)
    {
        $prev_users = DB::table('user_wf_definition')
                    ->select(DB::raw("concat_ws(' ', firstname, lastname) as name"), "users.id")
                    ->join('users', 'users.id', '=', 'user_wf_definition.user_id')
                    ->where('wf_definition_id', $wf_definition_id)->get();
        return $prev_users;
    }

    public function canReverseToSelectedUser($input)
    {
        $return = false;
        if(isset($input['level']))
        {
            $wf = NotificationWorkflow::find($input['resource_id']);
            if(!empty($wf)){
                switch ($wf->wf_module_id) {
                    // case 108:        //seeder changes reengineering
                    case 143:           //TD, TD Refund and PD workflow
                    case 141:           //validation workflow
                    case 148:           //revalidation workflow
                        if(in_array($input['level'], [3]))
                        {
                            $return = true;
                        }
                        break;
                    case 151:           //MAE workflow
                        if(in_array($input['level'], [4]))
                        {
                            $return = true;
                        }
                        break;
                    case 114:
                        if(in_array($input['level'], [2.01]))
                        {
                            $return = true;
                        }
                        break;
                    default:
                        $return = false;
                        break;
                }
            }else{
                $wf = WfTrack::find($input['resource_id'])->where('resource_type', 'App\Models\Notifications\Letter')
                    ->where('wf_definition_id',1960)->first();
                if(!empty($wf)){
                    $return = true;
                }else{
                    $return = false;
                }
            }
        }
        return $return;
    }

    public function getSelectiveLevelToDO($wf_definition_id)
    {
        $wf_definition = $this->getCurrentLevel($wf_definition_id);
        $level = WfDefinition::select(
                    [
                        "wf_definitions.id",
                        DB::raw("designations.name || ' - ' || units.name  as name")
                    ])
                    ->join('units', 'units.id', '=', 'wf_definitions.unit_id')
                    ->join('designations', 'designations.id', '=', 'wf_definitions.designation_id')
                    ->where('wf_module_id', $wf_definition->wf_module_id)
                    ->where('wf_definitions.level', '>', $wf_definition->level)
                    ->where('wf_definitions.level', '<=', $wf_definition->level + 0.01)
                    ->orderBy('wf_definitions.id')
                    ->pluck('name', 'id')
                    ->all();
        // dd($level);
        return $level;
    }

        //Reenginering
        public function getNextWfDefinitionReview($module_id, $wf_definition_id, $sign, $skip = false, $action = null,$resource_id=null)
        {
            $moduleRepo = new WfModuleRepository();
            $reviewBenefit = new ReviewBenefitReengineeringRepository();
            $wf_definition = $this->getCurrentLevel($wf_definition_id);
            $nextLevel = $wf_definition->level ++;
            logger($wf_definition->level);
            logger($module_id);
            switch ($module_id) {
                //need logics in jump level so as to jump accodingly, ie. if(3.	PD Reached MMI with change) Jump at level below, will check it tommorrow inshaallah
                case 207:
                    $nextLevel = $reviewBenefit->jumpLevel($module_id, $wf_definition->level);
                    break;
                case 209:
                    $nextLevel = $reviewBenefit->jumpLevel($module_id, $wf_definition->level);
                    break;
                case 210:
                    $nextLevel = $reviewBenefit->jumpLevel($module_id, $wf_definition->level);
                    break;
                case 211:
                    $nextLevel = $reviewBenefit->jumpLevel($module_id, $wf_definition->level);
                    break;
                case 213:
                    $nextLevel = $reviewBenefit->jumpLevel($module_id, $wf_definition->level);
                    break;
                default:
                break;
            }


            return $this->query()->where(['wf_module_id' => $module_id, 'level' => $nextLevel])->first();
        }

        public function getLevelReview($sign = 1, $wf_definition_id = null, $skip = false, $action = null)
        {
            $wf_definition = $this->getCurrentLevel($wf_definition_id);
            switch (true) {
                case ($action == 1 and $wf_definition->is_override == 1):
                    $nextLevel =  $this->query()->where(['wf_module_id' => $wf_definition->wf_module_id])->where("level", "<", $wf_definition->level)->where('has_next_start_optional', 1)->orderBy("id", "desc")->limit(1)->first();
                    break;
            }
            if (empty($nextLevel)) {
                $return = null;
            } else {
                $return = $nextLevel->level;
            }
            return $return;
        }

    public function updateWorkflowUser($workflows){

        $data = [];
        $uncertified = [];

        $workflow_ids = array_column($workflows, 'workflow_id');
        $unselected_wf = array_column($workflows, 'workflow_id_unselected');
        $user_ids = array_column($workflows, 'user_id');
        $workflow_user = null;
        if(isset($workflow_ids)&& (!empty($workflow_ids))){
            $workflow_user = DB::table('main.user_wf_definition')
                ->whereIn('user_id', $user_ids)
                ->whereNotIn('wf_definition_id', $workflow_ids)
                ->get();
        }
        if(isset($unselected_wf ) && (!empty($unselected_wf))){
            $workflow_user = DB::table('main.user_wf_definition')
                ->whereIn('user_id', $user_ids)
                ->whereIn('wf_definition_id', $unselected_wf)
                ->get();
        }

        if(!isset($unselected_wf ) && (empty($unselected_wf))){
        foreach ($workflow_user as $workflow) {
            $data[] = [
                'workflow_id' => $workflow->wf_definition_id,
                'user_id' => $workflow->user_id,
                'flag' =>1
            ];
        }
        }

        if(isset($unselected_wf) && (!empty($unselected_wf))) {
            foreach ($workflow_user as $wf) {
                $uncertified[] = [
                    'workflow_id_unselected' => $wf->wf_definition_id,
                    'user_id' => $wf->user_id,
                    'flag' => 1
                ];
            }
        }
        foreach ($workflows as &$item) {
            if (is_array($item) && (isset($item['action']) && (isset($item['workflow_id'])))) {
//            if (is_array($item) && isset($item['action'])) {
                $item['flag'] = 0;
                unset($item['action']);
            }
        }

        $this->certifyWfDefinitions($workflows);
        $this->certifyWfDefinitions($uncertified);
        $this->certifyWfDefinitions($data);


        return true;
    }

    public function certifyWfDefinitions($workflows){

        foreach ($workflows as $workflow) {
            $workflow_ids = array_column($workflow, 'workflow_id');
            $workflow_id_unselected = array_column($workflow, 'workflow_id_unselected');
            if(isset($workflow['workflow_id'])){
                $wf_definition = WfDefinition::where('id', $workflow['workflow_id'])->first();
            }
            if(isset($workflow['workflow_id_unselected'])){
                $wf_definition = WfDefinition::where('id', $workflow['workflow_id_unselected'])->first();
            }


            $user_id = $workflow['user_id'];
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
                ]);
            } else {
                $detail = CertificationDetail::where('certification_id', $certification->id)
                    ->where('user_id', $user_id)
                    ->first();
                if(!$detail){
                    $detail = CertificationDetail::create([
                        'certification_id' => $certification->id,
                        'user_id' => $user_id,
                    ]);
                }
            }

            DB::transaction(function () use ($wf_definition, $detail, $workflow,$certification) {

                $check_certification = DB::table('certification_results')
                    ->where('certification_detail_id', $detail->id)
                    ->where('wf_definition_id', $wf_definition->id)
                    ->where('attended_by', access()->user()->id)
                    ->first();
//                dd($check_certification);
                if (!$check_certification) {
                    if (isset($workflow['flag']) && (($workflow['flag'] == 0) || $workflow['flag'] == 1)) {
                        CertificationResult::create([
                            'certification_detail_id' => $detail->id,
                            'wf_definition_id' => $wf_definition->id,
                            'attended_by' => access()->user()->id,
                            'certification_status' => ($workflow['flag'] == 1) ? 1 : 0,
                            'implementation_status' => 0
                        ]);
                    }
                }
//                $certification->status = 1;
//                $certification->save();
            });
        }
    }



    public function editCertifiedDefinitionUser($workflows)
    {
        $this->updateWorkflowUser($workflows);
        return true;
    }

    public function updateDefinitionUsersCertification(Model $definition, array $input)
    {
      

        $user = (int)$input['users'];
       $workflow_user = [];
        DB::transaction(function () use ($definition, $user, $input,$workflow_user) {
            
            $certification_id = $input['certification_id'];
            $workflow_user = DB::table('main.user_wf_definition')
            ->where('wf_definition_id', $definition->id)
            ->whereNotIn('user_id', [$user])->pluck('user_id')->all();

            $definition->users()->sync([]);
            $users = [];
            // $users = [];
            // if (is_array($input['users']) and count($input['users'])) {
            //     foreach ($input['users'] as $user) {
            //         array_push($users, $user);
            //         // $users[] = $user;
            //     }
            // }

            $users[] = $user;

            $certification = Certification::where('id',$certification_id)
                ->whereMonth('month', Carbon::parse(now())->format('m'))
                ->where('status', 0)
                ->whereNull('deleted_at')->first();

            $detail = CertificationDetail::where(
                'certification_id',$certification->id)->where(
                'user_id',$input['users'])->first();

            $check_certification = CertificationResult::where('wf_definition_id',$definition->id)
                ->where('certification_detail_id',$detail->id)->first();

            $check_certification->implementation_status = true;
            $check_certification->attended_by=access()->user()->id;
            $check_certification->save();

            $definition->attachUsers($workflow_user);
            /*
             * Put audits and logs here for updating a users in the workflow definition
             */
            return true;
        });
    }

    public function previousLevelUser($wf_module_id, $level, $resource_id, $wf_status_raw = null)
    {
        $return = NULL;
        $wf_status_raw = ($wf_status_raw) ? $wf_status_raw : ("wf_tracks.status >= 0");
        $query = WfTrack::query()->select(['allocated', 'user_id'])->where("resource_id", $resource_id)->whereRaw($wf_status_raw)->whereHas("wfDefinition", function ($query) use ($wf_module_id, $level) {
            $query->whereHas("wfModule", function ($query) use ($wf_module_id) {
                $query->where("wf_modules.id", $wf_module_id);
            })->where("level", $level);
        })->orderByDesc("id")->limit(1)->first();
        if ($query) {
            $return = $query->allocated ?? $query->user_id;
        }
        return $return;
    }

}
