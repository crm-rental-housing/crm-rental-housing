<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Appartment;
use App\Models\PaymentType;

class AppartmentController extends Controller
{
  public function index() {
    try {
      $appartments = Appartment::orderBy('appartment_number', 'asc')->get(); // или User::all()
      return response()->json([
        'appartments' => $appartments
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось получить список квартир',
      ], 500);
    }
  }

  public function getEntityAppartments($entityId) {
    try {
      $appartments = Appartment::where('project_id', $entityId)->get();
      return response()->json([
        'appartments' => $appartments,
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось получить данные объекта',
      ], 500);
    }
  }

  public function getOne($appartmentId) {
    try {
      $appartment = Appartment::where('id', $appartmentId)->first();
      if (!$appartment) {
        return response()->json([
          'message' => "Квартиры с таким ID не существует"
        ]);
      }
      return response()->json([
        'data' => [
          'appartment' => $appartment
        ]
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось получить данные квартиры',
      ], 500);
    }
  }

  public function add(Request $request, $entityId) {
    try {
      $user = auth()->user();
      $validatedData = $request->validate([
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

      $appartment = Appartment::create([
        'price' => $validatedData['price'],
        'entrance_number' => $validatedData['entrance_number'],
        'floor_number' => $validatedData['floor_number'],
        'appartment_number' => $validatedData['appartment_number'],
        'rooms_number' => $validatedData['rooms_number'],
        'total_area' => $validatedData['total_area'],
        'kitchen_area' => $validatedData['kitchen_area'],
        'repair_type' => $validatedData['repair_type'],
        'type_id' => $validatedData['type_id'],
        'entity_id' => $entityId,
        'user_id' => $user->id,
      ]);
    
      return response()->json([
        'message' => 'Квартира успешно добавлена',
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось добавить квартиру',
      ], 400);
    }
  }

  public function update(Request $request, $entityId, $appartmentId) {
    try {
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

      $validatedData = $request->validate([
        'price' => 'required|integer',
        'entrance_number' => 'required|integer',
        'floor_number' => 'required|integer',
        'appartment_number' => ['required', 'integer', Rule::unique('appartments')->ignore($appartment->id)],
        'rooms_number' => 'required|integer',
        'total_area' => 'required|integer',
        'kitchen_area' => 'required|integer',
        'repair_type' => 'required|string|max:30',
        'type_id' => 'required|integer',
        'entity_id' => $entityId,
        'user_id' => $user->id,
      ]);
      
      $appartment->update($validatedData);
      return response()->json([
        'message' => 'Данные квартиры успешно обновлены'
      ]);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось обновить данные квартиры'
      ], 400);
    }
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
    $validatedData=Validator::make($request->all(), [
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
