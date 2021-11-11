<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class BooksImport implements ToModel, WithHeadingRow, WithBatchInserts, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row) // Expects a row of inputs
    {
        // Maps the rows from the csv / exsl to the database table
        return new Book([
            'supplierId'    => 'booklist' . $row['id'],
            'title'         => $row['title'],
            'author'        => $row['author'],
            'format'        => $row['format'],
            'price'         => $row['price'],
        ]);
    }

    // Reads in batches and inserts each completed 1000 books, like a SAX parser could.
    public function batchSize(): int
    {
        return 1000;
    }

    // If the unique supplierId already exists, the book will instead update.
    public function uniqueBy()
    {
        return 'supplierId';
    }
}
