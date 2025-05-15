<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'usuari' => 'depresio',
                'nom' => 'Pepito de los Palotes',
                'email' => 'depresio@gmail.com',
                'password' => Hash::make('123123123'),
                'password_confirmation' => Hash::make('123123123'),
                'rol' => 'vendedor',
                'descripcion' => 'Vendedor especializado en electrónica y gadgets tecnológicos.',
                'img' => 'images/users/user_placeholder.png',
                'direccio' => null,
                'comarca' => null,
                'municipi' => null,
                'provincia' => null,
                'telefon' => null,
                'receive_info' => false,
            ],
            [
                'id' => 2,
                'usuari' => 'mercatartesa',
                'nom' => 'Maria Garcia Puig',
                'email' => 'maria.artesania@gmail.com',
                'password' => Hash::make('123123123'),
                'password_confirmation' => Hash::make('123123123'),
                'rol' => 'vendedor',
                'descripcion' => 'Artesana especializada en productos textiles tradicionales catalanes.',
                'img' => 'images/users/user_placeholder.png',
                'direccio' => 'Carrer del Mar, 123',
                'comarca' => 'Alt Empordà',
                'municipi' => 'Figueres',
                'provincia' => 'Girona',
                'telefon' => '677889900',
                'receive_info' => true,
            ],
            [
                'id' => 3,
                'usuari' => 'delicatessen',
                'nom' => 'Josep Martí Costa',
                'email' => 'josep.delicatessen@gmail.com',
                'password' => Hash::make('123123123'),
                'password_confirmation' => Hash::make('123123123'),
                'rol' => 'vendedor',
                'descripcion' => 'Especialista en productos gourmet y delicatessen de Lleida.',
                'img' => 'images/users/user_placeholder.png',
                'direccio' => 'Rambla Ferran, 15',
                'comarca' => 'Segrià',
                'municipi' => 'Lleida',
                'provincia' => 'Lleida',
                'telefon' => '644556677',
                'receive_info' => true,
            ],
            [
                'id' => 4,
                'usuari' => 'terradelvi',
                'nom' => 'Anna Valls Ferrer',
                'email' => 'anna.vins@gmail.com',
                'password' => Hash::make('123123123'),
                'password_confirmation' => Hash::make('123123123'),
                'rol' => 'vendedor',
                'descripcion' => 'Experta en vinos DO Tarragona y productos locales.',
                'img' => 'images/users/user_placeholder.png',
                'direccio' => 'Passeig Marítim, 45',
                'comarca' => 'Baix Camp',
                'municipi' => 'Cambrils',
                'provincia' => 'Tarragona',
                'telefon' => '633445566',
                'receive_info' => false,
            ],
            [
                'id' => 5,
                'usuari' => 'artesaniabcn',
                'nom' => 'Pere Soler Camps',
                'email' => 'pere.artesania@gmail.com',
                'password' => Hash::make('123123123'),
                'password_confirmation' => Hash::make('123123123'),
                'rol' => 'vendedor',
                'descripcion' => 'Artesano especializado en cerámica y escultura contemporánea.',
                'img' => 'images/users/user_placeholder.png',
                'direccio' => 'Carrer de Sants, 220',
                'comarca' => 'Barcelonès',
                'municipi' => 'Barcelona',
                'provincia' => 'Barcelona',
                'telefon' => '688990011',
                'receive_info' => true,
            ],
            [
                'id' => 6,
                'usuari' => 'client',
                'nom' => 'Client User',
                'email' => 'client@gmail.com',
                'password' => Hash::make('123123123'),
                'password_confirmation' => Hash::make('123123123'),
                'rol' => 'client',
                'descripcion' => null,
                'img' => 'images/users/user_placeholder.png',
                'direccio' => 'Plaça Catalunya, 4',
                'comarca' => 'Maresme',
                'municipi' => 'Mataró',
                'provincia' => 'Barcelona',
                'telefon' => '611223344',
                'receive_info' => true,
            ],
            [
                'id' => 7,
                'usuari' => 'admin',
                'nom' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123123123'),
                'password_confirmation' => Hash::make('123123123'),
                'rol' => 'admin',
                'descripcion' => null,
                'img' => 'images/users/user_placeholder.png',
                'direccio' => 'Via Augusta, 5',
                'comarca' => 'Garraf',
                'municipi' => 'Sitges',
                'provincia' => 'Tarragona',
                'telefon' => '699887766',
                'receive_info' => false,
            ],
        ]);
    }
}
