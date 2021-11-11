<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class BooksImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithUpserts
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

    // Reads in batches and inserts as chunks for each 100 books, like a SAX parser would.
    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    // If the unique supplierId already exists, the book will instead update.
    public function uniqueBy()
    {
        return 'supplierId';
    }
}
