<?php
/**
 * File name: RestaurantController.php
 * Last modified: 2020.04.30 at 08:21:08
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\String\length;

class RestaurantController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $user = Auth::user();
        return view("restaurants.index")->with('id', $user->id)->with('role', $user->role);
    }

    public function edit($id) {
        $user = Auth::user();
        return view('restaurants.edit')->with('id', $id)->with('role', $user->role);
    }

    public function view($id) {
        return view('restaurants.view')->with('id', $id);
    }

    public function payout($id) {
        return view('restaurants.payout')->with('id', $id);
    }

    public function foods($id) {
        return view('restaurants.foods')->with('id', $id);
    }

    public function orders($id) {
        return view('restaurants.orders')->with('id', $id);
    }

    public function reviews($id) {
        return view('restaurants.reviews')->with('id', $id);
    }

    public function promos($id) {
        return view('restaurants.promos')->with('id', $id);
    }

    public function create() {
        $user = Auth::user();
        $area_admins = User::all()->where('role', trans('lang.role_area'));
        return view('restaurants.create', compact('area_admins'))->with('role', $user->role)->with('id', $user->id);
    }
}
