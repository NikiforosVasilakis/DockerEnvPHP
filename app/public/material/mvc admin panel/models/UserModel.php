<?php

namespace models;

/**
 * UserModel
 * Represents a user in the system with controlled property access.
 */
class UserModel {
    // Readonly properties (immutable after initialization)
    private readonly int $id;         // Unique identifier for the user
    private readonly string $email;  // User's email address

    // Mutable properties
    private string $name;            // User's full name
    private string $role;            // Role of the user (e.g., admin, editor, user)
    private bool $isActive;          // Whether the user is active
    private \DateTimeImmutable $createdAt; // Account creation date

    /**
     * Constructor with property promotion and initialization
     *
     * @param int $id Unique identifier for the user
     * @param string $name Full name of the user
     * @param string $email Email address of the user
     * @param string $role Role of the user (e.g., admin, editor)
     * @param bool $isActive Whether the user is active
     * @param \DateTimeImmutable $createdAt Account creation timestamp
     */
    public function __construct(
        int $id,
        string $name,
        string $email,
        string $role,
        bool $isActive,
        \DateTimeImmutable $createdAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
        $this->isActive = $isActive;
        $this->createdAt = $createdAt;
    }

    // Getters and Setters

    /**
     * Get the user's ID.
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Get the user's email address.
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * Get the user's full name.
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Set the user's full name.
     */
    public function setName(string $name): void {
        if (empty($name)) {
            throw new \InvalidArgumentException("Name cannot be empty.");
        }
        $this->name = $name;
    }

    /**
     * Get the user's role.
     */
    public function getRole(): string {
        return $this->role;
    }

    /**
     * Set the user's role.
     */
    public function setRole(string $role): void {
        $validRoles = ['admin', 'editor', 'user'];
        if (!in_array($role, $validRoles, true)) {
            throw new \InvalidArgumentException("Invalid role. Valid roles are: " . implode(', ', $validRoles));
        }
        $this->role = $role;
    }

    /**
     * Check if the user is active.
     */
    public function isActive(): bool {
        return $this->isActive;
    }

    /**
     * Set the user's active status.
     */
    public function setActive(bool $isActive): void {
        $this->isActive = $isActive;
    }

    /**
     * Get the user's account creation timestamp.
     */
    public function getCreatedAt(): \DateTimeImmutable {
        return $this->createdAt;
    }

    // Utility Methods

    /**
     * Get user details as a formatted string.
     */
    public function getDetails(): string {
        return sprintf(
            "User ID: %d, Name: %s, Email: %s, Role: %s, Active: %s, Created At: %s",
            $this->id,
            $this->name,
            $this->email,
            $this->role,
            $this->isActive ? 'Yes' : 'No',
            $this->createdAt->format('Y-m-d H:i:s')
        );
    }

    /**
     * Get user details as an associative array.
     */
    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
    }
}
