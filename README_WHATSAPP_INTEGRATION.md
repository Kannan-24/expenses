# WhatsApp Expense Integration

This Laravel application provides AI-powered expense parsing through WhatsApp integration using OpenRouter AI services.

## Features

- **AI-Powered Parsing**: Uses OpenRouter AI (Mistral 7B) to parse natural language expense messages
- **Smart Categorization**: Automatically maps expenses to existing categories, wallets, and persons
- **Auto-Creation**: Creates new categories, wallets, or persons when they don't exist
- **WhatsApp Integration**: Webhook support for WhatsApp Business API
- **Caching**: Optional caching for improved performance
- **Rate Limiting**: Built-in rate limiting for webhook endpoints
- **Comprehensive Validation**: Request validation and error handling
- **Transaction Management**: Full CRUD operations for expenses

## Installation

1. **Install Dependencies**
```bash
composer install
npm install
```

2. **Environment Configuration**
```bash
cp .env.example .env
```

Add the following environment variables:
```env
# OpenRouter AI Configuration
OPENROUTER_API_KEY=your_openrouter_api_key
OPENROUTER_URL=https://openrouter.ai/api/v1/chat/completions
OPENROUTER_MODEL=mistralai/mistral-7b-instruct
OPENROUTER_TIMEOUT=30
OPENROUTER_MAX_RETRIES=2
OPENROUTER_CACHE_MINUTES=5
OPENROUTER_ENABLE_CACHING=true
OPENROUTER_DEBUG_LOGGING=false

# WhatsApp Configuration (optional)
WHATSAPP_WEBHOOK_TOKEN=your_webhook_verification_token
WHATSAPP_API_TOKEN=your_whatsapp_api_token
WHATSAPP_API_URL=https://graph.facebook.com/v17.0
WHATSAPP_PHONE_NUMBER_ID=your_phone_number_id
```

3. **Database Migration**
```bash
php artisan migrate
```

4. **Register Service Provider**
Add to `config/app.php`:
```php
'providers' => [
    // ...
    App\Providers\WhatsAppServiceProvider::class,
],
```

## API Endpoints

### Parse Expense Message
```http
POST /api/whatsapp/parse-expense
Authorization: Bearer {token}
Content-Type: application/json

{
    "message": "Spent 500 on lunch at restaurant using HDFC card"
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "parsed_expense": {
            "amount": 500,
            "currency": "INR",
            "category_id": 1,
            "category_name": "Food",
            "wallet_id": 2,
            "wallet_name": "HDFC Card",
            "expense_person_id": null,
            "person_name": "Self",
            "date": "2025-08-11",
            "notes": "Lunch at restaurant"
        },
        "new_entries_created": {
            "categories": [],
            "wallets": [],
            "persons": []
        },
        "processing_time": 1.23,
        "suggestions": {
            "similar_amount_categories": ["Food", "Dining"],
            "common_wallets": ["Cash", "HDFC Card"]
        }
    },
    "message": "Expense parsed successfully"
}
```

### Create Transaction
```http
POST /api/whatsapp/create-transaction
Authorization: Bearer {token}
Content-Type: application/json

{
    "amount": 500,
    "category_id": 1,
    "wallet_id": 2,
    "person_name": "Self",
    "date": "2025-08-11",
    "notes": "Lunch at restaurant",
    "type": "expense"
}
```

### Parse and Create (Combined)
```http
POST /api/whatsapp/parse-and-create
Authorization: Bearer {token}
Content-Type: application/json

{
    "message": "Bought groceries for 1500 from Big Bazaar using cash",
    "auto_create": true
}
```

### Recent Transactions
```http
GET /api/whatsapp/recent-transactions?limit=10
Authorization: Bearer {token}
```

### WhatsApp Webhook
```http
POST /api/whatsapp/webhook
Content-Type: application/json

{
    "Body": "Spent 300 on coffee",
    "From": "+1234567890"
}
```

## Usage Examples

### Basic Parsing
```php
use App\Services\OpenRouterService;

$service = app(OpenRouterService::class);

$result = $service->parseTransaction(
    'Paid 1200 for electricity bill using SBI account',
    $categories, // [['id' => '1', 'name' => 'Utilities']]
    $wallets,    // [['id' => '1', 'name' => 'SBI Account']]
    $persons     // [['id' => '1', 'name' => 'John']]
);

if ($result['success']) {
    $parsedData = $result['parsed_data'];
    $newEntries = $result['new_entries'];
    // Process the data...
}
```

### Controller Usage
```php
use App\Http\Controllers\WhatsAppController;

// In another controller
public function handleExpenseFromSms(Request $request)
{
    $whatsappController = app(WhatsAppController::class);
    
    $parseRequest = new Request([
        'message' => $request->sms_content,
        'user_id' => auth()->id()
    ]);
    
    return $whatsappController->parseExpense($parseRequest);
}
```

## Supported Message Formats

The AI can parse various natural language formats:

- "Spent 500 on lunch"
- "Paid 1200 for groceries at Big Bazaar using HDFC card"
- "Coffee 150 rupees from wallet"
- "Bought headphones for ₹2500 on 2025-08-10"
- "Electricity bill 3000 paid via UPI"
- "Restaurant dinner 800 with John"

## Error Handling

The service includes comprehensive error handling:

- **Invalid API Key**: Returns 401 with clear message
- **Timeout**: Automatic retries with exponential backoff
- **Invalid JSON**: Attempts to extract and fix malformed responses
- **Schema Validation**: Validates all required fields
- **Rate Limiting**: Prevents API abuse

## Testing

Run the test suite:
```bash
php artisan test tests/Feature/WhatsAppExpenseParsingTest.php
```

Test the integration manually:
1. Visit `/whatsapp/test` (requires authentication)
2. Enter an expense message
3. Click "Parse Message" or "Parse & Create Transaction"

## Performance Optimization

1. **Enable Caching**: Set `OPENROUTER_ENABLE_CACHING=true`
2. **Adjust Timeout**: Lower `OPENROUTER_TIMEOUT` for faster responses
3. **Model Selection**: Use faster models like `meta-llama/llama-3.1-8b-instruct`
4. **Request Batching**: Process multiple messages in batches

## Security Considerations

1. **API Key Protection**: Store OpenRouter API key securely
2. **Rate Limiting**: Implemented for webhook endpoints
3. **Input Validation**: All inputs are validated and sanitized
4. **Authorization**: All API endpoints require authentication
5. **CSRF Protection**: Web routes include CSRF protection

## Troubleshooting

### Common Issues

1. **"AI did not return valid JSON"**
   - Check OpenRouter API key validity
   - Verify network connectivity
   - Enable debug logging: `OPENROUTER_DEBUG_LOGGING=true`

2. **"Category/Wallet not found"**
   - The service automatically creates new entries
   - Check user has existing categories/wallets

3. **"Rate limit exceeded"**
   - Implement request queuing
   - Increase cache duration
   - Use background job processing

### Debug Mode

Enable detailed logging:
```env
OPENROUTER_DEBUG_LOGGING=true
LOG_LEVEL=debug
```

Check logs:
```bash
tail -f storage/logs/laravel.log
```

## License

This project is licensed under the MIT License.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Write tests for new functionality
4. Submit a pull request

## Support

For support and questions:
- Create an issue on GitHub
- Check the Laravel documentation
- Review OpenRouter API documentation
