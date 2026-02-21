<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Ebook;
use App\Models\EbookPage;

use App\Models\Category;  

use Illuminate\Support\Facades\DB;


class EbookController extends Controller
{
    /* ======================================================
       1. LIST ALL EBOOKS
    ====================================================== */
//    public function index()
// {
//     $ebooks = Ebook::latest()
//         ->get()
//         ->groupBy('title'); // 👈 GROUP BY MANUAL EBOOK NAME

//     return view('ebook.index', compact('ebooks'));
// }



public function index()
{ 
    $user = auth()->user();

    $ebooks = Ebook::with(['uploader', 'sharedUser', 'category', 'subcategory', 'relatedSubcategory'])
        ->latest()
        ->paginate(10);

    $groupedEbooks = $ebooks->getCollection()->groupBy('title');

    // Parent categories for category dropdown
    $categories = Category::whereNull('parent_id')
        ->orderBy('name')
        ->get();

    return view('ebook.index', compact(
        'ebooks',
        'groupedEbooks',
        'user',
        'categories'   // 🔥 now passed to blade
    ));
}



    /* ======================================================
       2. UPLOAD PDF(s)
    ====================================================== */
   
public function store(Request $request)
{
    try {

        // Always get fresh data
        $user = auth()->user()->fresh();


        /* ============================
           1. Upload Permission
        ============================ */
        $hasUploadAccess = $user && (
            $user->role === 'admin'
            || $user->can_upload
        );

        if (!$hasUploadAccess) {
            return response()->json([
                'status' => false,
                'message' => 'You are not allowed to upload'
            ], 403);
        }


        /* ============================
           3. COUNT EXISTING UPLOADS
        ============================ */

        // Already uploaded ebooks (reliable)
        $uploadedCount = Ebook::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhere('uploaded_by', $user->id);
        })->count();

        // New files count
        $newFilesCount = $request->hasFile('pdfs')
            ? count($request->file('pdfs'))
            : 0;

        $totalAfterUpload = $uploadedCount + $newFilesCount;


        $uploadLimit = (int) $user->upload_limit;
        $hasFiniteLimit = $user->role !== 'admin' && $uploadLimit > 0;

        if ($hasFiniteLimit && $totalAfterUpload > $uploadLimit) {

            $remaining = max(
                0,
                $uploadLimit - $uploadedCount
            );

            return response()->json([
                'status' => false,
                'message' =>
                    "Upload limit exceeded. You can upload only {$remaining} more file(s)."
            ], 403);
        }


        /* ============================
           4. Validation
        ============================ */

        $request->validate([
            'ebook_name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'related_subcategory_id' => 'nullable|exists:categories,id',
            'pdfs'       => 'required|array|min:1',
            'pdfs.*'     => 'required|file|mimes:pdf|max:51200',
        ]);

        if ($request->filled('category_id') && $request->filled('subcategory_id')) {
            $isValidSubcategory = Category::where('id', $request->subcategory_id)
                ->where('parent_id', $request->category_id)
                ->exists();

            if (!$isValidSubcategory) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid subcategory for selected category.'
                ], 422);
            }
        }

        if ($request->filled('subcategory_id') && $request->filled('related_subcategory_id')) {
            $isValidRelatedSubcategory = Category::where('id', $request->related_subcategory_id)
                ->where('parent_id', $request->subcategory_id)
                ->exists();

            if (!$isValidRelatedSubcategory) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid related subcategory for selected subcategory.'
                ], 422);
            }
        }


        if (!$request->hasFile('pdfs')) {
            return response()->json([
                'status' => false,
                'message' => 'No PDF files uploaded.'
            ], 400);
        }


        /* ============================
           5. Prepare Files
        ============================ */

        $files = $request->file('pdfs');

        if (!is_array($files)) {
            $files = [$files];
        }

        usort($files, fn ($a, $b) =>
            strcmp($a->getClientOriginalName(), $b->getClientOriginalName())
        );


        $created = 0;
        $failed  = 0;
        $manualTitle = $request->ebook_name;


        /* ============================
           6. Upload
        ============================ */

        foreach ($files as $file) {

            if (!$file->isValid()) {
                $failed++;
                continue;
            }

            $originalName = pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $safeTitle = Str::title(str_replace('_', ' ', $originalName));

            $folder = Str::slug($originalName)
                . '_' . time()
                . '_' . Str::random(4);

            $basePath = public_path("ebooks/$folder");

            if (!File::exists($basePath)) {
                File::makeDirectory($basePath, 0777, true);
            }

            $pdfName = Str::slug($originalName) . '.pdf';

            $file->move($basePath, $pdfName);


            $ebook = Ebook::create([

                'title'       => $manualTitle,
                'file_title'  => $safeTitle,
                'pdf_path'    => "ebooks/$folder/$pdfName",
                'folder_path' => $folder,
                'page_count'  => 0,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'related_subcategory_id' => $request->related_subcategory_id,

                // MAIN FIELD ✅
                'user_id'     => $user->id,

                // optional
                'uploaded_by' => $user->id,
            ]);

            // Pre-generate pages so home view can show first-page cover immediately.
            try {
                $this->ensurePagesExist($ebook);
            } catch (\Throwable $e) {
                // Keep upload successful even if preview generation fails for one file.
            }

            $created++;
        }


        /* ============================
           7. Response
        ============================ */

        if ($created === 0) {
            return response()->json([
                'status' => false,
                'message' => 'All uploaded files are invalid.'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' =>
                "$created ebook(s) uploaded successfully." .
                ($failed ? " $failed file(s) skipped." : '')
        ]);


    } catch (\Throwable $e) {

        return response()->json([
            'status' => false,
            'message' => 'Upload failed',
            'error'   => $e->getMessage()
        ], 500);
    }
}








// public function store(Request $request)
// {
//     $request->validate([
//         'title'   => 'required|string|max:255', // ✅ manual ebook name
//         'pdfs.*'  => 'required|mimes:pdf|max:20480',
//     ]);

//     if (!$request->hasFile('pdfs')) {
//         return back()->with('error', 'No PDF files uploaded.');
//     }

//     $files = $request->file('pdfs');
//     if (!is_array($files)) {
//         $files = [$files];
//     }

//     // Sort files (important for folder upload)
//     usort($files, fn ($a, $b) =>
//         strcmp($a->getClientOriginalName(), $b->getClientOriginalName())
//     );

//     $created = 0;

//     // ✅ Manual Ebook Name (same for all files)
//     $manualTitle = $request->title;

//     // ✅ Common file title (from FIRST file only)
//     $firstFileName = pathinfo($files[0]->getClientOriginalName(), PATHINFO_FILENAME);
//     $fileTitle = Str::slug($firstFileName); // flipbook

//     // ✅ ONE folder for all files
//     $folder = $fileTitle . '_' . time() . '_' . Str::random(4);
//     $basePath = public_path("ebooks/$folder");

//     File::makeDirectory($basePath, 0755, true);

//     foreach ($files as $file) {

//         if (!$file->isValid()) continue;

//         $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
//         $pdfName = Str::slug($originalName) . '.pdf';

//         $file->move($basePath, $pdfName);

//         Ebook::create([
//             'title'       => $manualTitle,   // ✅ Gate Flipbook
//             'file_title'  => $fileTitle,     // ✅ flipbook (common)
//             'pdf_path'    => "ebooks/$folder/$pdfName",
//             'folder_path' => $folder,
//             'page_count'  => 0,
//             'uploaded_by' => auth()->id() ?? 1,
//         ]);

//         $created++;
//     }

//     return back()->with(
//         $created ? 'success' : 'error',
//         $created ? "$created file(s) added to ebook successfully." : 'No valid PDF files found.'
//     );
// }

    /* ======================================================
       3. CORE METHOD – ENSURE PAGES EXIST
       (USED BY VIEW + SHARE)
    ====================================================== */
    // public function ensurePagesExist(Ebook $ebook)
    // {
    //     $pagesPath = public_path("ebooks/{$ebook->folder_path}/pages");

    //     // ✅ Pages already exist
    //     if (is_dir($pagesPath) && count(glob($pagesPath . '/*.jpg')) > 0) {
    //         return true;
    //     }

    //     $pdfFile = public_path($ebook->pdf_path);
    //     if (!file_exists($pdfFile)) {
    //         return false;
    //     }

    //     if (!file_exists($pagesPath)) {
    //         mkdir($pagesPath, 0777, true);
    //     }

    //     $magick = "C:\\Program Files\\ImageMagick-7.1.2-Q16-HDRI\\magick.exe";
    //     if (!file_exists($magick)) {
    //         abort(500, 'ImageMagick not found');
    //     }

    //     $output = $pagesPath . "\\page_%03d.jpg";
    //     exec("\"$magick\" -density 200 \"$pdfFile\" -quality 92 \"$output\"");

    //     return count(glob($pagesPath . '/*.jpg')) > 0;
    // }



public function ensurePagesExist(Ebook $ebook)
{
    $pagesPath = public_path("ebooks/{$ebook->folder_path}/pages");

    // If already in DB → skip
    if ($ebook->pages()->count() > 0) {
        return true;
    }

    $pdfFile = public_path($ebook->pdf_path);

    if (!file_exists($pdfFile)) {
        return false;
    }

    if (!file_exists($pagesPath)) {
        mkdir($pagesPath, 0777, true);
    }

    $magick = "C:\\Program Files\\ImageMagick-7.1.2-Q16-HDRI\\magick.exe";

    if (!file_exists($magick)) {
        abort(500, 'ImageMagick not found');
    }

    // Convert PDF → JPG
    $output = $pagesPath . "\\page_%03d.jpg";

    exec("\"$magick\" -density 200 \"$pdfFile\" -quality 92 \"$output\"");

    $images = glob($pagesPath . '/*.jpg');

    if (!$images) {
        return false;
    }

    sort($images);

    // Save DB entries
    foreach ($images as $index => $img) {

        [$width, $height] = getimagesize($img);

        EbookPage::create([
            'ebook_id'   => $ebook->id,
            'page_no'    => $index + 1,
            'image_path' => str_replace(public_path(), '', $img),
            'orientation'=> $width > $height ? 'landscape' : 'portrait',
            'width'      => $width,
            'height'     => $height,
        ]);
    }

    return true;
}

    /* ======================================================
       4. VIEW FLIPBOOK (ADMIN / DASHBOARD)
    ====================================================== */
    public function view($id)
    {
        $ebook = Ebook::findOrFail($id);

        if (!$this->ensurePagesExist($ebook)) {
            abort(500, 'PDF conversion failed');
        }

        $images = glob(public_path("ebooks/{$ebook->folder_path}/pages/*.jpg"));
        natsort($images);

        $ebook->page_count = count($images);
        $ebook->save();

        $pages = array_map(
            fn ($img) => asset("ebooks/{$ebook->folder_path}/pages/" . basename($img)),
            $images
        );

        return view('ebook.flipbook', compact('ebook', 'pages'));
    }

    /* ======================================================
       5. PUBLIC VIEW (OPTIONAL)
    ====================================================== */
    public function publicView($id)
    {
        return $this->view($id);
    }

    /* ======================================================
       6. DELETE EBOOK
    ====================================================== */
public function delete($id)
{
    try {

        $ebook = Ebook::findOrFail($id);

        $folderPath = public_path("ebooks/{$ebook->folder_path}");

        if (File::exists($folderPath)) {

            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                exec('rd /s /q "' . $folderPath . '"');
            } else {
                File::deleteDirectory($folderPath);
            }
        }

        // Delete DB record
        $ebook->delete();

        return response()->json([
            'status' => true,
            'message' => 'Ebook deleted successfully'
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'status' => false,
            'error'   => $e->getMessage(),
        ], 500);
    }
}






    /* ======================================================
   7. API VIEW (JSON)
====================================================== */
public function viewApi($id)
{
    $ebook = Ebook::findOrFail($id);

    return response()->json($ebook);
}

}

