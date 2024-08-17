<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Appartment;
use App\Models\Entity;
use App\Models\PaymentType;

class AppartmentController extends Controller
{
  public function index() {
    $appartments = [];
    foreach(Appartment::orderBy('appartment_number', 'asc')->cursor() as $appartment) {
      $appartments[] = [
        'price' => $appartment->price,
        'entrance_number' => $appartment->entrance_number,
        'floor_number' => $appartment->floor_number,
        'appartment_number' => $appartment->appartment_number,
        'rooms_number' => $appartment->rooms_number,
        'total_area' => $appartment->total_area,
        'kitchen_area' => $appartment->kitchen_area,
        'repair_type' => $appartment->repair_type,
        'type_status' => $appartment->type->value,
        'entity' => [
          'id' => $appartment->entity_id,
          'address' => [
            'city' => $appartment->entity->city,
            'street' => $appartment->entity->street,
            'house' => $appartment->entity->house,
          ],
        ],
        'user' => [
          'id' => $appartment->user_id,
          'name' => [
            'first' => $appartment->user->info ? $entity->user->info->first_name : null,
            'last' => $appartment->user->info ? $entity->user->info->last_name : null,
            'role' => $appartment->user->role->name,
          ],
        ],
      ];
    } // или User::all()
    if (empty($appartments)) {
      return response()->json([
        'message' => 'Квартиры не найдены'
      ]);
    }
    return response()->json([
      'appartments' => $appartments
    ]);
  }

  public function getEntityAppartments($entityId) {
    $appartments = [];
    foreach(
      Appartment::where('project_id', $entityId)->orderBy('appartment_number', 'asc')->cursor() as $appartment) {
      $appartments[] = [
        'price' => $appartment->price,
        'entrance_number' => $appartment->entrance_number,
        'floor_number' => $appartment->floor_number,
        'appartment_number' => $appartment->appartment_number,
        'rooms_number' => $appartment->rooms_number,
        'total_area' => $appartment->total_area,
        'kitchen_area' => $appartment->kitchen_area,
        'repair_type' => $appartment->repair_type,
        'type_status' => $appartment->type->value,
        'entity' => [
          'id' => $appartment->entity_id,
          'address' => [
            'city' => $appartment->entity->city,
            'street' => $appartment->entity->street,
            'house' => $appartment->entity->house,
          ],
        ],
        'user' => [
          'id' => $appartment->user_id,
          'name' => [
            'first' => $appartment->user->info ? $entity->user->info->first_name : null,
            'last' => $appartment->user->info ? $entity->user->info->last_name : null,
            'role' => $appartment->user->role->name,
          ],
        ],
      ];
    }
    if (empty($appartments)) {
      return response()->json([
        'message' => 'Квартиры в объекте не найдены'
      ]);
    }
    return response()->json([
      'appartments' => $appartments,
    ]);
  }

  public function getOne($appartmentId) {
    $appartment = Appartment::where('id', $appartmentId)->first();
    if (!$appartment) {
      return response()->json([
        'message' => "Квартиры с таким ID не существует"
      ], 404);
    }
    return response()->json([
      'appartment' => [
        'price' => $appartment->price,
        'entrance_number' => $appartment->entrance_number,
        'floor_number' => $appartment->floor_number,
        'appartment_number' => $appartment->appartment_number,
        'rooms_number' => $appartment->rooms_number,
        'total_area' => $appartment->total_area,
        'kitchen_area' => $appartment->kitchen_area,
        'repair_type' => $appartment->repair_type,
        'type_status' => $appartment->type->value,
        'entity' => [
          'id' => $appartment->entity_id,
          'address' => [
            'city' => $appartment->entity->city,
            'street' => $appartment->entity->street,
            'house' => $appartment->entity->house,
          ],
        ],
        'user' => [
          'id' => $appartment->user_id,
          'name' => [
            'first' => $appartment->user->info ? $entity->user->info->first_name : null,
            'last' => $appartment->user->info ? $entity->user->info->last_name : null,
            'role' => $appartment->user->role->name,
          ],
        ],
      ],
    ]);
  }

  public function add(Request $request, $entityId) {
    if (!Entity::where('id', $entityId)->first()) {
      return response()->json([
        'message' => 'Объекта с таким ID не найдено'
      ], 404);
    }
    $user = auth()->user();
    $validatedData = Validator::make($request->all(), [
      'price' => 'required|integer',
      'entrance_number' => 'required|integer',
      'floor_number' => 'required|integer',
      'appartment_number' => 'required|integer|unique:appartments',
      'rooms_number' => 'required|integer',
      'total_area' => 'required|integer',
      'kitchen_area' => 'required|integer',
      'repair_type' => 'required|string|max:30',
      'type_id' => 'required|integer',
    ]);

    if ($validatedData->fails()) {
      return response()->json([
        'message' => 'Некорректный ввод'
      ], 400);
    }

    $appartment = Appartment::create([
      'price' => $request['price'],
      'entrance_number' => $request['entrance_number'],
      'floor_number' => $request['floor_number'],
      'appartment_number' => $request['appartment_number'],
      'rooms_number' => $request['rooms_number'],
      'total_area' => $request['total_area'],
      'kitchen_area' => $request['kitchen_area'],
      'repair_type' => $request['repair_type'],
      'type_id' => $request['type_id'],
      'entity_id' => $entityId,
      'user_id' => $user->id,
    ]);
    
    return response()->json([
      'message' => 'Квартира успешно добавлена',
    ]);
  }

  public function update(Request $request, $entityId, $appartmentId) {
    if (!Entity::where('id', $entityId)->first()) {
      return response()->json([
        'message' => 'Объекта с таким ID не найден'
      ], 404);
    }
    $appartment = Appartment::where('id', $appartmentId)->first();
    if (!$appartment) {
      return response()->json([
        'message' => "Квартиры с таким ID не существует"
      ], 404);
    }
    // Дополнить или переделать
		if (auth()->user()->id !== $appartment->user_id || auth()->user()->role->value !== 'ADMIN') {
			return response()->json([
				'message' => 'У вас нет прав на обновление данных квартиры'
			], 400);
		}

    $validatedData = Validator::make($request->all(), [
      'price' => 'required|integer',
      'entrance_number' => 'required|integer',
      'floor_number' => 'required|integer',
      'appartment_number' => ['required', 'integer', Rule::unique('appartments')->ignore($appartment->id)],
      'rooms_number' => 'required|integer',
      'total_area' => 'required|integer',
      'kitchen_area' => 'required|integer',
      'repair_type' => 'required|string|max:30',
      'type_id' => 'required|integer',
    ]);

    if ($validatedData->fails()) {
      return response()->json([
        'message' => 'Некорректный ввод'
      ], 400);
    }
      
    $newAppartmentData = [
      'price' => $request['price'],
      'entrance_number' => $request['entrance_number'],
      'floor_number' => $request['floor_number'],
      'appartment_number' => $request['appartment_number'],
      'rooms_number' => $request['rooms_number'],
      'total_area' => $request['total_area'],
      'kitchen_area' => $request['kitchen_area'],
      'repair_type' => $request['repair_type'],
      'type_id' => $request['type_id'],
      'entity_id' => $entityId,
      'user_id' => $user->id,
    ];
    $appartment->update($newAppartmentData);
    return response()->json([
      'message' => 'Данные квартиры успешно обновлены'
    ]);
  }

  public function delete($appartmentId) {
    try {
      $appartment = Appartment::where('id', $appartmentId)->first();
      if (!$appartment) {
        return response()->json([
          'message' => "Квартиры с таким ID  не существует"
        ], 404);
      }
      // Дополнить или переделать
			if (auth()->user()->id !== $appartment->user_id || auth()->user()->role->value !== 'ADMIN') {
				return response()->json([
					'message' => 'У вас нет прав на удаление квартиры'
				], 400);
			}
      $appartment->delete();
      return response()->json([
        'message' => 'Квартира успешно удалена'
      ]); 
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось удалить квартиру',
      ], 500);
    }
  }

  public function addAppartmentsWithUrl(Request $request, $entity_id) {
    $validatedData=Validator::make($request->only(['link']), [
      'link' => ['required', 'string'],
    ]);

    if ($validatedData->fails()) {
      return response()->json([
        'message' => 'Ссылка не должна быть пустой'
      ], 400);
    }
    $parsedUrl = parse_url($request['link']);

    parse_str($parsedUrl['query'], $queryParams);

    $gid = $queryParams['gid'];

    $path = explode('/', $parsedUrl['path']);
    $id = $path[3];

    // Получаем CSV данные
    $csv = file_get_contents("https://docs.google.com/spreadsheets/d/".$id."/export?format=csv&gid=".$gid);
    $csv = explode("\r\n", $csv);

    // Преобразуем CSV данные в массив
    $array = array_map('str_getcsv', $csv);

    $keys = $array[0];

    $appartmentsList = [];

    for ($i = 1; $i < count($array); $i++) {
      $appartments = [];
      for ($j = 0; $j < count($keys); $j++) {
          if (isset($array[$i][$j])) {
              $appartments[$keys[$j]] = $array[$i][$j];
          } else {
              $appartments[$keys[$j]] = null;
          }
      }
      $appartmentsList[] = $appartments;
    }

    foreach ($appartmentsList as $appartment) {
      $type_id=AppartmentType::where('value',$appartment['type'])->id;
      $appartment_candidate = Appartment::where('appartment_number', $appartment['appartment_number'])->first();
      if (!$type_id) {
        continue;
      }
      if ($appartment_candidate) {
        continue;
      }

      try {
        $newAppartment = Appartment::create([
          'price' => $appartment['price'],
          'entrance_number' => $appartment['entrance_number'],
          'floor_number' => $appartment['floor_number'],
          'appartment_number' => $appartment['appartment_number'],
          'rooms_number' => $appartment['rooms_number'],
          'total_area' => $appartment['total_area'],
          'kitchen_area' => $appartment['kitchen_area'],
          'repair_type' => $appartment['repair_type'],
          'type_id' => $type_id,
          'entity_id' =>  $entity_id,
          'user_id' => auth()->user()->id,
          ]);
      } catch (\Throwable $th) {
        return response()->json([
          'message' => 'Произошла ошибка при добавлении некоторых квартир'
        ], 400);
      }
    }

    return response()->json([
      'message' => 'Квартиры были успешно добавлены',
    ]); 
  }
}
