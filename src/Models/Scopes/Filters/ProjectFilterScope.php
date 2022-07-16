<?php

namespace Taskday\Models\Scopes\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Taskday\Base\Operator;
use Taskday\Base\Filter;
use Taskday\Models\Card;
use Taskday\Models\Project;

class ProjectFilterScope extends Filter
{
    public $name = 'Project';


    /** @inheritdoc */
    public function boot(): void
    {
        Card::addGlobalScope($this);
    }

    /** @inheritdoc */
    public function operators(): array
    {
        return [
            Operator::IS_EQUAL,
            Operator::IS_NOT_EQUAL,
        ];
    }

    /** @inheritdoc */
    public function handler(Operator $operator)
    {
        return match ($operator) {
            Operator::IS_EQUAL => function (Builder $query, string $value) {
                $query->whereHas('project', function ($projects) use ($value) {
                    $projects->where('id', $value);
                });
            },
            Operator::IS_NOT_EQUAL => function (Builder $query, string $value) {
                $query->whereHas('project', function ($projects) use ($value) {
                    $projects->where('id', '<>', $value);
                });
            },
            default => function () {
            }
        };
    }

    /** @inheritdoc */
    public function apply(Builder $builder, Model $model)
    {
        if (request()->has('filters')) {
            foreach (request()->input('filters') as $filter) {
                if ($filter['type'] == "project-filter") {
                    [ 'value' => $value, 'operator' => $operator ] = $filter;
                    $handler = $this->handler(Operator::from($operator));
                    call_user_func($handler, $builder, $value);
                    try {
                    } catch (\Throwable $e) {

                    }
                }
            }
        }
    }
    /**
     * Return the possible columns to use with this filter.
     *
     * @return array
     */
    public function columns(): array
    {
        return [

        ];
    }
}
