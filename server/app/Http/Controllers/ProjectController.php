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
			$user = auth()->user();
			$validatedData = $request->validate([
				'name' => ['required', 'string', 'min:4', 'max:20', 'unique:projects'],
				'description' => ['required', 'string', 'min:4', 'max:100'],
        'deadline' => ['required'],
        'payment_type_id' => ['required', 'string'],
			]);

			$project = Project::create([
				'name' => $validatedData['name'],
				'description' => $validatedData['description'],
        'deadline' => $validatedData['deadline'],
        'payment_type_id' => $validatedData['payment_type_id'],
        'company_id' => $user['company_id'],
        'user_id' => $user['id'],
			]);
			return response()->json([
				'message' => 'Проект успешно добавлен'
			]);
		} catch (\Throwable $th) {
			echo $th;
			return response()->json([
				'message' => 'Не удалось добавить проект'
			], 400);
		}
	}

	public function update(Request $request, $projectId) {
		try {
			$project = Project::where('id', $projectId)->first();
			if (!$project) {
				return response()->json([
					'message' => 'Проекта с таким ID не существует'
				], 404);
			}
			// Дополнить или переделать
			if (auth()->user()->id !== $project->user_id || auth()->user()->role->value !== 'ADMIN') {
				return response()->json([
					'message' => 'У вас нет прав на обновление данных проекта'
				], 400);
			}

			$validatedData = $request->validate([
				'name' => ['required', 'string', 'min:4', 'max:20', Rule::unique('projects')->ignore($project->id)],
				'description' => ['required', 'string', 'min:4', 'max:100'],
        'deadline' => ['required'],
        'payment_type_id' => ['required', 'string'],
        'company_id' => $project['company_id'],
        'user_id' => $project['user_id'],
			]);

			$project->update($validatedData);
			return response()->json([
				'message' => 'Данные успешно обновлены'
			]);
		} catch (\Throwable $th) {
			echo $th;
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
				], 404);
			}
			// Дополнить или переделать
			if (auth()->user()->id !== $project->user_id || auth()->user()->role->value !== 'ADMIN') {
				return response()->json([
					'message' => 'У вас нет прав на удаление проекта'
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
