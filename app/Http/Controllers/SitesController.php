<?php

namespace App\Http\Controllers;

use App\Models\{Sites};
use App\Http\Requests\StoreSitesRequest;
use App\Http\Requests\UpdateSitesRequest;
use Illuminate\Support\Facades\Auth;
use Smark\Smark\Stringer;

class SitesController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sites.sites', [
            'sites' => Sites::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sites.create-sites');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSitesRequest $request)
    {

        // copy folder

        function copyFolder($source, $destination) {
            // Check if source folder exists
            if (!is_dir($source)) {
                echo "Source folder doesn't exist!";
                return false;
            }

            // Check if destination folder exists, if not, create it
            if (!is_dir($destination)) {
                if (!mkdir($destination, 0777, true)) {
                    echo "Failed to create destination folder!";
                    return false;
                }
            }

            // Open the source directory
            $dir = opendir($source);

            // Loop through the files and subdirectories inside the source folder
            while (($file = readdir($dir)) !== false) {
                // Skip the current (.) and parent (..) directories
                if ($file == '.' || $file == '..') {
                    continue;
                }

                // Get full paths for source and destination
                $sourcePath = $source . DIRECTORY_SEPARATOR . $file;
                $destinationPath = $destination . DIRECTORY_SEPARATOR . $file;

                // If it's a directory, call the function recursively
                if (is_dir($sourcePath)) {
                    copyFolder($sourcePath, $destinationPath); // Recursively copy subdirectories
                } else {
                    copy($sourcePath, $destinationPath); // Copy the file
                }
            }

            // Close the source directory
            closedir($dir);

            echo "Folder copied successfully!";
            return true;
        }

        $slug = Stringer::generateSlug($request->name);

        copyFolder('template', 'websites/'.$slug);

        Sites::create(['name' => $request->name,'users_id' => Auth::user()->id,'folder_name' => $slug]);

        return back()->with('success', 'Sites Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sites $sites, $sitesId)
    {
        return view('sites.show-sites', [
            'item' => Sites::where('id', $sitesId)->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sites $sites, $sitesId)
    {
        return view('sites.edit-sites', [
            'item' => Sites::where('id', $sitesId)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSitesRequest $request, Sites $sites, $sitesId)
    {
        Sites::where('id', $sitesId)->update(['name' => $request->name,'users_id' => Auth::user()->id,'folder_name' => Stringer::generateSlug($request->name)]);

        return back()->with('success', 'Sites Updated Successfully!');
    }

    /**
     * Show the form for deleting the specified resource.
     */
    public function delete(Sites $sites, $sitesId)
    {
        return view('sites.delete-sites', [
            'item' => Sites::where('id', $sitesId)->first()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sites $sites, $sitesId)
    {

        function deleteFolder($folderPath) {
            // Check if the folder exists
            if (!is_dir($folderPath)) {
                echo "The directory does not exist.";
                return;
            }

            // Open the directory
            $files = array_diff(scandir($folderPath), array('.', '..')); // Ignore . and .. entries

            // Loop through the contents
            foreach ($files as $file) {
                $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;

                // If it's a directory, recursively call the function
                if (is_dir($filePath)) {
                    deleteFolder($filePath);
                } else {
                    // If it's a file, delete it
                    unlink($filePath);
                }
            }

            // Remove the empty folder
            rmdir($folderPath);
            echo "Folder and its contents have been deleted.";
        }

        deleteFolder('websites/'.Sites::where('id', $sitesId)->value('folder_name'));

        Sites::where('id', $sitesId)->delete();

        return redirect('/sites');
    }
}
