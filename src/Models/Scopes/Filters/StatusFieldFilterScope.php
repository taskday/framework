<?php

namespace Taskday\Models\Scopes\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Taskday\Base\Operator;
use Taskday\Base\Filter;
use Taskday\Models\Field;

class StatusFieldFilterScope extends Filter
{
    /** @inheritdoc */
    public function operators(): array
    {
        return [
            Operator::IS_EQUAL->value => function (Builder $query, string $value, string $handle) {
                $query->whereHas('fields', function ($q) use ($handle, $value) {
                    $q->where('handle', $handle)->where('value', $value);
                });
            },
            Operator::IS_NOT_EQUAL->value => function (Builder $query, string $value, string $handle) {
                $query->whereHas('fields', function ($q) use ($handle, $value) {
                    $q->where('handle', $handle)->where('value', '<>', $value);
                });
            }
        ];
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $fields = Field::select('handle')->where('type', 'status')->pluck('handle');

        foreach ($fields as $handle) {
            if (request()->has("filters.$handle")) {
                [ 'value' => $value, 'operator' => $operator ] = request()->input("filters.$handle");

                $handler = $this->operators()[$operator];

                call_user_func($handler, $builder, $value, $handle);
            }
        }

    }
}
