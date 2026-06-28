<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // === Dashboard ===
            ['name' => 'dashboard.view', 'group_name' => 'Dashboard'],

            // === Teams Management ===
            ['name' => 'team.view', 'group_name' => 'Teams Management'],
            ['name' => 'team.create', 'group_name' => 'Teams Management'],
            ['name' => 'team.edit', 'group_name' => 'Teams Management'],
            ['name' => 'team.update', 'group_name' => 'Teams Management'],
            ['name' => 'team.delete', 'group_name' => 'Teams Management'],

            // === Testimonial Management ===
            ['name' => 'testimonial.view', 'group_name' => 'Testimonial Management'],
            ['name' => 'testimonial.create', 'group_name' => 'Testimonial Management'],
            ['name' => 'testimonial.edit', 'group_name' => 'Testimonial Management'],
            ['name' => 'testimonial.update', 'group_name' => 'Testimonial Management'],
            ['name' => 'testimonial.delete', 'group_name' => 'Testimonial Management'],

            // === Blog ===
            ['name' => 'blog.category.view', 'group_name' => 'Blog'],
            ['name' => 'blog.category.create', 'group_name' => 'Blog'],
            ['name' => 'blog.category.edit', 'group_name' => 'Blog'],
            ['name' => 'blog.category.delete', 'group_name' => 'Blog'],
            ['name' => 'blog.post.view', 'group_name' => 'Blog'],
            ['name' => 'blog.post.create', 'group_name' => 'Blog'],
            ['name' => 'blog.post.edit', 'group_name' => 'Blog'],
            ['name' => 'blog.post.delete', 'group_name' => 'Blog'],

            // === Comment Management ===
            ['name' => 'comment.view', 'group_name' => 'Comment Management'],
            ['name' => 'comment.approve', 'group_name' => 'Comment Management'],
            ['name' => 'comment.reply', 'group_name' => 'Comment Management'],
            ['name' => 'comment.delete', 'group_name' => 'Comment Management'],

            // === Book Area Management ===
            ['name' => 'book.area.view', 'group_name' => 'Book Area Management'],
            ['name' => 'book.area.create', 'group_name' => 'Book Area Management'],
            ['name' => 'book.area.edit', 'group_name' => 'Book Area Management'],
            ['name' => 'book.area.update', 'group_name' => 'Book Area Management'],
            ['name' => 'book.area.delete', 'group_name' => 'Book Area Management'],

            // === Hotel Gallery ===
            ['name' => 'gallery.view', 'group_name' => 'Hotel Gallery'],
            ['name' => 'gallery.create', 'group_name' => 'Hotel Gallery'],
            ['name' => 'gallery.edit', 'group_name' => 'Hotel Gallery'],
            ['name' => 'gallery.delete', 'group_name' => 'Hotel Gallery'],

            // === Room Type Management ===
            ['name' => 'room.type.view', 'group_name' => 'Room Type Management'],
            ['name' => 'room.type.create', 'group_name' => 'Room Type Management'],
            ['name' => 'room.type.edit', 'group_name' => 'Room Type Management'],
            ['name' => 'room.type.update', 'group_name' => 'Room Type Management'],
            ['name' => 'room.type.delete', 'group_name' => 'Room Type Management'],

            // === Booking ===
            ['name' => 'booking.view', 'group_name' => 'Booking'],
            ['name' => 'booking.create', 'group_name' => 'Booking'],
            ['name' => 'booking.edit', 'group_name' => 'Booking'],
            ['name' => 'booking.update', 'group_name' => 'Booking'],
            ['name' => 'booking.delete', 'group_name' => 'Booking'],
            ['name' => 'booking.detail', 'group_name' => 'Booking'],

            // === Room List Management ===
            ['name' => 'room.list.view', 'group_name' => 'Room List Management'],
            ['name' => 'room.list.create', 'group_name' => 'Room List Management'],
            ['name' => 'room.list.edit', 'group_name' => 'Room List Management'],
            ['name' => 'room.list.update', 'group_name' => 'Room List Management'],
            ['name' => 'room.list.delete', 'group_name' => 'Room List Management'],

            // === Booking Report ===
            ['name' => 'booking.report.view', 'group_name' => 'Booking Report'],
            ['name' => 'booking.report.export', 'group_name' => 'Booking Report'],
            ['name' => 'booking.report.filter', 'group_name' => 'Booking Report'],

            // === Menu-level permissions (for sidebar visibility) ===
            ['name' => 'team.menu', 'group_name' => 'Teams Management'],
            ['name' => 'testimonial.menu', 'group_name' => 'Testimonial Management'],
            ['name' => 'blog.menu', 'group_name' => 'Blog'],
            ['name' => 'comment.menu', 'group_name' => 'Comment Management'],
            ['name' => 'book.area.menu', 'group_name' => 'Book Area Management'],
            ['name' => 'gallery.menu', 'group_name' => 'Hotel Gallery'],
            ['name' => 'room.type.menu', 'group_name' => 'Room Type Management'],
            ['name' => 'booking.menu', 'group_name' => 'Booking'],
            ['name' => 'room.list.menu', 'group_name' => 'Room List Management'],
            ['name' => 'booking.report.menu', 'group_name' => 'Booking Report'],
            ['name' => 'permission.menu', 'group_name' => 'Role and Permission'],
            ['name' => 'contact.message.menu', 'group_name' => 'Contact'],
            ['name' => 'setting.menu', 'group_name' => 'Setting'],

            // === Add-ons Facility Management ===
            ['name' => 'addon.menu', 'group_name' => 'Add-ons Facility Management'],
            ['name' => 'addon.view', 'group_name' => 'Add-ons Facility Management'],
            ['name' => 'addon.create', 'group_name' => 'Add-ons Facility Management'],
            ['name' => 'addon.edit', 'group_name' => 'Add-ons Facility Management'],
            ['name' => 'addon.update', 'group_name' => 'Add-ons Facility Management'],
            ['name' => 'addon.delete', 'group_name' => 'Add-ons Facility Management'],

            // === Admin Management ===
            ['name' => 'admin.menu', 'group_name' => 'Admin Management'],
            ['name' => 'admin.view', 'group_name' => 'Admin Management'],
            ['name' => 'admin.create', 'group_name' => 'Admin Management'],
            ['name' => 'admin.edit', 'group_name' => 'Admin Management'],
            ['name' => 'admin.update', 'group_name' => 'Admin Management'],
            ['name' => 'admin.delete', 'group_name' => 'Admin Management'],

            // === Role and Permission ===
            ['name' => 'permission.view', 'group_name' => 'Role and Permission'],
            ['name' => 'permission.create', 'group_name' => 'Role and Permission'],
            ['name' => 'permission.edit', 'group_name' => 'Role and Permission'],
            ['name' => 'permission.delete', 'group_name' => 'Role and Permission'],
            ['name' => 'role.view', 'group_name' => 'Role and Permission'],
            ['name' => 'role.create', 'group_name' => 'Role and Permission'],
            ['name' => 'role.edit', 'group_name' => 'Role and Permission'],
            ['name' => 'role.delete', 'group_name' => 'Role and Permission'],
            ['name' => 'role.assign', 'group_name' => 'Role and Permission'],

            // === Contact ===
            ['name' => 'contact.message.view', 'group_name' => 'Contact'],
            ['name' => 'contact.message.detail', 'group_name' => 'Contact'],
            ['name' => 'contact.message.reply', 'group_name' => 'Contact'],
            ['name' => 'contact.message.delete', 'group_name' => 'Contact'],

            // === Setting ===
            ['name' => 'smtp.setting.view', 'group_name' => 'Setting'],
            ['name' => 'smtp.setting.update', 'group_name' => 'Setting'],
            ['name' => 'site.setting.view', 'group_name' => 'Setting'],
            ['name' => 'site.setting.update', 'group_name' => 'Setting'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['group_name' => $permission['group_name']]
            );
        }

        $this->command->info('All permissions seeded successfully!');
    }
}
