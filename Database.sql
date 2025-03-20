-- Enable the uuid-ossp extension for UUID generation
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Users table with optional address information
CREATE TABLE users (
    id uuid PRIMARY KEY DEFAULT uuid_generate_v4(), -- UUID for user ID
    username VARCHAR(50) UNIQUE NOT NULL,           -- Username
    email VARCHAR(100) UNIQUE NOT NULL,             -- Email address
    password_hash VARCHAR(255) NOT NULL,            -- Password hash
    address_line VARCHAR(255),                      -- Optional: Address line
    city VARCHAR(100),                              -- Optional: City
    state VARCHAR(100),                             -- Optional: State/Province
    postal_code VARCHAR(20),                        -- Optional: Postal code
    country VARCHAR(100),                           -- Optional: Country
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record update date
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Record creation date
);

-- Categories table for data normalization
CREATE TABLE categories (
    id uuid PRIMARY KEY DEFAULT uuid_generate_v4(), -- UUID for category ID
    name VARCHAR(100) UNIQUE NOT NULL,              -- Category name
    description TEXT,                               -- Optional: Category description
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record update date
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Record creation date
);

-- Genres table for data normalization
CREATE TABLE genres (
    id uuid PRIMARY KEY DEFAULT uuid_generate_v4(), -- UUID for genre ID
    name VARCHAR(100) UNIQUE NOT NULL,              -- Genre name
    description TEXT,                               -- Optional: Genre description
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record update date
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Record creation date
);

-- Books table (only paper books)
CREATE TABLE books (
    id uuid PRIMARY KEY DEFAULT uuid_generate_v4(), -- UUID for book ID
    title VARCHAR(255) NOT NULL,                    -- Book title
    author VARCHAR(255) NOT NULL,                   -- Book author
    description TEXT,                               -- Book description
    price NUMERIC(10,2) NOT NULL,                   -- Book price
    quantity INTEGER NOT NULL DEFAULT 0,            -- Stock quantity
    pages_count INTEGER,                            -- Number of pages
    release_year INTEGER,                           -- Year of publication
    language VARCHAR(50),                           -- Book language
    format VARCHAR(50),                             -- Format (e.g. paperback)
    publisher VARCHAR(100),                         -- Publisher name
    isbn VARCHAR(20) UNIQUE,                        -- ISBN
    edition VARCHAR(50),                            -- Edition
    dimensions VARCHAR(100),                        -- Book dimensions (e.g. "20x13x3 cm")
    weight NUMERIC(10,2),                           -- Book weight (e.g. in grams)
    cover_url TEXT,                                 -- URL for the book cover image
    overall_rating NUMERIC(3,2),                    -- Overall rating (average from reviews)
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record update date
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Record creation date
);

-- Junction table for many-to-many relationship between books and categories
CREATE TABLE book_categories (
    id uuid PRIMARY KEY DEFAULT uuid_generate_v4(),         -- UUID for the junction table
    book_id uuid NOT NULL REFERENCES books(id) ON DELETE CASCADE,          -- Reference to books (uuid)
    category_id uuid NOT NULL REFERENCES categories(id) ON DELETE CASCADE, -- Reference to categories (uuid)
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,                        -- Record update date
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP                         -- Record creation date
);

-- Junction table for many-to-many relationship between books and genres
CREATE TABLE book_genres (
    id uuid PRIMARY KEY DEFAULT uuid_generate_v4(),         -- UUID for the junction table
    book_id uuid NOT NULL REFERENCES books(id) ON DELETE CASCADE,     -- Reference to books (uuid)
    genre_id uuid NOT NULL REFERENCES genres(id) ON DELETE CASCADE,   -- Reference to genres (uuid)
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,                   -- Record update date
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP                    -- Record creation date
);

-- Orders table
CREATE TABLE orders (
    id uuid PRIMARY KEY DEFAULT uuid_generate_v4(),         -- UUID for order ID
    user_id uuid NOT NULL REFERENCES users(id) ON DELETE CASCADE,    -- Reference to users (uuid)
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,                  -- Order date
    total_amount NUMERIC(10,2) NOT NULL,                             -- Total order amount
    status VARCHAR(50) DEFAULT 'New',                                -- Order status (e.g. New, Processing, Completed)
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,                  -- Record update date
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP                   -- Record creation date
);

-- Order items table (junction table between orders and books)
CREATE TABLE order_items (
    id uuid PRIMARY KEY DEFAULT uuid_generate_v4(),         -- UUID for order item ID
    order_id uuid NOT NULL REFERENCES orders(id) ON DELETE CASCADE,  -- Reference to orders (uuid)
    book_id uuid NOT NULL REFERENCES books(id) ON DELETE CASCADE,    -- Reference to books (uuid)
    quantity INTEGER NOT NULL,                                       -- Quantity of the book in the order
    price NUMERIC(10,2) NOT NULL,                                    -- Book price at time of order
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,                  -- Record update date
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP                   -- Record creation date
);
