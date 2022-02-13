<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Collective\Html\FormBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('settings')) {
            View::share('webInfo', DB::table('settings')->first());
        }

        if (Schema::hasTable('product_categories')) {
            View::share('categories', DB::table('product_categories')->orderBy('ordering', 'ASC')->select('*')->get());
        };

        FormBuilder::macro('short_title', function ($title, $length, $after = ' ...') {
            $newTitle = explode(' ', $title, $length);
            if (count($newTitle) >= $length) {
                array_pop($newTitle);
                $newTitle = implode(" ", $newTitle) . $after;
            } else {
                $newTitle = implode(" ", $newTitle);
            }
            return $newTitle;
        });

        // BREADCRUMB
        FormBuilder::macro('breadcrumb', function ($val = '', $arr = []) {

            $xhtml =    '';
            foreach ($arr as $value) {
                $xhtml .= '<li class="breadcrumb-item active" aria-current="page">' . $value . '</a></li>';
            }

            return
                '<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <div class="breadcrumb-title pe-3">' . $val . '</div>
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                ' . $xhtml . '
                            </ol>
                        </nav>
                    </div>
                </div><hr>';
        });

        //ROW_PAGINATION
        FormBuilder::macro('row_pagination', function ($route, $session, $pagination) {
            $form = "'form'";
            $option = '';
            for ($i = env('PAGINATION'); $i <= env('PAGINATION') * env('PAGINATION_ROW'); $i += env('PAGINATION')) {
                $option .= '<option value="' . $i . '" ' . (session($session) == $i ? "selected" : "") . '>' . $i . '</option>';
            }
            return
                '<div class="d-flex align-items-center table-responsive p-1">
                    Xem
                    <form action="' . $route . '" method="GET" class="px-2">
                        <select name="select_row" class="single-select" style="width: 55px"
                            onchange="event.preventDefault(); this.closest(' . $form . ').submit()">
                            ' . $option . '
                        </select>
                    </form>
                    Dòng
                    <div class="ms-auto ps-2">
                        ' . $pagination->onEachSide(1)->withQueryString()->links('vendor.pagination.backend') . '
                    </div>
                </div>';
        });

        FormBuilder::macro('btn_link', function ($route = '', $name = '', $icon = '', $class = '') {
            return
                '<a href="' . $route . '" class="btn btn-sm btn-primary' . $class . '">
                    <i class="' . $icon . '"></i>
                    ' . $name . '
                </a>';
        });

        FormBuilder::macro('btn_submit', function ($name = '', $icon = '', $class = '') {
            return
                '<button type="submit" class="btn btn-sm btn-primary ' . $class . '">
                    <i class="' . $icon . '"></i>
                    ' . $name . '
                </button>';
        });

        FormBuilder::macro('btn_close', function ($route = '', $name = '', $icon = '', $class = '') {
            return
                '<a href="' . $route . '" class="btn btn-sm btn-danger ' . $class . '">
                    <i class="' . $icon . '"></i>
                    ' . $name . '
                </a>';
        });

        FormBuilder::macro('submit_close', function ($route) {
            return
                '<div class="d-flex justify-content-center">
                    ' . FormBuilder::btn_submit('Lưu', '', 'px-4') . '
                    ' . FormBuilder::btn_close($route, 'Đóng', '', 'px-4 ms-4') . '
                </div>';
        });

        FormBuilder::macro('edit_destroy', function ($routeEdit, $routeDestroy) {
            return
                '<div class="d-flex order-actions justify-content-center">
                    <a href="' . $routeEdit . '"
                        class="text-warning" title="Edit">
                        <i class="bx bx-edit-alt" aria-hidden="true"></i>
                    </a>
                    <a href="#" onclick="destroy(' . '\'' . $routeDestroy . '\'' . ')"
                        class="text-danger">
                        <i class="bx bxs-trash" aria-hidden="true"></i>
                    </a>
                </div>';
        });
    }
}
