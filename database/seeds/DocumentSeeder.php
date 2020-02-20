<?php

use App\Models\File;
use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Document::class, 5)->create()->each(function ($document) {
            $document->file()->save(factory(File::class)->make());
        });
    }
}
