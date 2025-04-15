-- Roles table: stores available roles (e.g. admin, customer)
CREATE TABLE roles (
    id SERIAL PRIMARY KEY,                         -- Auto-increment primary key
    name VARCHAR(50) NOT NULL,                      -- Role name
    description TEXT,                               -- Optional role description
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Record creation timestamp
);

-- Users table: stores registered users (guests may not have an entry here)
CREATE TABLE users (
    id SERIAL PRIMARY KEY,                         -- Auto-increment primary key
    username VARCHAR(50) UNIQUE NOT NULL,           -- Unique username
    email VARCHAR(100) UNIQUE NOT NULL,             -- Unique email address
    password_hash VARCHAR(255) NOT NULL,            -- Password hash
    address_line VARCHAR(255),                      -- Optional address line
    city VARCHAR(100),                              -- Optional city
    state VARCHAR(100),                             -- Optional state/province
    postal_code VARCHAR(20),                        -- Optional postal code
    country VARCHAR(100),                           -- Optional country
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Record creation timestamp
);

-- Pivot table for many-to-many relationship between users and roles
CREATE TABLE role_user (
    role_id INTEGER NOT NULL REFERENCES roles(id) ON DELETE CASCADE, -- Foreign key to roles
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,   -- Foreign key to users
    PRIMARY KEY (role_id, user_id)
);

-- Categories table: used for product categorization
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,                         -- Auto-increment primary key
    name VARCHAR(100) UNIQUE NOT NULL,              -- Unique category name
    description TEXT,                               -- Optional description
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Record creation timestamp
);

-- Genres table: used for additional product classification
CREATE TABLE genres (
    id SERIAL PRIMARY KEY,                         -- Auto-increment primary key
    name VARCHAR(100) UNIQUE NOT NULL,              -- Unique genre name
    description TEXT,                               -- Optional description
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Record creation timestamp
);

-- Books table: stores products (books) with essential attributes
CREATE TABLE books (
    id SERIAL PRIMARY KEY,                          -- Auto-increment primary key
    title VARCHAR(255) NOT NULL,                    -- Book title
    author VARCHAR(255) NOT NULL,                   -- Book author
    description TEXT,                               -- Book description
    price NUMERIC(10,2) NOT NULL,                   -- Book price
    quantity INTEGER NOT NULL DEFAULT 0,            -- Stock quantity
    pages_count INTEGER,                            -- Number of pages
    release_year INTEGER,                           -- Year of publication
    language VARCHAR(50),                           -- Book language
    format VARCHAR(50),                             -- Format (e.g. paperback)
    publisher VARCHAR(100),                         -- Publisher name (can be used as 'brand')
    isbn VARCHAR(20) UNIQUE,                        -- Unique ISBN
    edition VARCHAR(50),                            -- Edition information
    dimensions VARCHAR(100),                        -- Book dimensions (e.g. "20x13x3 cm")
    weight NUMERIC(10,2),                           -- Book weight (e.g. in grams)
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Record creation timestamp
);

-- Book images table: stores multiple photos for each book (at least two required by business logic)
CREATE TABLE book_images (
    id SERIAL PRIMARY KEY,                         -- Auto-increment primary key
    book_id INTEGER NOT NULL REFERENCES books(id) ON DELETE CASCADE, -- Foreign key referencing books
    image_url TEXT NOT NULL,                        -- URL for the book image
    sort_order INTEGER DEFAULT 0,                   -- Optional ordering of images
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Record creation timestamp
);

-- Pivot table for many-to-many relationship between books and categories
CREATE TABLE book_categories (
    id SERIAL PRIMARY KEY,                          -- Auto-increment primary key
    book_id INTEGER NOT NULL REFERENCES books(id) ON DELETE CASCADE,       -- Foreign key to books
    category_id INTEGER NOT NULL REFERENCES categories(id) ON DELETE CASCADE, -- Foreign key to categories
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP   -- Record creation timestamp
);

-- Pivot table for many-to-many relationship between books and genres
CREATE TABLE book_genres (
    id SERIAL PRIMARY KEY,                          -- Auto-increment primary key
    book_id INTEGER NOT NULL REFERENCES books(id) ON DELETE CASCADE, -- Foreign key to books
    genre_id INTEGER NOT NULL REFERENCES genres(id) ON DELETE CASCADE, -- Foreign key to genres
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP   -- Record creation timestamp
);

-- Orders table: stores orders and supports both registered users and guests
CREATE TABLE orders (
    id SERIAL PRIMARY KEY,                         -- Auto-increment primary key
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE, -- Nullable foreign key; null for guest orders
    guest_email VARCHAR(100),                       -- Email for guest orders
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Order date and time
    total_amount NUMERIC(10,2) NOT NULL,            -- Total order amount
    status VARCHAR(50) DEFAULT 'New',               -- Order status (e.g. New, Processing, Completed)
    shipping_name VARCHAR(255),                     -- Recipient's name for shipping
    shipping_address VARCHAR(255),                  -- Shipping address
    shipping_city VARCHAR(100),                     -- City
    shipping_state VARCHAR(100),                    -- State/Province
    shipping_postal_code VARCHAR(20),               -- Postal code
    shipping_country VARCHAR(100),                  -- Country
    shipping_method VARCHAR(100),                   -- Selected shipping method
    payment_method VARCHAR(100),                    -- Selected payment method
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Record creation timestamp
);

-- Order items table: stores individual items within an order
CREATE TABLE order_items (
    id SERIAL PRIMARY KEY,                         -- Auto-increment primary key
    order_id INTEGER NOT NULL REFERENCES orders(id) ON DELETE CASCADE,  -- Foreign key to orders
    book_id INTEGER NOT NULL REFERENCES books(id) ON DELETE CASCADE,    -- Foreign key to books
    quantity INTEGER NOT NULL,                      -- Quantity of the book in the order
    price NUMERIC(10,2) NOT NULL,                   -- Price at the time of order
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Record update timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Record creation timestamp
);
