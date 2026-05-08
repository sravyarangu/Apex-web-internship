# API Documentation

## Contact Form Submission API

### Endpoint
- **URL**: `/php/contact.php`
- **Method**: `POST`
- **Content-Type**: `application/x-www-form-urlencoded` or `multipart/form-data`

### Request Parameters

| Parameter | Type | Required | Validation |
|-----------|------|----------|-----------|
| `name` | string | Yes | Min 2 characters |
| `email` | string | Yes | Valid email format |
| `subject` | string | Yes | Min 5 characters |
| `message` | string | Yes | Min 10 characters |

### Request Example

```javascript
const formData = new FormData();
formData.append('name', 'John Doe');
formData.append('email', 'john@example.com');
formData.append('subject', 'Portfolio Inquiry');
formData.append('message', 'I am interested in your services.');

fetch('php/contact.php', {
    method: 'POST',
    body: formData
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

### Success Response (200 OK)

```json
{
    "success": true,
    "message": "Message sent successfully!",
    "message_id": 123
}
```

### Error Response (400 Bad Request)

```json
{
    "success": false,
    "message": "Valid email address is required."
}
```

### Error Responses

| Status | Message |
|--------|---------|
| 405 | Invalid request method. POST required. |
| 400 | Name is required and must be at least 2 characters. |
| 400 | Valid email address is required. |
| 400 | Subject is required and must be at least 5 characters. |
| 400 | Message is required and must be at least 10 characters. |
| 500 | Database connection failed. Please try again later. |
| 500 | Error saving message. Please try again. |

---

## Get Projects API

### Endpoint
- **URL**: `/php/get_projects.php`
- **Method**: `GET`
- **Response Type**: `application/json`

### Response Example

```json
{
    "success": true,
    "count": 3,
    "projects": [
        {
            "id": 1,
            "title": "Personal Portfolio Website",
            "description": "Fully responsive portfolio...",
            "technologies": "HTML5, CSS3, JavaScript, PHP, MySQL",
            "project_url": "https://github.com/username/portfolio",
            "github_url": "https://github.com/username/portfolio",
            "image_url": "assets/portfolio-project.jpg",
            "created_at": "2026-05-08 10:30:00"
        }
    ]
}
```

---

## Database Schema API

### contact_messages Table

**Read (GET all messages)**
```sql
SELECT * FROM contact_messages ORDER BY created_at DESC;
```

**Create (POST new message)**
```sql
INSERT INTO contact_messages (name, email, subject, message, created_at)
VALUES (?, ?, ?, ?, NOW());
```

**Update (Mark as read)**
```sql
UPDATE contact_messages SET is_read = TRUE WHERE id = ?;
```

**Delete (Remove message)**
```sql
DELETE FROM contact_messages WHERE id = ?;
```

---

## Authentication (Future Feature)

### Login
- **URL**: `/php/login.php`
- **Method**: `POST`
- **Parameters**: `username`, `password`

### Session Management
```php
session_start();
$_SESSION['user_id'] = $userId;
$_SESSION['username'] = $username;
```

---

## Error Handling

### HTTP Status Codes
- `200 OK` - Success
- `400 Bad Request` - Validation failure
- `405 Method Not Allowed` - Wrong HTTP method
- `500 Internal Server Error` - Database or server error

### Error Response Format
```json
{
    "success": false,
    "message": "Human-readable error message"
}
```

---

## Rate Limiting (Future Feature)

To prevent spam:
- Max 5 messages per IP per hour
- Check IP address: `$_SERVER['REMOTE_ADDR']`
- Store attempts in cache or session

---

## CORS Headers

```php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
```

---

## Best Practices

1. **Always validate input** on both client and server
2. **Sanitize data** to prevent SQL injection and XSS
3. **Use prepared statements** for database queries
4. **Return JSON** for consistent API responses
5. **Log errors** for debugging
6. **Send appropriate HTTP status codes**
7. **Add rate limiting** to prevent spam
8. **Use HTTPS** in production
9. **Implement CORS** carefully
10. **Document API** thoroughly
