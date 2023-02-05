<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $prova_appartamento =  [
            "user_id" => null,
            "apartment_category_id" => null,
            "address" => "Ljutomer, Slovenia",
            "check_in" => "14:00-22:00",
            "check_out" => "00:00-10:00",
            "price" => 73,
            "media" => "https://a0.muscache.com/im/pictures/d7c1f140-c33a-4d68-aaf8-b7b8d7292b11.jpg",
            "beds" => 2,
            "title" => "Appartamento Zemlyanka - Casa di terra",
            "description" => "Con un ritmo di vita faticoso, preoccupazioni costanti, oneri e obblighi sempre nuovi, c'è sempre bisogno di trovare il tempo per IL RIPOSO e IL RELAX.
            Fuori dal trambusto della città, nel bel mezzo di un bellissimo PAESAGGIO a Razkrižje, c'è una MODERNA CASA IN TERRA / HOBIT, che impressiona ogni ospite. È interamente costruita con materiali naturali (ARGILLA, LEGNO,...). L'amore per la creatività e la natura si sente ad ogni passo. Le testimonianze sono capolavori artigianali nella terra e intorno ad essa.",
            "guests" => 4,
            "baths" => 1,
            "total_rooms" => 5,
            "visible" => true,
            "mq" => 70,
            "latitude" => "46.516266",
            "longitude" => "16.196036",
        ];

        $new_apartment = Apartment::make($prova_appartamento);
        $new_apartment->save();
    }
}
