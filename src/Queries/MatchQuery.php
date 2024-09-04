<?php

namespace Spatie\ElasticsearchQueryBuilder\Queries;

class MatchQuery implements Query
{
    public static function create(
        string $field,
        string | int $query,
        null | string | int $fuzziness = null,
        null | float $boost = null,
        ?string $analyzer = null
    ): self {
        return new self($field, $query, $fuzziness, $boost, $analyzer);
    }

    public function __construct(
        protected string $field,
        protected string | int $query,
        protected null | string | int $fuzziness = null,
        protected null | float $boost = null,
        protected ?string $analyzer = null
    ) {
    }

    public function toArray(): array
    {
        $match = [
            'match' => [
                $this->field => [
                    'query' => $this->query,
                ],
            ],
        ];

        if ($this->fuzziness) {
            $match['match'][$this->field]['fuzziness'] = $this->fuzziness;
        }

        if ($this->boost) {
            $match['match'][$this->field]['boost'] = $this->boost;
        }

        if ($this->analyzer) {
            $match['match'][$this->field]['analyzer'] = $this->analyzer;
        }

        return $match;
    }
}
