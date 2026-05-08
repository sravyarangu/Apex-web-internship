# MySQL Database Implementation

## Database Schema

### contact_messages Table
```sql
CREATE TABLE contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message LONGTEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE,
    replied BOOLEAN DEFAULT FALSE,
    reply_message LONGTEXT NULL,
    replied_at TIMESTAMP NULL
);
```

**Fields:**
- `id`: Unique identifier, auto-incrementing
- `name`: Contact person's name (up to 100 characters)
- `email`: Email address for follow-up
- `subject`: Message subject line
- `message`: Full message content
- `created_at`: Timestamp of submission
- `is_read`: Track if message has been read
- `replied`: Whether admin replied
- `reply_message`: Admin's response
- `replied_at`: When reply was sent

### projects Table
- Stores portfolio projects
- Contains title, description, technologies, URLs
- Tracks active/inactive projects

### skills Table
- Stores skill categories and names
- Proficiency levels (Beginner to Expert)
- Display order for sorting

## Data Types
- INT: Numeric IDs and counts
- VARCHAR(n): Short text (names, emails, subjects)
- LONGTEXT: Long content (messages, descriptions)
- BOOLEAN: True/False flags
- TIMESTAMP: Date/time tracking

## Keys & Relationships
- PRIMARY KEY: Uniquely identifies each record
- AUTO_INCREMENT: Automatic ID generation
- Indexes: idx_email, idx_created_at for query performance
- Foreign keys: Can be added for relationships

## CRUD Operations

### CREATE (INSERT)
```php
INSERT INTO contact_messages (name, email, subject, message, created_at)
VALUES (?, ?, ?, ?, ?)
```

### READ (SELECT)
```sql
SELECT * FROM contact_messages WHERE is_read = FALSE
SELECT * FROM contact_messages WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
```

### UPDATE
```sql
UPDATE contact_messages SET is_read = TRUE WHERE id = ?
UPDATE contact_messages SET replied = TRUE, reply_message = ? WHERE id = ?
```

### DELETE
```sql
DELETE FROM contact_messages WHERE id = ?
```

## Advanced Queries

### Group By & Counting
```sql
SELECT category, COUNT(*) FROM skills GROUP BY category
SELECT email, COUNT(*) FROM contact_messages GROUP BY email
```

### Joins (for future enhancements)
```sql
SELECT u.name, COUNT(c.id) FROM users u 
LEFT JOIN contact_messages c ON u.id = c.user_id
GROUP BY u.id
```

### Time-based Queries
```sql
SELECT * FROM contact_messages WHERE YEAR(created_at) = 2026
SELECT * FROM contact_messages WHERE MONTH(created_at) = 5
```

## Indexes
- `idx_email`: Speed up searches by email
- `idx_created_at`: Speed up date-based queries
- Improves search performance on large datasets

## Best Practices
- Use TIMESTAMP for automatic timezone handling
- Normalize data (separate tables for different entities)
- Use VARCHAR(n) for bounded text, LONGTEXT for unbounded
- Add indexes on frequently searched columns
- Use AUTO_INCREMENT for primary keys
- Default values for commonly used data

## Backup & Restoration
```bash
# Export (Backup)
mysqldump -u root -p portfolio_db > backup.sql

# Import (Restore)
mysql -u root -p portfolio_db < backup.sql
```
