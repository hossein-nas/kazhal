<?php

use App\File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InitialFilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //this is for clean uping the .../public/images directory
        Storage::disk('public')->deleteDirectory(('images'));

        $images =  Storage::disk('local')->allFiles('/assets/images') ;
        foreach( $images as $image ){
            $file_info = pathinfo ($image);
            $hashname = (string) Str::uuid();
            $ext = $file_info['extension'];
            $name = $file_info['basename'];
            $model = factory(File::class)->create([
                'ext' => $ext,
                'name' => $name,
                'hashname' => $hashname,
                'basedir' => storage_path('app/public/images'),
                'base_url' => '/storage/images',
                'is_responsive' => 0,
                'specs' => [
                    [
                        'width' => 0,
                        'height' => 0,
                        'ration' => 0,
                        'filesize' => filesize(storage_path("app/$image")),
                        'relativepath' => "/storage/images/${hashname}.${ext}"
                    ]
                ]
            ]);
            Storage::copy("$image", "/public/images/$hashname.". $ext);
        }
    }
}
