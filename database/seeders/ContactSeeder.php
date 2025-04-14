<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'phone' => '1234567890',
                'subject' => 'Inquiry about Toyota Camry',
                'message' => 'I would like to know more about the Toyota Camry. Is it available for a test drive this weekend?',
                'status' => false
            ],
            [
                'name' => 'Emily Johnson',
                'email' => 'emily.johnson@example.com',
                'phone' => '9876543210',
                'subject' => 'Financing Options',
                'message' => 'Hello, I am interested in the financing options available for your luxury vehicles. Could you please provide me with more information?',
                'status' => false
            ],
            [
                'name' => 'Michael Davis',
                'email' => 'michael.davis@example.com',
                'phone' => '5551234567',
                'subject' => 'Service Appointment',
                'message' => 'I need to schedule a service appointment for my Honda CR-V purchased from your dealership last year. What are your available dates?',
                'status' => false
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah.wilson@example.com',
                'phone' => '7778889999',
                'subject' => 'Trade-in Value Question',
                'message' => 'I am looking to trade in my current vehicle for a new one. How can I get an estimate of my car\'s trade-in value?',
                'status' => false
            ],
            [
                'name' => 'Robert Brown',
                'email' => 'robert.brown@example.com',
                'phone' => '3332221111',
                'subject' => 'Electric Vehicle Information',
                'message' => 'I am interested in learning more about your electric vehicle options. Do you offer any special incentives or rebates for EV purchases?',
                'status' => false
            ]
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}
