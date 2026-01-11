<?php

namespace models;

/**
 * BookModel
 * Represents a book with controlled property access through getters and setters.
 */
class BookModel {
    // Properties with private access for encapsulation
    private readonly int $id;
    private readonly string $title;
    private string $author;
    private int $year;
    private string $genre;
    private float $price;

    /**
     * Constructor using Property Promotion (PHP 8.0+)
     */
    public function __construct(
        int $id,
        string $title,
        string $author,
        int $year,
        string $genre,
        float $price
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
        $this->genre = $genre;
        $this->price = $price;
    }

    // Getters and Setters

    /**
     * Get the book's ID.
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Get the book's title.
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * Get the book's author.
     */
    public function getAuthor(): string {
        return $this->author;
    }

    /**
     * Set the book's author.
     */
    public function setAuthor(string $author): void {
        $this->author = $author;
    }

    /**
     * Get the year of publication.
     */
    public function getYear(): int {
        return $this->year;
    }

    /**
     * Set the year of publication.
     */
    public function setYear(int $year): void {
        if ($year < 1000 || $year > (int) date('Y')) {
            throw new \InvalidArgumentException("Year must be between 1000 and the current year.");
        }
        $this->year = $year;
    }

    /**
     * Get the book's genre.
     */
    public function getGenre(): string {
        return $this->genre;
    }

    /**
     * Set the book's genre.
     */
    public function setGenre(string $genre): void {
        $this->genre = $genre;
    }

    /**
     * Get the book's price.
     */
    public function getPrice(): float {
        return $this->price;
    }

    /**
     * Set the book's price.
     */
    public function setPrice(float $price): void {
        if ($price < 0) {
            throw new \InvalidArgumentException("Price must be a non-negative value.");
        }
        $this->price = $price;
    }

    // Utility Methods

    /**
     * Get book details as a formatted string.
     */
    public function getDetails(): string {
        return sprintf(
            "Book ID: %d, Title: %s, Author: %s, Year: %d, Genre: %s, Price: $%.2f",
            $this->id,
            $this->title,
            $this->author,
            $this->year,
            $this->genre,
            $this->price
        );
    }

    /**
     * Get book details as an associative array.
     */
    public function toArray(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'year' => $this->year,
            'genre' => $this->genre,
            'price' => $this->price,
        ];
    }
}
