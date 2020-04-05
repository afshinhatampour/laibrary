<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Book;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_book_can_be_added_to_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Victor'
        ]);

        $response->assertOk();

        $this->assertCount(1, Book::all());
    }

    public function test_a_title_is_require()
    {
        //$this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'victor'
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_a_author_is_require()
    {
        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    public function test_a_book_can_be_updated()
    {
        //$this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Victor'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id , [
            'title' => 'new author',
            'author' => 'new title'
        ]);

        $this->assertEquals('new author', Book::first()->title);
        $this->assertEquals('new title', Book::first()->author);
    }
}
