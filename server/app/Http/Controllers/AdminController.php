<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use App\Models\Project;
use App\Models\Entitie;
use App\Models\Appartment;
use App\Models\Deal;

class AdminController extends Controller
{
  public function getManagers() {
    $role = Role::where('value', 'MANAGER')->first();
    $managers = [];
    foreach(User::where('role_id', $role->id)->orderBy('email', 'asc')->cursor() as $user) {
      $managers[] = [
        'id' => $user->id,
        'email' => $user->email,
        'role' => $user->role->value,
        'company' => $user->company ? $user->company->name : null,
        'info' => $user->info ? [
          'username' => $user->info->username,
          'first_name' => $user->info->first_name,
          'middle_name' => $user->info->middle_name,
          'last_name' => $user->info->last_name,
          'gender' => $user->info->gender,
          'birtdate' => $user->info->birthdate,
          'phone_number' => $user->info->phone_number,
        ] : null,
        'ban' => $user->ban ? [
          'is_banned' => $user->ban->is_banned,
          'banned_at' => $user->ban->banned_at,
        ] : null,
      ];
    }
    if (empty($managers)) {
      return response()->json([
        'message' => 'Нет менеджеров'
      ]);
    }

    return response()->json([
      'managers' => $managers,
    ]);
  }

  public function getLastDeals() {
    $deals = [];
    foreach(Deal::orderBy('created_at', 'desc')->take(3)->cursor() as $deal) {
      $deals[] =[
        'client' => [
          'first' => $deal->cilent->info ? $deal->info->first_name : null,
          'last' => $deal->cilent->info ? $deal->info->last_name : null,
          'email' => $deal->client->email,
        ],
        'employee' => [
          'first' => $deal->employee->info ? $deal->info->first_name : null,
          'last' => $deal->employee->info ? $deal->info->last_name : null,
          'email' => $deal->employee->email,
        ],
        'company' => $deal->company->name,
        'appartment' => [
          'address' => [
            'city' => $deal->appartment->entity->city,
            'street' => $deal->appartment->entity->street,
            'house' => $deal->appartment->entity->house,
          ],
          'floor' => $deal->appartment->floor_number,
          'entrance' => $deal->appartment->entrance_number,
          'number' => $deal->appartment->appartment_number,
        ],
        'payment_type' => $deal->payment_type->value,
      ];
    }

    if (empty($deals)) {
      return response()->json([
        'message' => 'Сделок нет'
      ]);
    }

    return response()->json([
      'deals' => $deals,
    ]);
  }

  public function getCompanies() {
    $companies = [];
    foreach (Company::orderBy('name', 'asc')->cursor() as $company) {
      $companies[] = [
        'id' => $company->id,
        'name' => $company->name,
      ];
    }

    if (empty($companies)) {
      return response()->json([
        'message' => 'Компаний нет'
      ]);
    }

    return response()->json([
      'companies' => $companies,
    ]);
  }
}
