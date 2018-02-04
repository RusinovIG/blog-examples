<?php

namespace App\GraphQL\Type;

use App\GraphQL\Field\DateTimeField;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL\Type\Definition\Type;

class PostType extends BaseType
{
    protected $attributes = [
        'name' => 'PostType',
        'description' => 'A blog posts type'
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
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'created_at' => DateTimeField::class,
            'updated_at' => DateTimeField::class,
        ];
    }
}
