<?php
namespace App\Validation;

class MyRules
{
    public array $registration = [
        'username' => [
            'label' => 'Username',
            'rules' => 'required|min_length[5]|max_length[12]|is_unique[users.username]',
            'errors' => [
                'is_unique' => 'This {field} already exists.'
            ]
        ],
        'email'    => [
            'label' => 'Email',
            'rules' => 'required|valid_email|is_unique[users.email]'
        ],
        'password' => [
            'label' => 'Password',
            'rules' => 'required|min_length[8]'
        ],
        'pass_confirm' => [
            'label' => 'Password Confirmation',
            'rules' => 'required|matches[password]'
        ],
    ];

    // You can add other rule groups here, e.g., for login, profile updates, etc.
    public array $login = [
         'email'    => [
            'label' => 'Email',
            'rules' => 'required|valid_email'
        ],
        'password' => [
            'label' => 'Password',
            'rules' => 'required|min_length[4]'
        ],
    ];
}
