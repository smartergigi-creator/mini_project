<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ebook;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
class AdminController extends Controller
{
 
public function dashboard()
{
    $users = User::where('role', 'user')
                 ->latest()
                 ->paginate(10); // per page 10 users
    $totalUsers = User::where('role', 'user')->count();
    $totalEbooks = Ebook::count();
    $todayUploads = Ebook::whereDate('created_at', Carbon::today())->count();
    $expiredShares = Ebook::where('share_enabled', 1)
        ->whereNotNull('share_expires_at')
        ->where('share_expires_at', '<', now())
        ->count();

    return view('admin.dashboard', compact(
        'users',
        'totalUsers',
        'totalEbooks',
        'todayUploads',
        'expiredShares'
    ));
}

public function resetUserUploads($id)
{
    $user = User::findOrFail($id);

    $ebooks = Ebook::where('user_id', $user->id)->get();

    foreach ($ebooks as $ebook) {
        $ebook->pages()->delete();

        $folderPath = public_path("ebooks/{$ebook->folder_path}");
        if (File::exists($folderPath)) {
            File::deleteDirectory($folderPath);
        }

        $ebook->delete();
    }

    return back()->with('success', 'User uploads reset successfully.');
}

    
}
