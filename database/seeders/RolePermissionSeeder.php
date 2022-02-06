<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Manager', 'slug' => 'manager'],
            ['name' => 'Writter', 'slug' => 'writter'],
        ]);

        DB::table('permissions')->insert([
            ['name' => 'User View', 'slug' => 'user-view', 'description' => 'Xem thành viên'],
            ['name' => 'User Store', 'slug' => 'user-store', 'description' => 'Tạo thành viên'],
            ['name' => 'User Update', 'slug' => 'user-update', 'description' => 'Sửa thành viên'],
            ['name' => 'User Destroy', 'slug' => 'user-destroy', 'description' => 'Xóa thành viên'],

            ['name' => 'Role View', 'slug' => 'role-view', 'description' => 'Xem vai trò'],
            ['name' => 'Role Store', 'slug' => 'role-store', 'description' => 'Tạo vai trò'],
            ['name' => 'Role Update', 'slug' => 'role-update', 'description' => 'Sửa vai trò'],
            ['name' => 'Role Destroy', 'slug' => 'role-destroy', 'description' => 'Xóa vai trò'],

            ['name' => 'Post Category View', 'slug' => 'post-caterogy-view', 'description' => 'Xem danh mục bài viết'],
            ['name' => 'Post Category Store', 'slug' => 'post-caterogy-store', 'description' => 'Tạo danh mục bài viết'],
            ['name' => 'Post Category Update', 'slug' => 'post-caterogy-update', 'description' => 'Sửa danh mục bài viết'],
            ['name' => 'Post Category Destroy', 'slug' => 'post-caterogy-destroy', 'description' => 'Xóa danh mục bài viết'],

            ['name' => 'Post List View', 'slug' => 'post-list-view', 'description' => 'Xem danh sách bài viết'],
            ['name' => 'Post List Store', 'slug' => 'post-list-store', 'description' => 'Tạo danh sách bài viết'],
            ['name' => 'Post List Update', 'slug' => 'post-list-update', 'description' => 'Sửa danh sách bài viết'],
            ['name' => 'Post List Destroy', 'slug' => 'post-list-destroy', 'description' => 'Xóa danh sách bài viết'],

            ['name' => 'Product Category View', 'slug' => 'product-category-view', 'description' => 'Xem danh mục sản phẩm'],
            ['name' => 'Product Category Store', 'slug' => 'product-category-store', 'description' => 'Tạo danh mục sản phẩm'],
            ['name' => 'Product Category Update', 'slug' => 'product-category-update', 'description' => 'Sửa danh mục sản phẩm'],
            ['name' => 'Product Category Destroy', 'slug' => 'product-category-destroy', 'description' => 'Xóa danh mục sản phẩm'],

            ['name' => 'Product List View', 'slug' => 'product-list-view', 'description' => 'Xem danh sách sản phẩm'],
            ['name' => 'Product List Store', 'slug' => 'product-list-store', 'description' => 'Tạo danh sách sản phẩm'],
            ['name' => 'Product List Update', 'slug' => 'product-list-update', 'description' => 'Sửa danh sách sản phẩm'],
            ['name' => 'Product List Destroy', 'slug' => 'product-list-destroy', 'description' => 'Xóa danh sách sản phẩm'],

            ['name' => 'Product Image View', 'slug' => 'product-image-view', 'description' => 'Xem hình sản phẩm'],
            ['name' => 'Product Image Store', 'slug' => 'product-image-store', 'description' => 'Tạo hình sản phẩm'],
            ['name' => 'Product Image Update', 'slug' => 'product-image-update', 'description' => 'Sửa hình sản phẩm'],
            ['name' => 'Product Image Destroy', 'slug' => 'product-image-destroy', 'description' => 'Xóa hình sản phẩm'],

            ['name' => 'Coupon View', 'slug' => 'coupon-view', 'description' => 'Xem mã giảm giá'],
            ['name' => 'Coupon Store', 'slug' => 'coupon-store', 'description' => 'Tạo mã giảm giá'],
            ['name' => 'Coupon Update', 'slug' => 'coupon-update', 'description' => 'Sửa mã giảm giá'],
            ['name' => 'Coupon Destroy', 'slug' => 'coupon-destroy', 'description' => 'Xóa mã giảm giá'],

            ['name' => 'Order View', 'slug' => 'order-view', 'description' => 'Xem đơn hàng'],
            ['name' => 'Order Invoice', 'slug' => 'order-invoice', 'description' => 'Xem hóa đơn'],
            ['name' => 'Order Destroy', 'slug' => 'order-destroy', 'description' => 'Xóa đơn hàng'],
            ['name' => 'Order Change Status', 'slug' => 'order-change-status', 'description' => 'Cập nhật trạng thái đơn hàng'],

            ['name' => 'Setting View', 'slug' => 'setting-view', 'description' => 'Xem cài đặt'],
            ['name' => 'Setting Update', 'slug' => 'setting-update', 'description' => 'Sửa cài đặt'],
        ]);

        $role = Role::where('slug', 'admin')->first();
        for ($i = 1; $i <= 38; $i++) {
            $role->permissions()->attach($i);
        }

        $user = Admin::create([
            'username'  => 'admin',
            'name'      => 'ADMIN',
            'password'  => Hash::make('123123'),
            'status'    => 1,
        ]);
        $user->roles()->attach($role);
    }
}
