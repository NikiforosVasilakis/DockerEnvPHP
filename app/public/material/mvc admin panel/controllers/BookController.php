<?php

namespace controllers;

use attributes\Route;

class BookController extends BaseController {
    public const VIEWS = [
        'list' => ['view' => 'books/list', 'title' => 'Books'],
        'add' => ['view' => 'books/add', 'title' => 'Add Book'],
        'details' => ['view' => 'books/details', 'title' => 'Book Details'],
    ];

    #[Route('/books')]
    public function list(): void {
        $allBooks = [
            ['id' => 1, 'title' => '1984', 'author' => 'George Orwell'],
            ['id' => 2, 'title' => 'Brave New World', 'author' => 'Aldous Huxley'],
            ['id' => 3, 'title' => 'Fahrenheit 451', 'author' => 'Ray Bradbury'],
            ['id' => 4, 'title' => 'Animal Farm', 'author' => 'George Orwell'],
            ['id' => 5, 'title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee'],
            ['id' => 6, 'title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald'],
            ['id' => 7, 'title' => 'Moby Dick', 'author' => 'Herman Melville'],
            ['id' => 8, 'title' => 'Pride and Prejudice', 'author' => 'Jane Austen'],
            ['id' => 9, 'title' => 'War and Peace', 'author' => 'Leo Tolstoy'],
            ['id' => 10, 'title' => 'The Catcher in the Rye', 'author' => 'J.D. Salinger'],
        ];

        $itemsPerPage = 5;
        $totalBooks = count($allBooks);
        $totalPages = ceil($totalBooks / $itemsPerPage);

        // Ensure $currentPage is an integer
        $currentPage = isset($_GET['page']) ? max(1, min((int)$_GET['page'], $totalPages)) : 1;

        $offset = ($currentPage - 1) * $itemsPerPage;

        $books = array_slice($allBooks, $offset, $itemsPerPage);

        $this->render(
            self::VIEWS['list'],
            compact('books', 'currentPage', 'totalPages', 'totalBooks', 'itemsPerPage')
        );
    }

    #[Route('/books/add')]
    public function add(): void {
        $this->render(self::VIEWS['add']);
    }

    #[Route('/books/details')]
    public function details(): void {
        // Simulate a database of books
        $allBooks = [
            1 => ['title' => '1984', 'author' => 'George Orwell', 'description' => 'A dystopian social science fiction novel and cautionary tale about the dangers of totalitarianism.'],
            2 => ['title' => 'Brave New World', 'author' => 'Aldous Huxley', 'description' => 'A dystopian novel set in a futuristic World State, revolving around science and technology.'],
            3 => ['title' => 'Fahrenheit 451', 'author' => 'Ray Bradbury', 'description' => 'A dystopian novel about a society where books are banned and "firemen" burn any that are found.'],
            4 => ['title' => 'Animal Farm', 'author' => 'George Orwell', 'description' => 'A satirical allegorical novella criticizing totalitarian regimes.'],
            5 => ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'description' => 'A story of racial injustice in the Deep South.'],
            // Add more books as needed
        ];

        // Get the book ID from the query string
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        // Check if the book exists
        if (!$id || !isset($allBooks[$id])) {
            http_response_code(404);
            $this->render(['view' => 'errors/404', 'title' => 'Book Not Found']);
            return;
        }

        // Load the book details
        $book = $allBooks[$id];

        $this->render(self::VIEWS['details'], compact('book'));
    }
}
