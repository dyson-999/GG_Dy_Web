# API Documentation

This document describes the API endpoints and data structures for GGDy Gaming Store.

## Base URL
```
http://localhost/GGDyWeb/
```

## Authentication

Most API endpoints require authentication. Include the session cookie in your requests.

### Login
```http
POST /auth/login.php
Content-Type: application/x-www-form-urlencoded

username=your_username&password=your_password
```

### Logout
```http
GET /auth/logout.php
```

## Products API

### Get All Products
```http
GET /api/products.php
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Gaming Mouse",
      "description": "High-performance gaming mouse",
      "price": "59.99",
      "category": "Accessories",
      "image_url": "images/mouse.jpg",
      "stock": 10,
      "created_at": "2025-01-01 12:00:00"
    }
  ]
}
```

### Get Product by ID
```http
GET /api/products.php?id=1
```

### Search Products
```http
GET /api/products.php?search=gaming
```

### Get Products by Category
```http
GET /api/products.php?category=Accessories
```

### Add Product (Admin Only)
```http
POST /api/products.php
Content-Type: application/x-www-form-urlencoded

name=New Product&description=Product description&price=99.99&category=Gaming&image_url=images/new.jpg&stock=5
```

### Update Product (Admin Only)
```http
PUT /api/products.php?id=1
Content-Type: application/x-www-form-urlencoded

name=Updated Product&description=Updated description&price=89.99&category=Gaming&image_url=images/updated.jpg&stock=8
```

### Delete Product (Admin Only)
```http
DELETE /api/products.php?id=1
```

## Users API

### Get All Users (Admin Only)
```http
GET /api/users.php
```

### Get User by ID
```http
GET /api/users.php?id=1
```

### Create User
```http
POST /api/users.php
Content-Type: application/x-www-form-urlencoded

username=newuser&email=user@example.com&password=securepassword&role=customer
```

### Update User
```http
PUT /api/users.php?id=1
Content-Type: application/x-www-form-urlencoded

username=updateduser&email=updated@example.com&role=customer
```

### Delete User (Admin Only)
```http
DELETE /api/users.php?id=1
```

## Cart API

### Get User Cart
```http
GET /api/cart.php
```

### Add Item to Cart
```http
POST /api/cart.php
Content-Type: application/x-www-form-urlencoded

product_id=1&quantity=2
```

### Update Cart Item
```http
PUT /api/cart.php
Content-Type: application/x-www-form-urlencoded

product_id=1&quantity=3
```

### Remove Item from Cart
```http
DELETE /api/cart.php?product_id=1
```

### Clear Cart
```http
DELETE /api/cart.php?clear=all
```

## Orders API

### Get User Orders
```http
GET /api/orders.php
```

### Get All Orders (Admin Only)
```http
GET /api/orders.php?admin=1
```

### Create Order
```http
POST /api/orders.php
Content-Type: application/x-www-form-urlencoded

items=[{"product_id":1,"quantity":2,"price":"59.99"}]
```

### Update Order Status (Admin Only)
```http
PUT /api/orders.php?id=1
Content-Type: application/x-www-form-urlencoded

status=completed
```

## FAQs API

### Get All FAQs
```http
GET /api/faqs.php
```

### Get FAQs by Category
```http
GET /api/faqs.php?category=Payment
```

### Add FAQ (Admin Only)
```http
POST /api/faqs.php
Content-Type: application/x-www-form-urlencoded

question=What payment methods do you accept?&answer=We accept credit cards and PayPal.&category=Payment
```

### Update FAQ (Admin Only)
```http
PUT /api/faqs.php?id=1
Content-Type: application/x-www-form-urlencoded

question=Updated question&answer=Updated answer&category=Payment
```

### Delete FAQ (Admin Only)
```http
DELETE /api/faqs.php?id=1
```

## Error Responses

All API endpoints return consistent error responses:

```json
{
  "success": false,
  "error": "Error message",
  "code": 400
}
```

### Common Error Codes
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `500` - Internal Server Error

## Rate Limiting

API requests are limited to:
- 100 requests per minute per IP
- 1000 requests per hour per user

## Data Models

### Product
```json
{
  "id": 1,
  "name": "string",
  "description": "string",
  "price": "decimal",
  "category": "string",
  "image_url": "string",
  "stock": "integer",
  "created_at": "datetime"
}
```

### User
```json
{
  "id": 1,
  "username": "string",
  "email": "string",
  "role": "enum(admin,user,customer,webmaster)",
  "created_at": "datetime"
}
```

### Order
```json
{
  "id": 1,
  "user_id": 1,
  "total_amount": "decimal",
  "status": "enum(pending,completed,cancelled)",
  "created_at": "datetime",
  "items": [
    {
      "product_id": 1,
      "quantity": 2,
      "price": "59.99"
    }
  ]
}
```

### Cart Item
```json
{
  "id": 1,
  "user_id": 1,
  "product_id": 1,
  "quantity": 2,
  "created_at": "datetime"
}
```

### FAQ
```json
{
  "id": 1,
  "question": "string",
  "answer": "string",
  "category": "string",
  "created_at": "datetime"
}
```

## SDK Examples

### JavaScript
```javascript
// Get all products
fetch('/api/products.php')
  .then(response => response.json())
  .then(data => console.log(data));

// Add to cart
fetch('/api/cart.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
  },
  body: 'product_id=1&quantity=2'
})
.then(response => response.json())
.then(data => console.log(data));
```

### PHP
```php
// Get products
$response = file_get_contents('http://localhost/GGDyWeb/api/products.php');
$data = json_decode($response, true);

// Add to cart
$postData = http_build_query([
    'product_id' => 1,
    'quantity' => 2
]);

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => $postData
    ]
]);

$response = file_get_contents('http://localhost/GGDyWeb/api/cart.php', false, $context);
$data = json_decode($response, true);
```

### Python
```python
import requests

# Get products
response = requests.get('http://localhost/GGDyWeb/api/products.php')
data = response.json()

# Add to cart
data = {'product_id': 1, 'quantity': 2}
response = requests.post('http://localhost/GGDyWeb/api/cart.php', data=data)
result = response.json()
```

## Webhooks

### Order Created
```http
POST /webhooks/order-created
Content-Type: application/json

{
  "order_id": 1,
  "user_id": 1,
  "total_amount": "119.98",
  "items": [...]
}
```

### Order Status Changed
```http
POST /webhooks/order-status-changed
Content-Type: application/json

{
  "order_id": 1,
  "old_status": "pending",
  "new_status": "completed"
}
```

## Testing

### Test Endpoints
```bash
# Test product API
curl -X GET http://localhost/GGDyWeb/api/products.php

# Test cart API
curl -X POST http://localhost/GGDyWeb/api/cart.php \
  -d "product_id=1&quantity=2"

# Test authentication
curl -X POST http://localhost/GGDyWeb/auth/login.php \
  -d "username=webmaster&password=password"
```

## Changelog

### v1.0.0
- Initial API release
- Basic CRUD operations for all entities
- Authentication system
- Cart management
- Order processing
