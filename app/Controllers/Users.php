<?php

namespace App\Controllers;

class Users extends BaseController
{
    public function index()
    {
        $users = [
            [
                'username'  => 'admin01',
                'full_name' => 'Stephanie Griarte',
                'role'      => 'Administrator',
            ],
            [
                'username'  => 'manager01',
                'full_name' => 'Daniel Ramos',
                'role'      => 'Manager',
            ],
            [
                'username'  => 'cashier01',
                'full_name' => 'Anna Lopez',
                'role'      => 'Cashier',
            ],
            [
                'username'  => 'cashier02',
                'full_name' => 'Mark Villanueva',
                'role'      => 'Cashier',
            ],
            [
                'username'  => 'staff01',
                'full_name' => 'Julia Fernandez',
                'role'      => 'Staff',
            ],
        ];

        return view('users/index', [
            'users' => $users,
        ]);
    }
}