-- Create 'users' table: Users with optional address information
CREATE TABLE users (
    id SERIAL PRIMARY KEY,                         -- Auto-increment integer identifier
    username VARCHAR(50) UNIQUE NOT NULL,          -- Username (unique)
    email VARCHAR(100) UNIQUE NOT NULL,            -- Email address (unique)
    password_hash VARCHAR(255) NOT NULL,           -- Password hash
    address_line VARCHAR(255),                       -- Optional: Address line
    city VARCHAR(100),                             -- Optional: City
    state VARCHAR(100),                            -- Optional: State/Province
    postal_code VARCHAR(20),                       -- Optional: Postal code
    country VARCHAR(100),                          -- Optional: Country
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Record creation timestamp
);

-- Create 'categories' table: Categories for data normalization
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,                         -- Auto-increment integer identifier
    name VARCHAR(100) UNIQUE NOT NULL,             -- Category name (unique)
    description TEXT,                              -- Optional: Category description
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Record creation timestamp
);

-- Create 'genres' table: Genres for data normalization
CREATE TABLE genres (
    id SERIAL PRIMARY KEY,                         -- Auto-increment integer identifier
    name VARCHAR(100) UNIQUE NOT NULL,             -- Genre name (unique)
    description TEXT,                              -- Optional: Genre description
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Record creation timestamp
);

-- Create 'books' table: Books (only paper books)
CREATE TABLE books (
    id SERIAL PRIMARY KEY,                         -- Auto-increment integer identifier
    title VARCHAR(255) NOT NULL,                   -- Book title
    author VARCHAR(255) NOT NULL,                  -- Book author
    description TEXT,                              -- Book description
    price NUMERIC(10,2) NOT NULL,                  -- Book price
    quantity INTEGER NOT NULL DEFAULT 0,           -- Stock quantity
    pages_count INTEGER,                           -- Number of pages
    release_year INTEGER,                          -- Year of publication
    language VARCHAR(50),                          -- Book language
    format VARCHAR(50),                            -- Format (e.g. paperback)
    publisher VARCHAR(100),                        -- Publisher name
    isbn VARCHAR(20) UNIQUE,                       -- ISBN (unique)
    edition VARCHAR(50),                           -- Edition information
    dimensions VARCHAR(100),                       -- Book dimensions (e.g. "20x13x3 cm")
    weight NUMERIC(10,2),                          -- Book weight (e.g. in grams)
    cover_url TEXT,                                -- URL for the book cover image
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Record creation timestamp
);

-- Create 'book_categories' table: Pivot table for many-to-many relationship between books and categories
CREATE TABLE book_categories (
    id SERIAL PRIMARY KEY,                         -- Auto-increment integer identifier
    book_id INTEGER NOT NULL REFERENCES books(id) ON DELETE CASCADE,         -- Foreign key referencing books
    category_id INTEGER NOT NULL REFERENCES categories(id) ON DELETE CASCADE, -- Foreign key referencing categories
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,                         -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP                          -- Record creation timestamp
);

-- Create 'book_genres' table: Pivot table for many-to-many relationship between books and genres
CREATE TABLE book_genres (
    id SERIAL PRIMARY KEY,                         -- Auto-increment integer identifier
    book_id INTEGER NOT NULL REFERENCES books(id) ON DELETE CASCADE,         -- Foreign key referencing books
    genre_id INTEGER NOT NULL REFERENCES genres(id) ON DELETE CASCADE,       -- Foreign key referencing genres
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,                         -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP                          -- Record creation timestamp
);

-- Create 'orders' table: Orders
CREATE TABLE orders (
    id SERIAL PRIMARY KEY,                         -- Auto-increment integer identifier
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,    -- Foreign key referencing users
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,                    -- Order date timestamp
    total_amount NUMERIC(10,2) NOT NULL,                                -- Total order amount
    status VARCHAR(50) DEFAULT 'New',                                   -- Order status (e.g. New, Processing, Completed)
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,                    -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP                     -- Record creation timestamp
);

-- Create 'order_items' table: Order items (pivot table between orders and books)
CREATE TABLE order_items (
    id SERIAL PRIMARY KEY,                         -- Auto-increment integer identifier
    order_id INTEGER NOT NULL REFERENCES orders(id) ON DELETE CASCADE,  -- Foreign key referencing orders
    book_id INTEGER NOT NULL REFERENCES books(id) ON DELETE CASCADE,    -- Foreign key referencing books
    quantity INTEGER NOT NULL,                                        -- Quantity of the book in the order
    price NUMERIC(10,2) NOT NULL,                                     -- Book price at the time of order
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,                   -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP                    -- Record creation timestamp
);
