<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Project;

class ProjectController extends Controller
{
  public function index() {
		try {
			$projects = Project::orderBy('name', 'asc')->get();
			return response()->json([
				'projects' => $projects
			]);
		} catch (\Throwable $th) {
			return response()->json([
				'message' => 'Не удалось получить список проектов'
			], 500);
		}
  }

	public function getOne($projectId) {
		try {
			$project = Project::where('id', $projectId)->first();
			if (!$payment) {
				return response()->json([
					'message' => 'Проекта с таким ID не существует'
				], 400);
			}
			return response()->json([
				'project' => $project
			]);
		} catch (\Throwable $th) {
			return response()->json([
				'message' => 'Не удалось получить данные о проекте'
			], 500);
		}
	}

	public function add(Request $request) {
		try {
			$validatedData = $request->validate([
				'name' => ['required', 'string', 'min:4', 'max:20', 'unique:projects'],
				'description' => ['required', 'string', 'min:4', 'max:100'],
        'deadline' => ['required'],
        'payment_type_id' => ['required', 'string'],
        'company_id' => ['required', 'string'],
        'user_id' => ['required', 'string']
			]);

			$project = Project::create([
				'name' => $validatedData['name'],
				'description' => $validatedData['description'],
        'deadline' => $validatedData['deadline'],
        'payment_type_id' => $validatedData['payment_type_id'],
        'company_id' => $validatedData['company_id'],
        'user_id' => $validatedData['user_id'],
			]);
			return response()->json([
				'message' => 'Проект успешно добавлен'
			]);
		} catch (\Throwable $th) {
			return response()->json([
				'message' => 'Не удалось добавить проект'
			], 400);
		}
	}

	public function update(Request $request, $projectId) {
		try {
			$project = PaymentType::where('id', $projectId)->first();
			if (!$project) {
				return response()->json([
					'message' => 'Проекта с таким ID не существует'
				], 400);
			}

			$validatedData = $request->validate([
				'name' => ['required', 'string', 'min:4', 'max:20', Rule::unique('projects')->ignore($project->id)],
				'description' => ['required', 'string', 'min:4', 'max:100'],
        'deadline' => ['required'],
        'payment_type_id' => ['required', 'string'],
        'company_id' => ['required', 'string'],
        'user_id' => ['required', 'string']
			]);

			$project->update($validatedData);
			return response()->json([
				'message' => 'Данные успешно обновлены'
			]);
		} catch (\Throwable $th) {
			return response()->json([
				'message' => 'Не удалось обновить данные проекта'
			], 400);
		}
	}

	public function delete($projectId) {
		try {
			$project = Project::where('id', $projectId)->first();
			if (!$project) {
				return response()->json([
					'message' => 'Проекта с таким ID не существует'
				], 400);
			}
			$project->delete();
			return response()->json([
        'message' => 'Проект успешно удален'
      ]); 
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось удалить проект',
      ], 500);
    }
	}
}
