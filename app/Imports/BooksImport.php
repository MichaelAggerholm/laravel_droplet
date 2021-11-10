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

    public function batchSize(): int
    {
        return 1000;
    }

    public function uniqueBy()
    {
        return 'supplierId';
    }
}
