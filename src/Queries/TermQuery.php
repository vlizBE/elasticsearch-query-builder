<?php

namespace Spatie\ElasticsearchQueryBuilder\Queries;

class TermQuery implements Query
{
    protected string $field;

    protected bool|int|string $value;

    protected ?float $boost = null;

    public static function create(string $field, bool|int|string $value, ?float $boost = null): static
    {
        return new self($field, $value, $boost);
    }

    public function __construct(string $field, bool|int|string $value, ?float $boost = null)
    {
        $this->field = $field;
        $this->value = $value;
        $this->boost = $boost;
    }

    public function toArray(): array
    {
        $term = [
            'term' => [
                $this->field => [
                    'value' => $this->value,
                ],
            ],
        ];

        if ($this->boost !== null) {
            $term['term'][$this->field]['boost'] = $this->boost;
        }

        return $term;
    }
}
