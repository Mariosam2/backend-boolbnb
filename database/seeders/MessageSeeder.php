<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messages = config('messages.messages');

        foreach ($messages as $message) {
            $new_message = new Message();
            $new_message->is_read = false;
            $new_message::create($message);
        }
    }
}
