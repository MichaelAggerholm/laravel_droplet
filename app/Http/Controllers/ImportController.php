<?php

namespace App\Http\Controllers;

use App\Imports\BooksImport;
use App\Models\Book;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function importForm()
    {
        // go to to import page
        return view('books.import');
    }

    public function import(Request $request)
    {
        // Check if file exists.
        if ($request->hasFile('importFile')) {
            // Check if file is valid
            if ($request->file('importFile')->isValid()) {
                // Try importing the file from user input with Laravel Excel::import
                // Then insert as new books in the Booksimport importer class.
                try {
                    Excel::import(new BooksImport, $request->importFile);

                    // After that, redirect to books page with success message
                    return redirect('/books')->with('success', 'Your file is imported successfully in database.');

                    // Otherwise catch exceptions and var_dump them suckers.
                } catch (\Illuminate\Database\QueryException $e) {
                    var_dump($e->errorInfo);
                }
            }
        }
    }
}
