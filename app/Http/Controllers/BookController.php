<?php

namespace App\Http\Controllers;

use App\Imports\BooksImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = DB::select('select * from books');
        return view('books.index',['books'=>$books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplierId' => 'required',
            'title' => 'required',
            'author' => 'required',
            'format' => 'required',
            'price' => 'required',
        ]);

        Product::create($request->all());

        return redirect()->route('books.index')
            ->with('success','Book created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('books.show',compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('books.edit',compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Book $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'supplierId' => 'required',
            'title' => 'required',
            'author' => 'required',
            'format' => 'required',
            'price' => 'required',
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')
            ->with('success','Book updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success','Book deleted successfully');
    }

    public function importForm()
    {
        return view('books.import');
    }

    public function import(Request $request)
    {
        if ($request->hasFile('importFile')) {
            if ($request->file('importFile')->isValid()) {
                try {
                    Excel::import(new BooksImport, $request->importFile);

                    return redirect('/')->with('success', 'Your file is imported successfully in database.');

                } catch (\Illuminate\Database\QueryException $e) {
                    var_dump($e->errorInfo);
                }
            }
        }
    }
}
