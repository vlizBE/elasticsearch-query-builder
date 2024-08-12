<?php

namespace Spatie\ElasticsearchQueryBuilder\Queries;

class QueryStringQuery implements Query
{
    public static function create(
        string $query,
        null | string $defaultField = null,
        null | string | int $fuzziness = null,
        null | float $boost = null
    ): self {
        return new self($query, $defaultField, $fuzziness, $boost);
    }

    public function __construct(
        protected string $query,
        protected null | string $defaultField = null,
        protected null | string | int $fuzziness = null,
        protected null | float $boost = null
    ) {
    }

    public function toArray(): array
    {
        $queryString = [
            'query_string' => [
                'query' => $this->query,
            ]
        ];

        if ($this->defaultField) {
            $queryString['query_string']['default_field'] = $this->defaultField;
        }

        if ($this->fuzziness) {
            $queryString['query_string']['fuzziness'] = $this->fuzziness;
        }

        if ($this->boost) {
            $queryString['query_string']['boost'] = $this->boost;
        }

        return $queryString;
    }
}
