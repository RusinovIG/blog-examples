<?php

namespace App\GraphQL\Type;

use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL\Type\Definition\Type;

class UserType extends BaseType
{
    protected $attributes = [
        'name' => 'UserType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the user'
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of user'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of user'
            ]
        ];
    }
}
