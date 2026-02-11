<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ebook;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\EbookController;

class EbookShareController extends Controller
{
    /* ======================================================
       1. GENERATE SHARE LINK
    ====================================================== */
public function generate($id)
{
    try {

        $user = auth()->user();

        /* ============================
           1. Permission Check
        ============================ */
        if ($user->can_share == 0) {
            return response()->json([
                'status' => false,
                'message' => 'You are not allowed to share'
            ], 403);
        }

        /* ============================
           2. Find Ebook
        ============================ */
        $ebook = Ebook::find($id);

        if (!$ebook) {
            return response()->json([
                'status' => false,
                'message' => 'Ebook not found'
            ], 404);
        }

        /* ============================
           3. Already Shared → Regenerate
           (Reset Views)
        ============================ */
        if ($ebook->share_enabled == 1 &&
            $ebook->shared_by == $user->id) {

            $ebook->share_token      = Str::random(40);
            $ebook->share_expires_at = now()->addDays(7);
            $ebook->current_views    = 0;   // 🔥 RESET
           // Auto set view limit from share_limit
$ebook->max_views = $user->share_limit;


            $ebook->save();

            return response()->json([
                'status'     => true,
                'publicLink' => url('/flip-book/' . $ebook->share_token),
                'expires_at' => $ebook->share_expires_at,
                'message'    => 'New link generated'
            ]);
        }

        /* ============================
           4. Share Limit Check
        ============================ */
       $shareCount = Ebook::where('shared_by', $user->id)
    ->where('share_enabled', 1)
    ->where('share_expires_at', '>', now()) // not expired
    ->whereColumn('current_views', '<', 'max_views') // not finished
    ->count();


        if ($shareCount >= $user->share_limit) {
            return response()->json([
                'status' => false,
                'message' => 'Share limit reached'
            ], 403);
        }

        /* ============================
           5. Generate New Link
        ============================ */
        $ebook->share_token      = Str::random(40);
        $ebook->share_expires_at = now()->addDays(7);
        $ebook->share_enabled    = 1;
        $ebook->shared_by        = $user->id;
        $ebook->max_views = $user->share_limit;

        // $ebook->max_views        = 10;
        $ebook->current_views    = 0;

        $ebook->save(); // 🔥 Force save

        return response()->json([
            'status'     => true,
            'publicLink' => url('/flip-book/' . $ebook->share_token),
            'expires_at' => $ebook->share_expires_at
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'status' => false,
            'message' => 'Share failed',
            'error'   => $e->getMessage()
        ], 500);
    }
}





    /* ======================================================
       2. SHARE VIEW (MAIN ENTRY)
    ====================================================== */
public function view($token)
{
    $ebook = Ebook::where('share_token', $token)
        ->where('share_enabled', 1)
        ->first();

    /* ============================
       1. Invalid Link
    ============================ */
    if (!$ebook) {
        return view('ebook/errors.share-invalid');
    }

    /* ============================
       2. Date Expired
    ============================ */
    if ($ebook->share_expires_at &&
        now()->gt($ebook->share_expires_at)) {

        return view('ebook/errors.share-expired');
    }

    /* ============================
       3. View Limit Check (GLOBAL)
    ============================ */

    // If limit reached → block
    if ($ebook->max_views !== null &&
        $ebook->current_views >= $ebook->max_views) {

        return view('ebook/errors.limit-reached');
    }

    // Increase view count
    $ebook->increment('current_views');

    /* ============================
       4. Load Pages
    ============================ */

    $ebookController = new \App\Http\Controllers\EbookController();

    if (!$ebookController->ensurePagesExist($ebook)) {
        return view('ebook.loading', compact('ebook'));
    }

    $pagesPath = public_path("ebooks/{$ebook->folder_path}/pages");

    $pages = collect(glob($pagesPath . '/*.jpg'))
        ->sort()
        ->map(fn ($img) =>
            asset("ebooks/{$ebook->folder_path}/pages/" . basename($img))
        )
        ->toArray();

    if (count($pages) === 0) {
        return view('ebook.loading', compact('ebook'));
    }

    return view('ebook.flipbook', compact('ebook', 'pages'));
}


}
