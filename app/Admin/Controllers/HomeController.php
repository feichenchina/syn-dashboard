<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        if (Admin::guard()->user() instanceof Teacher) {
            return redirect()->intended("admin/students");
        }
        if (Admin::guard()->user() instanceof Administrator) {
            return redirect()->intended("admin/teachers");
        }
        return $content
            ->title('Dashboard')
            ->description('走错路了...，请返回');
        //     ->row(Dashboard::title())
        //     ->row(function (Row $row) {

        //         $row->column(4, function (Column $column) {
        //             $column->append(Dashboard::environment());
        //         });

        //         $row->column(4, function (Column $column) {
        //             $column->append(Dashboard::extensions());
        //         });

        //         $row->column(4, function (Column $column) {
        //             $column->append(Dashboard::dependencies());
        //         });
        //     });
    }
}
