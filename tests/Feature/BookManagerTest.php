<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookManagerTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function add_book_to_library(){

        $this->withoutExceptionHandling();
        $response = $this->post('/books',[
            'title' => 'Cool Title',
            'author' => 'Author Name'
        ]);

        $book = Book::first();

        $this->assertCount(1,Book::all());
        $response->assertRedirect('/books/'.$book->id);
    }

    /** @test */
    public function a_title_is_required(){

//        $this->withoutExceptionHandling();
        $response = $this->post('/books',[
            'title' => '',
            'author' => 'Author Name'
        ]);

        $response->assertSessionHasErrors('title');

    }

    /** @test */
    public function a_author_is_required(){
//        $this->withoutExceptionHandling();
        $response = $this->post('/books',[
            'title' => 'Cool Title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_updated(){
//        $this->withoutExceptionHandling();
        $response = $this->post('/books',[
            'title' => 'Cool Title',
            'author' => 'Author Name'
        ]);

        $book = Book::first();

        $this->patch('/books/'.$book->id,[
            'title' => 'New Title',
            'author' => 'Author Name'
        ]);

        $this->assertEquals('New Title',Book::first()->title);
        $response->assertRedirect('/books/'.$book->id);

    }

    /** @test */
    public function a_book_can_deleted(){
        $this->withoutExceptionHandling();
        $this->withoutExceptionHandling();
        $response = $this->post('/books',[
            'title' => 'Cool Title',
            'author' => 'Author Name'
        ]);

        $book = Book::first();
        $this->assertCount(1,Book::all());

       $response = $this->delete('/books/'.$book->id);
       $this->assertCount(0,Book::all());
       $response->assertRedirect('/books');
    }

}
