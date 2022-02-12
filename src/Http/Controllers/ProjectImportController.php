<?php

namespace Taskday\Http\Controllers;

use Taskday\Models\Card;
use Taskday\Models\Field;
use Taskday\Models\Project;
use Taskday\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Taskday\Support\CsvParser;
use Taskday\TaskdayFacade;

use function Symfony\Component\String\s;

class ProjectImportController extends Controller
{
    public function create(Project $project)
    {
        return Inertia::render('Projects/ImportCreate', [
            'title' => "Import in $project->title",
            'breadcrumbs' => [
                [ 'name' =>  'Dashboard',                'href' => route('dashboard') ],
                [ 'name' =>  $project->workspace->title, 'href' => route('workspaces.show', $project->workspace) ],
                [ 'name' =>  $project->title,            'href' => route('projects.show', $project) ],
                [ 'name' => 'Import' ],
            ],
            'project' => $project
        ]);
    }

    public function edit(Request $request, Project $project)
    {
        return Inertia::render('Projects/ImportEdit', [
            'title' => "Import in $project->title",
            'breadcrumbs' => [
                [ 'name' =>  'Dashboard',                'href' => route('dashboard') ],
                [ 'name' =>  $project->workspace->title, 'href' => route('workspaces.show', $project->workspace) ],
                [ 'name' =>  $project->title,            'href' => route('projects.show', $project) ],
                [ 'name' => 'Import' ],
            ],
            'project' => $project
        ]);
    }

    public function store(Request $request, Project $project)
    {
        $file = $request->file('file');

        $path = $file->store(Auth::id() . '/importing/');

        $csv_header_fields = CsvParser::of(Storage::path($path))->headers();

        if (count($csv_header_fields) <= 0) {
            return redirect()->back()->withErrors('Empty csv file.');
        }

        $csv_data = CsvParser::of(Storage::path($path))->slice(0, 2);

        session()->put(Auth::id() . 'importing', $path);

        return Inertia::render('Projects/ImportEdit', [
            'title' => "Import in $project->title",
            'filename' => $request->file('file')->getClientOriginalName(),
            'data' => $csv_data,
            'headers' => $csv_header_fields,
            'breadcrumbs' => [
                [ 'name' =>  'Dashboard',                'href' => route('dashboard') ],
                [ 'name' =>  $project->workspace->title, 'href' => route('workspaces.show', $project->workspace) ],
                [ 'name' =>  $project->title,            'href' => route('projects.show', $project) ],
                [ 'name' => 'Import' ],
            ],
            'project' => $project
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $relativePath = session()->get(Auth::id() . 'importing');
        $path = Storage::path($relativePath);
        $mappings = $request->get('mapping');

        foreach(CsvParser::of($path)->toArray() as $row) {
            $card = $project->createCard(array_values($row)[0], Auth::user());

            foreach($row as $key => $value) {
                $fieldId = $mappings[$key] ?? null;
                if ($fieldId) {
                    $card->setCustom(Field::find($fieldId), $value);
                }
            }
        }

        Storage::delete($relativePath);

        return redirect()->route('projects.show', $project);
    }
}
