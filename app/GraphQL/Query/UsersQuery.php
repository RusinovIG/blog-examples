<?php

namespace App\GraphQL\Query;

use App\User;
use Folklore\GraphQL\Support\Query;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'UsersQuery',
        'description' => 'A query'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('User'));
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'email' => ['name' => 'email', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $users = User::query();

        if (isset($args['id'])) {
            $users->where('id' , $args['id']);
        } else if(isset($args['email'])) {
            $users->where('email', $args['email']);
        }

        foreach ($info->getFieldSelection() as $field => $keys) {
            if ($field === 'posts') {
                $users->with('posts');
            }
        }

        return $users->get();
    }
}
