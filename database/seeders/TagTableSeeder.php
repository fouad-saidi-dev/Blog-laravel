<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags=collect(['SQL','spring','php','java','angularjs','reactjs']);
        
        $tags->each(function($tag){
            $myTag = new Tag();
            $myTag->name = $tag;
            $myTag->save();
        });
    }
}
