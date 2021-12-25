<?php


namespace App\Http\Controllers;


use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends \Laravel\Lumen\Routing\Controller
{
    public function get(Request $request, $id) {
        $project = Project::find($id);

        return response()->json(json_decode($project));
    }

    public function create(Request $request): JsonResponse
    {
        $user = Auth::user();

        $project = new Project();

        $project->name = $request->input('name');
        $project->user_id = $user->id;

        $project->save();

        return response()->json(json_decode($project));
    }

    public function update(Request $request)
    {
        $project = Project::find($request->input('projectId'));
        $project->data = $request->input('data');

        $project->save();

        return response()->json(json_decode($project));
    }

    public function rename(Request $request, string $id): JsonResponse
    {
        $user = Auth::user();

        $project = Project::where('user_id', '=', $user->id)
            ->where('projects.id', '=', $id);

        $project->update(['name' => $request->input('name')]);

        return response()->json(json_decode($project->get()));
    }

    public function delete(string $id)
    {
        $user = Auth::user();

        $project = Project::where('user_id', '=', $user->id)
            ->where('projects.id', '=', $id)
            ->delete();

        return response()->json(json_decode($id));
    }

    public function copy(Request $request): JsonResponse
    {
        $user = Auth::user();
        $projectId = $request->input('id');

        $oldProject = Project::where('user_id', '=', $user->id)
            ->where('projects.id', '=', $projectId)
            ->first();

        $newProject = new Project();

        $newProject->name = 'Copy of ' . $oldProject->name;
        $newProject->data = $oldProject->data;
        $newProject->user_id = $user->id;

        $newProject->save();

        return response()->json(json_decode($newProject));
    }

    public function projects(Request $request)
    {
        $user = Auth::user();

        $projects = Project::where('user_id', $user->id)->get();
        $projects = $this->prepareModel($projects);

        return response()->json($projects);
    }

    public function prepareModel($projects) {
        foreach ($projects as $project) {
            $project->data = json_decode($project->data);
        }

        return $projects;
    }
}
