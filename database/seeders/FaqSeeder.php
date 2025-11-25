<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::truncate();
        Faq::create(['keyword' => 'ship,delivery,shipping,fee,cost', 'answer' => 'Shipping is 30k for inner city, 50k for suburbs. Free shipping for orders over 1 million VND!']);
        Faq::create(['keyword' => 'return,refund,exchange,size,fit', 'answer' => 'Converse supports size exchange within 7 days if the shoes are unused.']);
        Faq::create(['keyword' => 'location,address,shop,store,map', 'answer' => 'Our store has 3 branches at 65 Le Loi, Ben Nghe Ward, District 1, HCMC; 11 Su Van Hanh, District 10, HCMC; and 191 Ba Trieu, Hai Ba Trung District, Hanoi, operating daily from 7:00 AM to 10:00 PM.']);
        Faq::create(['keyword' => 'hello,hi,hey,greeting,morning,afternoon', 'answer' => 'Hello! Welcome to Converse ShoesDelRey. How can I help you today?']);
    }
}
