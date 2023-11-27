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
            'description' => 'I am a big fan of IIS.',
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

        DB::table('users')->insert([
            'username' => 'Ing. Dan Stružka',
            'first_name' => 'Daniel',
            'last_name' => 'Stružka',
            'email' => 'daniel.struzka@test.cz',
            'visibility' => 'registered',
            'is_admin' => false,
            'description' => 'Mám skrytý profil před neregistrovanými',
            'password' => password_hash('heslo123', PASSWORD_BCRYPT),
        ]);

        DB::table('users')->insert([
            'username' => 'aja_lach',
            'first_name' => 'Alena',
            'last_name' => 'Lachová',
            'email' => 'ajalach02@test.cz',
            'visibility' => 'hidden',
            'is_admin' => false,
            'description' => 'Mám skrytý profil před neregistrovanými',
            'password' => password_hash('heslo123', PASSWORD_BCRYPT),
        ]);

        DB::table('users')->insert([
            'username' => 'adamski',
            'first_name' => 'David',
            'last_name' => 'Adamski',
            'email' => 'adamski@test.cz',
            'visibility' => 'registered',
            'is_admin' => false,
            'description' => 'Mám skrytý profil před neregistrovanými',
            'password' => password_hash('heslo123', PASSWORD_BCRYPT),
        ]);

        // groups
        Db::table('user_groups')->insert([
            'name'=> 'bombová divize',
            'description' => 'tak to je bomba',
        ]);

        Db::table('user_groups')->insert([
            'name' => 'VSK Univerzita Brno',
            'description' => 'Informační kanál sportovního klubu VSK Univerzita Brno.',
        ]);

        Db::table('user_groups')->insert([
            'name' => 'VUT FIT',
            'description' => 'Informační kanál VUT FIT.',
        ]);
        
        Db::table('user_groups')->insert([
            'name' => 'IIS private',
            'description' => 'Tohle zajisté neuvidí pan profesor.',
        ]);
        
        // group members
        // VSK Uni
        $groupid = Db::table('user_groups')->where('name', 'VSK Univerzita Brno')->value('id');
        $userid = Db::table('users')->where('username', 'lil Burger')->value('id');

        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'owner',
        ]);

        $userid = Db::table('users')->where('username', 'adamski')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'regular',
        ]);

        $userid = Db::table('users')->where('username', 'xbromn00')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'regular',
        ]);

        $userid = Db::table('users')->where('username', 'MR. private')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'regular',
        ]);

        // VUT FIT
        $groupid = Db::table('user_groups')->where('name', 'VUT FIT')->value('id');
        $userid = Db::table('users')->where('username', 'xbromn00')->value('id');

        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'owner',
        ]);

        $userid = Db::table('users')->where('username', 'Ing. Dan Stružka')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'regular',
        ]);

        $userid = Db::table('users')->where('username', 'aja_lach')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'regular',
        ]);

        $userid = Db::table('users')->where('username', 'MR. private')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'regular',
        ]);

        $userid = Db::table('users')->where('username', 'MR. kind-of-private')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'regular',
        ]);


        // IIS private
        $groupid = Db::table('user_groups')->where('name', 'IIS private')->value('id');
        $userid = Db::table('users')->where('username', 'adamski')->value('id');

        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'owner',
        ]);

        $userid = Db::table('users')->where('username', 'xbromn00')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'regular',
        ]);

        $userid = Db::table('users')->where('username', 'aja_lach')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'regular',
        ]);

        $userid = Db::table('users')->where('username', 'MR. private')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'regular',
        ]);

        $userid = Db::table('users')->where('username', 'MR. kind-of-private')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'regular',
        ]);
        
        $userid = Db::table('users')->where('username', 'lil Burger')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'regular',
        ]);

        $userid = Db::table('users')->where('username', 'Ing. Dan Stružka')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'regular',
        ]);

        // bombova divize
        $groupid = Db::table('user_groups')->where('name', 'bombová divize')->value('id');

        $userid = Db::table('users')->where('username', 'xbromn00')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'owner',
        ]);

        $userid = Db::table('users')->where('username', 'lil Burger')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'regular',
        ]);

        $userid = Db::table('users')->where('username', 'aja_lach')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'regular',
        ]);

        $userid = Db::table('users')->where('username', 'MR. private')->value('id');
        Db::table('group_members')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'role' => 'regular',
        ]);

        // groups join requests
        // bobová divize
        $groupid = Db::table('user_groups')->where('name', 'bombová divize')->value('id');

        $requesterid = Db::table('users')->where('username', 'adamski')->value('id');
        Db::table('group_join_requests')->insert([
            'requester_id' => $requesterid,
            'group_id' => $groupid,
        ]);
        
        $requesterid = Db::table('users')->where('username', 'Ing. Dan Stružka')->value('id');
        Db::table('group_join_requests')->insert([
            'requester_id' => $requesterid,
            'group_id' => $groupid,
        ]);

        $requesterid = Db::table('users')->where('username', 'MR. kind-of-private')->value('id');
        Db::table('group_join_requests')->insert([
            'requester_id' => $requesterid,
            'group_id' => $groupid,
        ]);

        // VSK Uni
        $groupid = Db::table('user_groups')->where('name', 'VSK Univerzita Brno')->value('id');

        $requesterid = Db::table('users')->where('username', 'aja_lach')->value('id');
        Db::table('group_join_requests')->insert([
            'requester_id' => $requesterid,
            'group_id' => $groupid,
        ]);

        // groups role requests
        // IIS private
        $groupid = Db::table('user_groups')->where('name', 'IIS private')->value('id');

        $requesterid = Db::table('users')->where('username', 'lil Burger')->value('id');
        Db::table('group_role_requests')->insert([
            'requester_id' => $requesterid,
            'group_id' => $groupid,
        ]);
        
        $requesterid = Db::table('users')->where('username', 'Ing. Dan Stružka')->value('id');
        Db::table('group_role_requests')->insert([
            'requester_id' => $requesterid,
            'group_id' => $groupid,
        ]);

        // bombová divize
        $groupid = Db::table('user_groups')->where('name', 'bombová divize')->value('id');

        $requesterid = Db::table('users')->where('username', 'aja_lach')->value('id');
        Db::table('group_role_requests')->insert([
            'requester_id' => $requesterid,
            'group_id' => $groupid,
        ]);

        // threads, posts, ratings
        //bombová divize
        $groupid = Db::table('user_groups')->where('name', 'bombová divize')->value('id');

        $userid = Db::table('users')->where('username', 'xbromn00')->value('id');
        Db::table('threads')->insert([
            'user_id' => $userid,
            'group_id' => $groupid,
            'topic' => 'Co zbombardujeme dnes?',
        ]);

        $threadid = Db::table('threads')->where('topic', 'Co zbombardujeme dnes?')->value('id');
        Db::table('posts')->insert([
            'user_id' => $userid,
            'thread_id' => $threadid,
            'title' => 'Co takhle se na to dnes vykašlat?',
            'content' => 'Nevím jak ostatní, ale mně se dneska moc nechce. Radši bych ležel doma a koukal na telku.',
            'rating' => 0,
        ]);

        $userid = Db::table('users')->where('username', 'aja_lach')->value('id');
        $threadid = Db::table('threads')->where('topic', 'Co zbombardujeme dnes?')->value('id');
        Db::table('posts')->insert([
            'user_id' => $userid,
            'thread_id' => $threadid,
            'title' => 'Taky bych se na to vykvákla',
            'content' => 'Souhlasím s koukáním na televizi, taky se mi dneska vůbec nechce.',
            'rating' => 1,
        ]);

        $userid = Db::table('users')->where('username', 'xbromn00')->value('id');
        $postid = Db::table('posts')->where('title', 'Taky bych se na to vykvákla')->value('id');
        Db::table('rating')->insert([
            'user_id' => $userid,
            'post_id' => $postid,
            'rating_type' => 'like',
        ]);
    }
}
