<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Company;

class CompanyController extends Controller
{
  public function index() {
    $companies = []; 
		foreach (Company::orderBy('name', 'asc')->cursor() as $company) {
			$companies[] = [
				'id' => $company->id,
				'name' => $company->name,
				'description' => $company->description,
				'email' => $company->email,
				'phone_number' => $company->phone_number,
			];
		}
		if (empty($companies)) {
			return response()->json([
				'message' => 'Компании-застройщики не найдены'
			]);
		}
    return response()->json([
      'companies' => $companies
    ]);
  }

	public function getOne($companyId) {
		$company = Company::where('id', $companyId)->first();
		if (!$company) {
			return response()->json([
				'message' => 'Компаниии с таким ID не существует'
			], 404);
		}
		return response()->json([
			'company' => [
				'id' => $company->id,
				'name' => $company->name,
				'description' => $company->description,
				'email' => $company->email,
				'phone_number' => $company->phone_number,
			],
		]);
	}

	public function add(Request $request) {
		$validatedData = Validator::make(
			$request->only(
				['name', 'description', 'email', 'phone_number']
			), [
			'name' => 'required|string|min:4|max:30|unique:companies',
			'description' => 'required|string|min:8|max:100',
			'email' => 'required|string|email|unique:companies',
			'phone_number' => 'required|string|min:6|max:12|unique:companies'
		]);
		if ($validatedData->fails()) {
			return response()->json([
				'message' => 'Некорректный ввод'
			], 400);
		}
		$company = Company::create([
			'name' => $request['name'],
			'description' => $request['description'],
			'email' => $request['email'],
			'phone_number' => $request['phone_number'],
		]);
		return response()->json([
			'message' => 'Компания успешно добавлена'
		]);
	}

	public function update(Request $request, $companyId) {
		$company = Company::where('id', $companyId)->first();
		if (!$company) {
			return response()->json([
				'message' => 'Компаниии с таким ID не существует'
			], 404);
		}
		// Дополнить или переделать
		if (auth()->user()->company->id !== $companyId || auth()->user()->role->value !== 'ADMIN') {
			return response()->json([
				'message' => 'У вас нет прав на обновление данных компании'
			], 400);
		}
		$validatedData = Validator::make($request->only(
			['name', 'description', 'email', 'phone_number']
		), [
			'name' => ['required', 'string', 'min:4', 'max:30', Rule::unique('companies')->ignore($company->id)],
			'description' => ['required', 'string', 'min:10', 'max:100'],
			'email' => ['required', 'string', 'email', Rule::unique('companies')->ignore($company->id)],
			'phone_number' => ['required', 'string', 'min:6', 'max:12', Rule::unique('companies')->ignore($company->id)],
		]);
		if ($validatedData->fails()) {
			return response()->json([
				'message' => 'Некорректный ввод'
			], 400);
		}
		$companyData = [
			'name' => $request['name'],
			'description' => $request['description'],
			'email' => $request['email'],
			'phone_number' => $request['phone_number'],
		];

		$company->update($companyData);
		return response()->json([
			'message' => 'Данные успешно обновлены'
		]);
	}

	public function delete($companyId) {
		try {
			$company = Company::where('id', $companyId)->first();
			if (!$company) {
				return response()->json([
					'message' => 'Компаниии с таким ID не существует'
				], 404);
			}
			// Дополнить или переделать
			if (auth()->user()->company->id !== $companyId || auth()->user()->role->value !== 'ADMIN') {
				return response()->json([
					'message' => 'У вас нет прав на удаление компании'
				], 400);
			}
			$company->delete();
			return response()->json([
        'message' => 'Компания успешно удалена'
      ]); 
    } catch (\Throwable $th) {
      return response()->json([
        'message' => 'Не удалось удалить компанию',
      ], 500);
    }
	}
}
