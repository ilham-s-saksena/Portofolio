<?php

namespace App\Http\Controllers;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Organization;
use App\Models\Portofolio;
use App\Models\Skill;
use App\Models\SocialMedia;
use Illuminate\Support\Facades\Validator;
use App\Models\BasicInfo;
use Carbon\Carbon;

use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function basic_info(Request $request){
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|max:50',
            'position' => 'required|max:50',
            'description' => 'required|max:255',
            'photo' => 'required|image|mimes:jpg,png,jpeg|max:1024',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $userId = auth()->id();

    $basicInfo = BasicInfo::where('user_id', $userId)->first();

    if($basicInfo && $basicInfo->photo) {
        $oldPhotoPath = public_path($basicInfo->photo);
        if(file_exists($oldPhotoPath)) {
            unlink($oldPhotoPath);
        }
    }

    $photo = $request->file('photo');
    $extension = $photo->getClientOriginalExtension();
    $filename = $userId . '-' . Carbon::now()->format('YmdHis') . '.' . $extension;
    $photo->move(public_path('basic_info'), $filename);
    $photoPath = 'basic_info/' . $filename;

    if($basicInfo) {
        $basicInfo->update([
            'full_name' => $request->input('fullname'),
            'position' => $request->input('position'),
            'description' => $request->input('description'),
            'photo' => $photoPath
        ]);
    } else {
        BasicInfo::create([
            'user_id' => $userId,
            'full_name' => $request->input('fullname'),
            'position' => $request->input('position'),
            'description' => $request->input('description'),
            'photo' => $photoPath
        ]);
    }
    
        return response()->json(['message' => 'Basic info saved successfully'], 201);
    }    

    public function social_media(Request $request){
        $validator = Validator::make($request->all(), [
            'social_media_name' => 'required|in:facebook,instagram,linkedin,gmail,whatsapp,github,twitter',
            'link' => 'required',
        ]);        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $userId = auth()->id();

        $photoPath = 'social_media_logo/' . $request->input('social_media_name') . '.svg';

        $basicInfo = new SocialMedia();
        $basicInfo->user_id = $userId;
        $basicInfo->social_media_name = $request->input('social_media_name');
        $basicInfo->link = $request->input('link');
        $basicInfo->photo = $photoPath;

        $basicInfo->save();

        return response()->json(['message' => 'Media Social Successfully Stored'], 201);
    }


    public function education(Request $request){
        $validator = Validator::make($request->all(), [
            'education_name' => 'required|max:50',
            'years' => 'required|max:12',
            'major' => 'required|max:50',
            'description' => 'required|max:180',
            'campus_link' => 'required|max:100',
            'photo' => 'required|image|mimes:jpg,png,jpeg,svg|max:1024',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userId = auth()->id();

        $education = Education::where('user_id', $userId)->first();

        if($education && $education->photo) {
            $oldPhotoPath = public_path($education->photo);
            if(file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
        }

        $photo = $request->file('photo');
        $extension = $photo->getClientOriginalExtension();
        $filename = $userId . '-' . Carbon::now()->format('YmdHis') . '.' . $extension;
        $photo->move(public_path('education'), $filename);
        $photoPath = 'education/' . $filename;

        if($education) {
            $education->update([
                'education_name' => $request->input('education_name'),
                'years' => $request->input('years'),
                'major' => $request->input('major'),
                'description' => $request->input('description'),
                'campus_link' => $request->input('campus_link'),
                'photo' => $photoPath
            ]);
        } else {
            BasicInfo::create([
                'user_id' => $userId,
                'education_name' => $request->input('education_name'),
                'years' => $request->input('years'),
                'major' => $request->input('major'),
                'description' => $request->input('description'),
                'campus_link' => $request->input('campus_link'),
                'photo' => $photoPath
            ]);
        }


        return response()->json(['message' => 'Education saved successfully'], 201);
    }

    public function organization(Request $request){
        $validator = Validator::make($request->all(), [
            'organization_name' => 'required|max:35',
            'years' => 'required|max:12',
            'position' => 'required|max:40',
            'description' => 'required|max:180',
            'photo' => 'required|image|mimes:jpg,png,jpeg,svg|max:1024',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userId = auth()->id();

        $photo = $request->file('photo');
        $extension = $photo->getClientOriginalExtension();
        $filename = $userId . '-' . Carbon::now()->format('YmdHis') . '.' . $extension;
        $photo->move(public_path('organization'), $filename);
        $photoPath = 'organization/' . $filename;

        $basicInfo = new Organization();
        $basicInfo->user_id = $userId;
        $basicInfo->organization_name = $request->input('organization_name');
        $basicInfo->years = $request->input('years');
        $basicInfo->position = $request->input('position');
        $basicInfo->description = $request->input('description');
        $basicInfo->photo = $photoPath;

        $basicInfo->save();

        return response()->json(['message' => 'Organization saved successfully'], 201);
    }

    public function skill(Request $request){
        $validator = Validator::make($request->all(), [
            'skill_name' => 'required|max:100',
            'level' => 'required',
            'description' => 'required|max:255',
            'photo' => 'required|image|mimes:jpg,png,jpeg,svg|max:1024',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userId = auth()->id();

        $photo = $request->file('photo');
        $extension = $photo->getClientOriginalExtension();
        $filename = $userId . '-' . Carbon::now()->format('YmdHis') . '.' . $extension;
        $photo->move(public_path('skill'), $filename);
        $photoPath = 'skill/' . $filename;

        $basicInfo = new Skill();
        $basicInfo->user_id = $userId;
        $basicInfo->skill_name = $request->input('skill_name');
        $basicInfo->level = $request->input('level');
        $basicInfo->description = $request->input('description');
        $basicInfo->photo = $photoPath;

        $basicInfo->save();

        return response()->json(['message' => 'Skill saved successfully'], 201);
    }

    public function experience(Request $request){
        $validator = Validator::make($request->all(), [
            'experience_name' => 'required|max:150',
            'years' => 'required|max:12',
            'company' => 'required|max:80',
            'company_address' => 'required|max:160',
            'description' => 'required|max:255',
            'link' => 'max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userId = auth()->id();

        $basicInfo = new Experience();
        $basicInfo->user_id = $userId;
        $basicInfo->experience_name = $request->input('experience_name');
        $basicInfo->years = $request->input('years');
        $basicInfo->company = $request->input('company');
        $basicInfo->company_address = $request->input('company_address');
        $basicInfo->description = $request->input('description');
        $basicInfo->link = $request->input('link');

        $basicInfo->save();

        return response()->json(['message' => 'Experience saved successfully'], 200);
    }

    public function portofolio(Request $request){
        $validator = Validator::make($request->all(), [
            'portofolio_name' => 'required|max:80',
            'portofolio_date' => 'required|max:30',
            'description' => 'required',
            'link' => 'max:255',
            'photo' => 'required|image|mimes:jpg,png,jpeg,svg|max:1024',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userId = auth()->id();

        $photo = $request->file('photo');
        $extension = $photo->getClientOriginalExtension();
        $filename = $userId . '-' . Carbon::now()->format('YmdHis') . '.' . $extension;
        $photo->move(public_path('portofolio'), $filename);
        $photoPath = 'portofolio/' . $filename;

        $basicInfo = new Portofolio();
        $basicInfo->user_id = $userId;
        $basicInfo->portofolio_name = $request->input('portofolio_name');
        $basicInfo->portofolio_date = $request->input('portofolio_date');
        $basicInfo->description = $request->input('description');
        $basicInfo->link = $request->input('link');
        $basicInfo->photo = $photoPath;

        $basicInfo->save();

        return response()->json(['message' => 'Portofolio saved successfully'], 200);
    }
}
