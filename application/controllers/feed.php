<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Controller extends Controller 
{
	public $template=false;
        protected $cache;

        public function __construct()
        {
                parent::__construct();
                $this->cache = new Cache(array('lifetime' => 60*60));
        }

        public function index($category=0)
        {
                header('Content-Type: text/xml; charset=UTF-8', TRUE);

                if ($cache = $this->cache->get('blog_feed_'.(string)$category))
                {
                        echo $cache;
                        return;
                }

                $notes = new Blog_note_Model;
				$posts = $notes->get_notes($category,1,30);

                $info = array
                (
                        'title' => 'Skrypt',
                        'description' => '',
                        'link' => url::base(),
                        'generator' => 'Skrypt'
                );

                $items = array();
                foreach ($posts as $post)
                {
						$link = url::base()."blog/czytaj/". (($post->name!="")?($post->name):($post->id));
                        $items[] = array
                        (
                          //      'author'      => 'example@example.com ('.$post->user->username.')',
                                'pubDate'     => date('r', strtotime($post->date)),
                                'title'       => $post->title,
                                'description' => $post->description,
                                'link'        => $link,
                                'guid'        => $link,
                        );
                }

                $feed = feed::create($info, $items);
                $this->cache->set('blog_feed_'.(string)$category, $feed);
                echo $feed;
        }
}
