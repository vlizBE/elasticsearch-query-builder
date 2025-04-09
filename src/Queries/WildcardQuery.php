<?php

namespace Spatie\ElasticsearchQueryBuilder\Queries;

class WildcardQuery implements Query
{
    public static function create(string $field, string $value, ?float $boost = null)
    {
        return new self($field, $value, $boost);
    }

    public function __construct(
        protected string $field,
        protected string $value,
        protected ?float $boost = null
    ) {
    }

    public function toArray(): array
    {
        $wildcard = [
            'wildcard' => [
                $this->field => [
                    'value' => $this->value,
                ],
            ],
        ];

        if ($this->boost !== null) {
            $wildcard['wildcard'][$this->field]['boost'] = $this->boost;
        }

        return $wildcard;
    }
}
