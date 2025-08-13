<?php

namespace Spatie\ElasticsearchQueryBuilder\Sorts;

use Spatie\ElasticsearchQueryBuilder\Sorts\Concerns\HasMissing;
use Spatie\ElasticsearchQueryBuilder\Sorts\Concerns\HasMode;
use Spatie\ElasticsearchQueryBuilder\Sorts\Concerns\HasUnmappedType;

class Sort implements Sorting
{
    use HasMissing;
    use HasUnmappedType;
    use HasMode;

    public static function create(string $field, string $order = self::DESC): static
    {
        return new self($field, $order);
    }

    public function __construct(protected string $field, protected string $order)
    {
    }

    public function toArray(): array
    {
        $payload = array_filter(
            [
                    'order' => $this->order,
                    'missing' => $this->missing,
                    'unmapped_type' => $this->unmappedType,
                    'mode' => $this->mode,
            ]
        );

        // missing can be empty string or zero value
        if ($this->missing !== null) {
            $payload['missing'] = $this->missing;
        }

        return [
            $this->field => $payload,
        ];
    }
}
