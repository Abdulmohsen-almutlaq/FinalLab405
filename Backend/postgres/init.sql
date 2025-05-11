
-- Database initialization for PostgreSQL
-- Creating bookmarks table
CREATE TABLE IF NOT EXISTS bookmarks (
    id SERIAL PRIMARY KEY,
    url VARCHAR(500) NOT NULL,
    title VARCHAR(200) NOT NULL,
    dateAdded TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);





