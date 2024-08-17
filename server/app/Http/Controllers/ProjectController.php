<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Project;

class ProjectController extends Controller
{
  public function index() {
		$projects = [];
		foreach (Project::orderBy('name', 'asc')->cursor() as $project) {
			$projects[] = [
				'id' => $project->id,
				'name' => $project->name,
				'description' => $project->description,
				'deadline' => $project->deadline,
				'payment_type' => $project->paymentType->name,
				'company' => [
					'id' => $project->company->id,
					'name' => $project->company->name,
				],
				'user' => [
					'id' => $project->user_id,
					'name' => [
						'first' => $project->user->info ? $project->user->info->first_name : null,
						'last' => $project->user->info ? $project->user->info->last_name : null,
						'role' => $project->user->role->name,
					],
				],
			];
		};
		if (empty($projects)) {
			return response()->json([
				'message' => 'Проекты не найдены'
			]);
		}
		return response()->json([
			'projects' => $projects
		]);
  }

	public function getOne($projectId) {
		$project = Project::where('id', $projectId)->first();
		if (!$project) {
			return response()->json([
				'message' => 'Проекта с таким ID не существует'
			], 400);
		}
		return response()->json([
			'project' => [
				'id' => $project->id,
				'name' => $project->name,
				'description' => $project->description,
				'deadline' => $project->deadline,
				'payment_type' => $project->payment_type->value,
				'company' => [
					'id' => $project->company_id,
					'name' => $project->company->name,
				],
				'user' => [
					'id' => $project->user_id,
					'name' => [
						'first' => $project->user->info ? $project->user->info->first_name : null,
						'last' => $project->user->info ? $project->user->info->last_name : null,
						'role' => $project->user->role->name,
					],
				],
			]
		]);

	}

	public function add(Request $request) {
		$user = auth()->user();
		$validatedData = Validator::make(
			$request->only(
			['name', 'description', 'deadline', 'payment_type_id']
		), [
			'name' => ['required', 'string', 'min:4', 'max:20', 'unique:projects'],
			'description' => ['required', 'string', 'min:4', 'max:100'],
      'deadline' => ['required'],
      'payment_type_id' => ['required', 'string'],
		]);
		if ($validatedData->fails()) {
			return response()->json([
				'message' => 'Некорректный ввод'
			], 400);
		}

		$project = Project::create([
			'name' => $request['name'],
			'description' => $request['description'],
      'deadline' => $request['deadline'],
      'payment_type_id' => $request['payment_type_id'],
      'company_id' => $user['company_id'],
      'user_id' => $user['id'],
		]);
		return response()->json([
			'message' => 'Проект успешно добавлен'
		]);
	}

	public function update(Request $request, $projectId) {
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

		$validatedData = Validator::make($request->only(
			['name', 'description', 'deadline', 'payment_type_id']
		), [
			'name' => ['required', 'string', 'min:4', 'max:20', Rule::unique('projects')->ignore($project->id)],
			'description' => ['required', 'string', 'min:4', 'max:100'],
      'deadline' => ['required'],
      'payment_type_id' => ['required', 'string'],
		]);
		if ($validatedData->fails()) {
			return response()->json([
				'message' => 'Некорректный ввод'
			], 400);
		}

		$newProjectData = [
			'name' => $request['name'],
			'description' => $request['description'],
			'deadline' => $request['deadline'],
			'payment_type_id' => $request['payment_type_id'],
			'company_id' => $user->company_id,
			'user_id' => $user->id,
		];
		$project->update($newProjectData);
		return response()->json([
			'message' => 'Данные успешно обновлены'
		]);
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
