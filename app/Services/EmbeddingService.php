<?php

namespace App\Services;

use App\Models\Beer;
use Illuminate\Support\Facades\DB;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Facades\Prism;

class EmbeddingService
{

    public function generateEmbedding(string $text)
    {
        $response = Prism::embeddings()
            ->using(Provider::OpenAI, 'text-embedding-3-large')
            ->fromInput($text)
            ->asEmbeddings();

        return $response;

    }

    public function queryEmbeddingBeers(string $query)
    {

        $response = $this->generateEmbedding($query);

        $vectorLiteral = '[' . implode(',', $response->embeddings[0]->embedding) . ']';

        $results = DB::table('beer_embeddings')
            ->select(
                'beer_id',
                'text',
                DB::raw("embedding <#> '$vectorLiteral' AS distance")
            )->orderBy('distance')
            ->limit(5)
            ->get();

        $beer_ids = $results->map(fn ($beer) => json_decode($beer->beer_id));

        $beers = Beer::with('stores', 'images')
            ->findMany($beer_ids)
            ->sortBy(function ($beer) use ($beer_ids) {
                return array_search($beer->id, $beer_ids->toArray());
            })->values();

        return $beers->toJson(JSON_UNESCAPED_UNICODE);


    }

}
