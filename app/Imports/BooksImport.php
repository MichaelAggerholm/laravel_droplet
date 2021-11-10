<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Book([
            'supplierId'    => 'booklist' . $row['id'],
            'title'         => $row['title'],
            'author'        => $row['author'],
            'format'        => $row['format'],
            'price'         => $row['price'],
        ]);
    }
}
