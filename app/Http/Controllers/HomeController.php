<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('root');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if(Auth::user()->hasRole('Student'))
        {
            $projects = Project::select('projects.id','projects.name' ,'projects.start_date','projects.end_date')
                ->join('user_projects','user_projects.project_id', '=' ,'projects.id')
                ->where('user_id', Auth::user()->id)
                ->with('user','technologies','subjects','skills')
                ->get();
        }
        else {
            if($request->query('user')){
                $projects = Project::select('projects.id','projects.name' ,'projects.start_date','projects.end_date')
                    ->join('user_projects','user_projects.project_id', '=' ,'projects.id')
                    ->join('users','users.id', '=' ,'user_projects.user_id')
                    ->where('users.name', 'like' ,  '%'.$request->query('user').'%')
                    ->with('user','technologies','subjects','skills')
                    ->get();
            }
            else if($request->query('project')){
                $projects = Project::where('name','like', '%'.$request->query('project').'%')
                    ->with('user','technologies','subjects','skills')->get();
            }
            else {
                $projects = Project::with('user','technologies','subjects','skills')->get();
            }
        }
        return view('home', compact('projects'));
    }

    public function root()
    {
        if(Auth::check()){
            return redirect()->route('home');
        }
        else{
            return view('welcome');
        }
    }
}
