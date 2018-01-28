<?php

namespace App\GraphQL\Type;

use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL\Type\Definition\Type;

class PostType extends BaseType
{
    protected $attributes = [
        'name' => 'PostType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int())
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'category_id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'created_at' => [
                'type' => Type::string(),
            ],
            'updated_at' => [
                'type' => Type::string(),
            ]
        ];
    }
}
