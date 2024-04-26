<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Schedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'scheduled posts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       // posted_at が現在の時間以前のポストを取得する
       $posts = Post::where('posted_at', '<=', now())->where('published', false)->get();

       // 取得したポストを投稿する
       foreach ($posts as $post) {
           $post->update(['published' => true]);
           $this->info('Post published: ' . $post->title);
       }

       $this->info('My command is running!');
    }
}
