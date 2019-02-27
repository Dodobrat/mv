<?php

namespace App\Modules\Members\Http\Controllers;

use App\Modules\Members\Models\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function index() {

        $members = Member::active()->with(['thumbnail_media','profile_media'])->reversed()->get();

        return view('members::front.index',compact('members'));

    }

    public function getMember(Request $request) {

        $errors = [];

        if (empty($request->get('member_id'))) {
            $errors[] = trans('index::errors.no_members');
        }

        $member = Member::with(['thumbnail_media','profile_media'])->where('id', $request->member_id)->first();

        if (empty($member)) {
            $errors[] = trans('index::errors.no_member');
        }

        return response()->json([
            'errors' => $errors,
            'member_modal' => view('members::front.boxes.member', compact('member'))->render(),
        ]);
    }
}
