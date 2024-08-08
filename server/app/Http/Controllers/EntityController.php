<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Entity;

class EntityController extends Controller
{
  public function index() {
    $entities = [];
    foreach (Entity::orderBy('city', 'asc')->cursor() as $entity) {
      $entities[] = [
        'city' => $entity->city,
        'street' => $entity->street,
        'house' => $entity->house,
        'project' => [
          'id' => $entity->project_id,
          'name' => $entity->project->name,
          'deadline' => $entity->project->deadline,
          ],
        'floors_number' => $entity->floors_number,
        'entrances_number' => $entity->entrances_number,
        'user' => [
          'id' => $entity->user_id,
          'name' => [
            'first' => $entity->user->info ? $entity->user->info->first_name : null,
            'last' => $entity->user->info ? $entity->user->info->last_name : null,
            'role' => $entity->user->role->name,
          ],
        ]
      ];
    }; // или User::all()
    if (empty($entities)) {
      return response()->json([
        'message' => 'Объекты не найдены'
      ]);
    }
    return response()->json([
      'entities' => $entities
    ]);
  }

  public function getProjectEntities($projectId) {
    $entities = Entity::where('project_id', $projectId)->get();
    if (empty($entities)) {
      return response()->json([
        'message' => 'Объектов в проекте не найдены'
      ]);
    }
    return response()->json([
      'entities' => [
        'city' => $entity->city,
        'street' => $entity->street,
        'house' => $entity->house,
        'project' => [
          'id' => $entity->project_id,
          'name' => $entity->project->name,
          'deadline' => $entity->project->deadline,
          ],
        'floors_number' => $entity->floors_number,
        'entrances_number' => $entity->entrances_number,
        'user' => [
          'id' => $entity->user_id,
          'name' => [
            'first' => $entity->user->info ? $entity->user->info->first_name : null,
            'last' => $entity->user->info ? $entity->user->info->last_name : null,
            'role' => $entity->user->role->name,
          ],
        ]
      ]
    ]);
  }

  public function getOne($entityId) {
    $entity = Entity::where('id', $entityId)->first();
    if (!$entity) {
      return response()->json([
        'message' => "Объекта с таким ID не существует"
      ], 404);
    }
    return response()->json([
      'entity' => [
        'city' => $entity->city,
        'street' => $entity->street,
        'house' => $entity->house,
        'project' => [
          'id' => $entity->project_id,
          'name' => $entity->project->name,
          'deadline' => $entity->project->deadline,
          ],
        'floors_number' => $entity->floors_number,
        'entrances_number' => $entity->entrances_number,
        'user' => [
          'id' => $entity->user_id,
          'name' => [
            'first' => $entity->user->info ? $entity->user->info->first_name : null,
            'last' => $entity->user->info ? $entity->user->info->last_name : null,
            'role' => $entity->user->role->name,
          ],
        ],
      ],
    ]);
  }

  public function add(Request $request, $projectId) {
    $user = auth()->user();
    $validatedData = Validator::make($request->only(
      ['city', 'street', 'house', 'floors_number', 'entrances_number']
    ), [
      'city' => 'required|string|max:30',
      'street' => 'required|string|max:30',
      'house' => 'required|string|max:5',
      'floors_number' => 'required|integer|max:50',
      'entrances_number' => 'required|integer|max:50',
    ]);

    if ($validatedData->fails()) {
      return response()->json([
        'message' => 'Некорректный ввод'
      ], 400);
    }
    $entity = Entity::create([
      'city' => $request['city'],
      'street' => $request['street'],
      'house' => $request['house'],
      'floors_number' => $request['floors_number'],
      'entrances_number' => $request['entrances_number'],
      'project_id' => $projectId,
      'user_id' => $user->id,
    ]);
    
    return response()->json([
      'message' => 'Объект успешно добавлен',
    ]);
  }

  public function update(Request $request, $projectId, $entityId) {
    $user = auth()->user();
    $entity = Entity::where('id', $entityId)->first();
    if (!$entity) {
      return response()->json([
        'message' => "Объекта с таким ID не существует"
      ], 404);
    }
    // Дополнить или переделать
		if (auth()->user()->id !== $entity->user_id || auth()->user()->role->value !== 'ADMIN') {
			return response()->json([
				'message' => 'У вас нет прав на обновление данных объекта'
			], 400);
		}

    $validatedData = Validator::make($request->only(
      ['city', 'street', 'house', 'floors_number', 'entrances_number']
    ), [
      'city' => 'required|string|max:30',
      'street' => 'required|string|min:30',
      'house' => 'required|string|max:5',
      'floors_number' => 'required|integer|max:50',
      'entrances_number' => 'required|integer|max:50',
    ]);
    if ($validatedData->fails()) {
      return response()->json([
        'message' => 'Некорректный ввод'
      ], 400);
    }
    $newEntityData = [
      'city' => $request['city'],
      'street' => $request['street'],
      'house' => $request['house'],
      'floors_number' => $request['floors_number'],
      'entrances_number' => $request['entrances_number'],
      'project_id' => $projectId,
      'user_id' => $user->id,
    ];
    $entity->update($newEntityData);
    return response()->json([
      'message' => 'Данные объекта успешно обновлены'
    ]);
  }

  public function delete($entityId) {
    try {
      $entity = Entity::where('id', $entityId)->first();
      if (!$entity) {
        return response()->json([
          'message' => "Объекта с таким ID  не существует"
        ], 404);
      }
      // Дополнить или переделать
			if (auth()->user()->id !== $entity->user_id || auth()->user()->role->value !== 'ADMIN') {
				return response()->json([
					'message' => 'У вас нет прав на удаление объекта'
				], 400);
			}
      $entity->delete();
      return response()->json([
        'message' => 'Объект успешно удален'
      ]); 
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось удалить объект',
      ], 500);
    }
  }
}
