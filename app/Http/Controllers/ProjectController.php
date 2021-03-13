<?php

namespace App\Http\Controllers;

use App\Models\AcquiredSkill;
use App\Models\Project;
use App\Models\Subject;
use App\Models\Technology;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller {

    public function create()
    {
        return view('create_project');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $project = Project::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        if($request->subject != 'other')
        {
            $project->subjects()->attach([$request->subject]);
        }
        else {
            try{
                $subject = Subject::create([
                    'name' => $request->other_subject,
                ]);
                $project->subjects()->attach([$subject->id]);
            }
            catch(Exception $e) {
                $subject = Subject::where('name',$request->other_subject)->first();
                $project->subjects()->attach([$subject->id]);
            }
        }

        if(isset($request->techs))
            $project->technologies()->attach($request->techs);

        if(isset($request->others_technologies))
        {
            foreach($request->others_technologies as $itemT)
            {
                try{
                    $tech = Technology::create([
                        'name' => $itemT
                    ]);
                    $project->technologies()->attach([$tech->id]);
                }
                catch(Exception $e) {
                    $tech = Technology::where('name', $itemT)->first();
                    $project->technologies()->attach([$tech->id]);
                }
            }
        }

        if(isset($request->skills))
            $project->skills()->attach($request->skills);

        if(isset($request->others_skills)) {
            foreach($request->others_skills as $itemS) {
                try {
                    $skill = AcquiredSkill::create([
                        'name' => $itemS
                    ]);
                    $project->skills()->attach([$skill->id]);
                }
                catch(Exception $e) {
                    if($e->getCode() == 23000) {
                        $skill = AcquiredSkill::where('name',$itemS)->first();
                        $project->skills()->attach([$skill->id]);
                    }
                }
            }
        }

        $user = Auth::user();

        if ($user !== null && $user instanceof User) {
            $user->projects()->attach([$project->id]);
        }

        return $project;
    }

    public function get_subjects()
    {
        return Subject::get();
    }

    public function get_technologies()
    {
        return Technology::get();
    }

    public function get_skills()
    {
        return AcquiredSkill::get();
    }
}