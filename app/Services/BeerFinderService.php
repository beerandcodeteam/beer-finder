<?php

namespace App\Services;

use Prism\Prism\Enums\Provider;
use Prism\Prism\Enums\ToolChoice;
use Prism\Prism\Facades\Prism;
use Prism\Prism\Facades\Tool;
use Prism\Prism\Schema\ArraySchema;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;

class BeerFinderService
{

    public function __construct(protected EmbeddingService $embeddingService)
    {
    }

    public function agent(string $userMessage): array
    {
        try {
            $schema = $this->responseSchema();

            $response = Prism::structured()
                ->using(Provider::OpenAI, 'gpt-4.1-mini')
                ->withSchema($schema)
                ->withSystemPrompt(view('prompts.brewer_agent'))
                ->withPrompt($userMessage)
                ->withMaxSteps(5)
                ->withTools([
                    Tool::as('search_beers')
                        ->for('Buscar cervejas relevantes com base em uma descrição, estilo, sabor ou harmonização desejada.')
                        ->withStringParameter(
                            'query',
                            'Descrição da cerveja, preferências de sabor ou contexto de harmonização fornecido pelo usuário'
                        )
                        ->using(fn($query) => $this->embeddingService->queryEmbeddingBeers($query))
                ])
                ->withToolChoice(ToolChoice::Auto)
                ->asStructured();
        } catch (\Exception $e)
        {
            return [
                'text' => "Ocorreu um erro ao gerar a resposta",
                'beers' => []
            ];
        }

        return $response->structured;
    }

    public function responseSchema()
    {
        $beerItemSchema = new ObjectSchema(
            name: 'beer_item',
            description: 'Item individual de cerveja recomendada pelo Beer Finder Agent',
            properties: [
                new StringSchema(
                    'nome',
                    'Nome da cerveja recomendada'
                ),
                new StringSchema(
                    'imagem',
                    'URL da imagem da cerveja (pode ser vazio se não houver)'
                ),
                new StringSchema(
                    'url',
                    'URL de compra ou página de detalhes da cerveja (pode ser vazio se não houver)'
                ),
                new StringSchema(
                    'preco',
                    'Preço da cerveja em texto, ex: "R$ 4,99" (pode ser vazio se não houver)'
                ),
            ],
            requiredFields: ['nome', 'imagem', 'url', 'preco']
        );

        $schema = new ObjectSchema(
            name: 'beer_finder_response',
            description: 'Resposta estruturada do Beer Finder Agent',
            properties: [
                new StringSchema(
                    'text',
                    'Texto descritivo curto explicando por que essas cervejas foram recomendadas'
                ),
                new ArraySchema(
                    'beers',
                    'Lista de cervejas recomendadas com base na busca vetorial',
                    $beerItemSchema
                ),
            ],
            requiredFields: ['text', 'beers']
        );

        return $schema;
    }

}
