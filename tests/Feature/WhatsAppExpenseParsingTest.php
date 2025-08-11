<?php

use Tests\TestCase;
use App\Services\OpenRouterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class WhatsAppExpenseParsingTest extends TestCase
{
    use RefreshDatabase;

    public function test_parse_simple_expense()
    {
        // Mock the OpenRouter API response
        Http::fake([
            'openrouter.ai/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => json_encode([
                                'amount' => 500,
                                'currency' => 'INR',
                                'category' => 'Food',
                                'wallet' => 'HDFC',
                                'person' => 'Self',
                                'notes' => 'Lunch at restaurant',
                                'date' => '2025-08-11'
                            ])
                        ]
                    ]
                ]
            ], 200)
        ]);

        $service = new OpenRouterService();
        
        $result = $service->parseTransaction(
            'Spent 500 on lunch at restaurant from HDFC card',
            [['id' => '1', 'name' => 'Food']],
            [['id' => '1', 'name' => 'HDFC']],
            [['id' => '1', 'name' => 'John']]
        );

        $this->assertTrue($result['success']);
        $this->assertEquals(500, $result['parsed_data']['amount']);
        $this->assertEquals('INR', $result['parsed_data']['currency']);
        $this->assertEquals('1', $result['parsed_data']['category']);
        $this->assertEquals('1', $result['parsed_data']['wallet']);
        $this->assertEquals('Self', $result['parsed_data']['person']);
    }

    public function test_create_new_category_and_wallet()
    {
        Http::fake([
            'openrouter.ai/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => json_encode([
                                'amount' => 1200,
                                'currency' => 'INR',
                                'category' => 'Electronics',
                                'wallet' => 'Credit Card',
                                'person' => 'Self',
                                'notes' => 'Bought headphones',
                                'date' => '2025-08-11'
                            ])
                        ]
                    ]
                ]
            ], 200)
        ]);

        $service = new OpenRouterService();
        
        $result = $service->parseTransaction(
            'Bought headphones for 1200 using credit card',
            [['id' => '1', 'name' => 'Food']],
            [['id' => '1', 'name' => 'Cash']],
            [['id' => '1', 'name' => 'John']]
        );

        $this->assertTrue($result['success']);
        $this->assertCount(1, $result['new_entries']['categories']);
        $this->assertCount(1, $result['new_entries']['wallets']);
        $this->assertEquals('Electronics', $result['new_entries']['categories'][0]['name']);
        $this->assertEquals('Credit Card', $result['new_entries']['wallets'][0]['name']);
    }
}

// Example usage script
class ExampleUsage
{
    public static function demonstrateAPI()
    {
        echo "=== WhatsApp Expense Integration Demo ===\n\n";

        echo "Available API endpoints:\n";
        echo "1. POST /api/whatsapp/parse-expense\n";
        echo "   - Parse expense message without creating transaction\n";
        echo "   - Body: {\"message\": \"Spent 500 on lunch\"}\n\n";

        echo "2. POST /api/whatsapp/create-transaction\n";
        echo "   - Create transaction from parsed data\n";
        echo "   - Body: {\"amount\": 500, \"category_id\": 1, \"wallet_id\": 1, ...}\n\n";

        echo "3. POST /api/whatsapp/parse-and-create\n";
        echo "   - Parse message and optionally create transaction\n";
        echo "   - Body: {\"message\": \"Spent 500 on lunch\", \"auto_create\": true}\n\n";

        echo "4. GET /api/whatsapp/recent-transactions\n";
        echo "   - Get user's recent transactions\n\n";

        echo "5. POST /api/whatsapp/webhook\n";
        echo "   - WhatsApp webhook receiver (public endpoint)\n\n";

        echo "Example cURL requests:\n\n";

        echo "# Parse expense message\n";
        echo "curl -X POST http://your-domain.com/api/whatsapp/parse-expense \\\n";
        echo "  -H \"Content-Type: application/json\" \\\n";
        echo "  -H \"Authorization: Bearer YOUR_API_TOKEN\" \\\n";
        echo "  -d '{\"message\": \"Paid 1500 for groceries at Big Bazaar using HDFC card\"}'\n\n";

        echo "# Parse and create transaction\n";
        echo "curl -X POST http://your-domain.com/api/whatsapp/parse-and-create \\\n";
        echo "  -H \"Content-Type: application/json\" \\\n";
        echo "  -H \"Authorization: Bearer YOUR_API_TOKEN\" \\\n";
        echo "  -d '{\"message\": \"Lunch 800 rupees paid from wallet\", \"auto_create\": true}'\n\n";

        echo "Environment variables to set:\n";
        echo "OPENROUTER_API_KEY=your_openrouter_api_key\n";
        echo "OPENROUTER_MODEL=mistralai/mistral-7b-instruct\n";
        echo "OPENROUTER_TIMEOUT=30\n";
        echo "OPENROUTER_ENABLE_CACHING=true\n";
        echo "WHATSAPP_WEBHOOK_TOKEN=your_webhook_verification_token\n";
        echo "WHATSAPP_API_TOKEN=your_whatsapp_api_token\n\n";

        echo "Response format:\n";
        echo "{\n";
        echo "  \"success\": true,\n";
        echo "  \"data\": {\n";
        echo "    \"parsed_expense\": {\n";
        echo "      \"amount\": 1500,\n";
        echo "      \"currency\": \"INR\",\n";
        echo "      \"category_id\": 1,\n";
        echo "      \"category_name\": \"Groceries\",\n";
        echo "      \"wallet_id\": 2,\n";
        echo "      \"wallet_name\": \"HDFC Card\",\n";
        echo "      \"expense_person_id\": null,\n";
        echo "      \"person_name\": \"Self\",\n";
        echo "      \"date\": \"2025-08-11\",\n";
        echo "      \"notes\": \"Groceries at Big Bazaar\"\n";
        echo "    },\n";
        echo "    \"new_entries_created\": {\n";
        echo "      \"categories\": [],\n";
        echo "      \"wallets\": [],\n";
        echo "      \"persons\": []\n";
        echo "    },\n";
        echo "    \"processing_time\": 1.23,\n";
        echo "    \"suggestions\": {\n";
        echo "      \"similar_amount_categories\": [\"Food\", \"Shopping\"],\n";
        echo "      \"common_wallets\": [\"Cash\", \"HDFC Card\"]\n";
        echo "    }\n";
        echo "  },\n";
        echo "  \"message\": \"Expense parsed successfully\"\n";
        echo "}\n\n";
    }
}

// Run the demo if this file is executed directly
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'] ?? '')) {
    ExampleUsage::demonstrateAPI();
}
