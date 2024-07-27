<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entity;

class EntityController extends Controller
{
  public function index() {
    try {
      $entities = Entity::all(); // или User::all()
      return response()->json([
        'entities' => $entities
      ]);
    } catch (\Throwable $th) {
      echo $th;
      return response()->json([
        'message' => 'Не удалось получить список объектов',
      ], 500);
    }
  }

  public function getProjectEntities($projectId) {
    try {
      $entities = Entity::where('project_id', $projectId)->get();
      return response()->json([
        'entities' => $entities,
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось получить данные объекта',
      ], 500);
    }
  }

  public function getOne($entityId) {
    try {
      $entity = Entity::where('id', $entityId)->first();
      if (!$entity) {
        return response()->json([
          'message' => "Объекта с таким ID не существует"
        ]);
      }
      return response()->json([
        'data' => [
          'entity' => $entity
        ]
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось получить данные объекта',
      ], 500);
    }
  }

  public function add(Request $request, $projectId) {
    try {
      $user = auth()->user();
      $validatedData = $request->validate([
        'city' => 'required|string|max:30',
        'street' => 'required|string|max:30',
        'house' => 'required|string|max:5',
        'floors_number' => 'required|integer|max:50',
        'entrances_number' => 'required|integer|max:50',
      ]);

      $entity = Entity::create([
        'city' => $validatedData['city'],
        'street' => $validatedData['street'],
        'house' => $validatedData['house'],
        'floors_number' => $validatedData['floors_number'],
        'entrances_number' => $validatedData['entrances_number'],
        'project_id' => $projectId,
        'user_id' => $user->id,
      ]);
    
      return response()->json([
        'message' => 'Объект успешно добавлен',
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось добавить объект',
      ], 400);
    }
  }

  public function update(Request $request, $projectId, $entityId) {
    try {
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

      $validatedData = $request->validate([
        'city' => 'required|string|max:30',
        'street' => 'required|string|min:30',
        'house' => 'required|string|max:5',
        'floors_number' => 'required|integer|max:50',
        'entrances_number' => 'required|integer|max:50',
        'project_id' => $projectId,
        'user_id' => $user->id,
      ]);
      
      $entity->update($validatedData);
      return response()->json([
        'message' => 'Данные объекта успешно обновлены'
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось обновить данные объекта'
      ], 400);
    }
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
			if (auth()->user()->company->id !== $entity->project->company->id || auth()->user()->role->value !== 'ADMIN') {
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
