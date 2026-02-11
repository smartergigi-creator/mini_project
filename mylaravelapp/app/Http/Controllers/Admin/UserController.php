<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;




class UserController extends Controller
{
public function update(Request $request, $id)
{
    $user = \App\Models\User::findOrFail($id);

    // Update user permissions
    $user->can_upload   = $request->has('can_upload');
    $user->can_share    = $request->has('can_share');
    $user->upload_limit = $request->upload_limit ?? 0;
    $user->share_limit  = $request->share_limit ?? 0;

    $user->save();

    /* ============================
       🔥 Sync Share Limit → Ebook
    ============================ */

    \App\Models\Ebook::where('shared_by', $user->id)
        ->update([
            'max_views' => $user->share_limit
        ]);

    return back()->with(
        'success',
        'User permissions updated successfully'
    );
}




}
