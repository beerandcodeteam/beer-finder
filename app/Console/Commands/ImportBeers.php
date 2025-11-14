<?php

namespace App\Console\Commands;

use App\Jobs\ProcessBeerJob;
use App\Models\Beer;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportBeers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-beers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jsonPath = public_path('beers.json');

        $jsonData = json_decode(file_get_contents($jsonPath), true);

        if (!is_array($jsonData)) {
            die("Erro ao ler o json \n");
        }

        foreach ($jsonData as $beer) {
            $beer = Beer::create([
                'name'            => $beer['name'] ?? null,
                'tagline'         => $beer['tagline'] ?? null,
                'description'     => $beer['description'] ?? null,
                'first_brewed_at' => Carbon::canBeCreatedFromFormat($beer['first_brewed'], 'm/Y') ?
                    Carbon::createFromFormat('m/Y', $beer['first_brewed'])
                    : null,
                'abv'             => $beer['abv'] ?? 1,
                'ibu'             => (int) $beer['ibu'] ?? 1,
                'ebc'             => $beer['ebc'] ?? 1,
                'ph'              => $beer['ph'] ?? 1,
                'volume'          => (int) number_format($beer['volume']['value'], 0),
                'ingredients'     => json_encode($beer['ingredients'] ?? []),
                'brewer_tips'     => $beer['brewers_tips'] ?? null,
            ]);

            dispatch(new ProcessBeerJob($beer));
        }

        $this->info("Importação finalizada com sucesso!");


    }
}
