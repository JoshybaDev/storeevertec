<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class InstallController extends Controller
{
    /**
     * Install Demo Store
     *
     * @return void
     */
    public function index()
    {
        Artisan::call("migrate:refresh");
        Artisan::call("db:seed");
        Helper::create_user_anonymus();
        return 'Ok';
    }
}
