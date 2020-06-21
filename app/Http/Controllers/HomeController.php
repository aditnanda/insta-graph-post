<?php

namespace App\Http\Controllers;
use Smochin\Instagram\Crawler;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function pukatinganinsta(){
        $crawler = new Crawler;
        $media = $crawler->getMediaByUser('dinaspekerjaanumumkatingan');

        return \json_encode($media);
    }

    public function home(Request $request){
        $crawler = new Crawler;

        if ($request->id == null) {
            return \json_encode('Tambahkan parameter ?id=(username ig) setelah url');
        }
        $id = $request->id;
        $media = $crawler->getMediaByUser($id);

        return \json_encode($media);
    }
}
