<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // users
        DB::table('users')->insert([
            'username' => 'admin',
            'first_name' => 'Adam',
            'last_name' => 'Minister',
            'email' => 'admin@test.cz',
            'visibility' => 'all',
            'is_admin' => true,
            'description' => 'I am the admin of this website.',
            'password' => password_hash('youShallNotPassword', PASSWORD_BCRYPT),
        ]);

        DB::table('users')->insert([
            'username' => 'xbromn00',
            'first_name' => 'Petr',
            'last_name' => 'Bromnik',
            'email' => 'xbromn00@test.cz',
            'visibility' => 'all',
            'is_admin' => false,
            'description' => 'Big fan of IIS',
            'password' => password_hash('heslo123', PASSWORD_BCRYPT),
        ]);

        DB::table('users')->insert([
            'username' => 'lil Burger',
            'first_name' => 'David',
            'last_name' => 'Skřeček',
            'email' => 'xskrec00@test.cz',
            'visibility' => 'all',
            'is_admin' => false,
            'description' => 'I am a big fan of IIS. And i love burgers. And i have a mini-dick. a small little fella. he is sad, because nobody wants to play with him :(',
            'password' => password_hash('heslo123', PASSWORD_BCRYPT),
        ]);

        DB::table('users')->insert([
            'username' => 'MR. private',
            'first_name' => 'Pan',
            'last_name' => 'Tajemný',
            'email' => 'tajemny@test.cz',
            'visibility' => 'hidden',
            'is_admin' => false,
            'description' => 'Mám soukromý profil',
            'password' => password_hash('heslo123', PASSWORD_BCRYPT),
        ]);

        DB::table('users')->insert([
            'username' => 'MR. kind-of-private',
            'first_name' => 'Pan',
            'last_name' => 'Polotajemný',
            'email' => 'polotajemny@test.cz',
            'visibility' => 'registered',
            'is_admin' => false,
            'description' => 'Mám skrytý profil před neregistrovanými',
            'password' => password_hash('heslo123', PASSWORD_BCRYPT),
        ]);
    }
}
