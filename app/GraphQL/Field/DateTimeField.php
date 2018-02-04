<?php
namespace App\GraphQL\Field;

use Folklore\GraphQL\Support\Field;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class DateTimeField extends Field
{
    protected $attributes = [
        'description' => 'String representation for Carbon date/time object'
    ];

    public function type()
    {
        return Type::string();
    }

    public function args()
    {
        return [
            'format' => [
                'type' => Type::string(),
                'description' => 'Formatting date based on DateTime::format() specs'
            ]
        ];
    }

    protected function resolve($root, $args, $context, ResolveInfo $info)
    {
        $field = $root->{$info->fieldName};
        return isset($args['format'])
            ? $field->format($args['format'])
            : $field->toDateTimeString();
    }
}