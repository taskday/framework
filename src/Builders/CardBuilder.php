<?php

namespace Taskday\Builders;

use Taskday\Models\Card;
use Taskday\Models\CardField;
use Illuminate\Database\Eloquent\Builder;

class CardBuilder extends Builder
{
    public function whereCustom(string $handle, string $value): self
    {
        $ids = Card::with([
            'fields' => function (Builder $q) use ($handle, $value) {
                $q->withPivot('value');
            },
        ])
            ->whereHas('fields', function (Builder $q) use ($handle, $value) {
                $q->where('handle', $handle)->where('value', $value);
            })
            ->pluck('id');

        $this->query->whereIn('id', $ids);

        return $this;
    }

    public function whereCustomType(string $type, string $value): self
    {
        $ids = Card::with([
            'fields' => function (Builder $q) {
                $q->withPivot('value');
            },
        ])
            ->whereHas('fields', function (Builder $q) use ($type, $value) {
                $q->where('type', $type)->where('value', $value);
            })
            ->pluck('id');

        $this->query->whereIn('id', $ids);

        return $this;
    }

    public function orderByCustom(int $id, string $order = 'desc'): self
    {
        $this->query->orderBy(
            CardField::select(['value'])
                ->whereColumn('card_id', 'cards.id')
                ->where('field_id', $id)
                ->take(1),
            $order
        );

        return $this;
    }
}
