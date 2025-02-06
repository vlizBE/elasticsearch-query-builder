<?php

namespace Spatie\ElasticsearchQueryBuilder;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

class MultiBuilder
{
    protected ?array $builders = [];

    public function __construct(protected Client $client)
    {
    }

    public function addBuilder(Builder $builder, ?string $indexName = null): static
    {
        $this->builders[] = [
            'index' => $indexName ?? $builder->getIndex(),
            'builder' => $builder,
        ];

        return $this;
    }

    public function getPayload(): array
    {
        $payload = [];

        foreach ($this->builders as $builderInstance) {
            ['index' => $index, 'builder' => $builder] = $builderInstance;
            $payload[] = $index ? ['index' => $index] : [];
            $payload[] = $builder->getPayload();
        }

        return $payload;
    }

    public function search(): Elasticsearch|Promise
    {
        $payload = $this->getPayload();

        $params = [
            'body' => $payload,
        ];

        return $this->client->msearch($params);
    }
}
