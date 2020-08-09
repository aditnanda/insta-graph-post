<?php

namespace App\Http\Controllers;
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

        $instagram = new \InstagramScraper\Instagram();
        $nonPrivateAccountMedias = $instagram->getMedias('dinaspekerjaanumumkatingan');
        // dd($nonPrivateAccountMedias);
        return $this->toJSON($nonPrivateAccountMedias);
    }

    public function home(Request $request){

        if ($request->id == null) {
            return \json_encode('Tambahkan parameter ?id=(username ig) setelah url');
        }
        $id = $request->id;
        $instagram = new \InstagramScraper\Instagram();
        $nonPrivateAccountMedias = $instagram->getMedias($id);
        // dd($nonPrivateAccountMedias);
        return $this->toJSON($nonPrivateAccountMedias);
    }

    public function toJSON($data){
        $temp = [];
        foreach ($data as $key => $value) {
            $comment = [];
            foreach ($value->getComments() as $key => $item) {
                array_push($comment,[
                    'owner' => $item->getOwner()->getUsername(),
                    'text' => $item->getText()
                ]);
            }
            array_push($temp,[
                'link' => $value->getLink(),
                'type' => $value->getType(),
                'image' => $value->getImageHighResolutionUrl(),
                'video' => $value->getVideoStandardResolutionUrl(),
                'caption' => $value->getCaption(),
                'like_count' => $value->getLikesCount(),
                'comment' => $comment
            ]);
        }

        // dd($temp);

        return \json_encode($temp);
    }
}
