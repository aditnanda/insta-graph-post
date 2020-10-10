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

    public function mediaUrl(Request $request){

        if ($request->url == null) {
            return \json_encode('Isikan url, misal https://www.instagram.com/p/B9i4wlfpPoK/');
        }
        $instagram = new \InstagramScraper\Instagram();
        $nonPrivateAccountMedias = $instagram->getMediaByUrl($request->url);
        // dd($nonPrivateAccountMedias);
        $temp = [
            'link' => $nonPrivateAccountMedias->getLink(),
            'type' => $nonPrivateAccountMedias->getType(),
            'image' => $nonPrivateAccountMedias->getImageHighResolutionUrl(),
            'video' => $nonPrivateAccountMedias->getVideoStandardResolutionUrl(),
            'caption' => $nonPrivateAccountMedias->getCaption(),
            'like_count' => $nonPrivateAccountMedias->getLikesCount(),
            'comment_count' => $nonPrivateAccountMedias->getCommentsCount(),
        ];
        return \json_encode($temp);
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
                'comment_count' => $value->getCommentsCount(),
                'comment' => $comment
            ]);
        }

        // dd($temp);

        return \json_encode($temp);
    }
}
