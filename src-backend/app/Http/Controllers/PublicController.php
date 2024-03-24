<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PublicController extends Controller
{
    public function index($slug){
        $user = User::where("slug", $slug)->first();
        return response()->json([
            "user" => [
                "basic_information" => $user->basic_info,
                "social_media" => $user->social_media,
                "education" => $user->education,
                "organization" => $user->organization,
                "skill" => $user->skill,
                "experience" => $user->experience,
                "portofolio" => $user->portofolio,
            ],
        ]);
    }
}
