<?php

use Livewire\Volt\Component;

new class extends Component {
    public $posts = [];

    public function mount()
    {
        $this->posts = [
            [
                'title' => 'Sed adipiscing ornare.',
                'excerpt' => 'Phasellus hendrerit. Pellentesque aliquet nibh nec urna.',
                'image' => 'assets/images/demos/demo-10/blog/post-1.jpg',
                'date' => 'Nov 22, 2018',
                'comments' => 0,
                'slug' => 'sed-adipiscing-ornare'
            ],
            [
                'title' => 'Fusce lacinia arcuet nulla.',
                'excerpt' => 'Sed pretium, ligula sollicitudin laoreet viverra...',
                'image' => 'assets/images/demos/demo-10/blog/post-2.jpg',
                'date' => 'Dec 12, 2018',
                'comments' => 0,
                'slug' => 'fusce-lacinia-arcuet'
            ],
            [
                'title' => 'Aliquam erat volutpat.',
                'excerpt' => 'Pellentesque aliquet nibh nec urna...',
                'image' => 'assets/images/demos/demo-10/blog/post-3.jpg',
                'date' => 'Dec 19, 2018',
                'comments' => 2,
                'slug' => 'aliquam-erat-volutpat'
            ],
            [
                'title' => 'Quisque a lectus.',
                'excerpt' => 'Sed egestas, ante et vulputate volutpat...',
                'image' => 'assets/images/demos/demo-10/blog/post-4.jpg',
                'date' => 'Dec 19, 2018',
                'comments' => 2,
                'slug' => 'quisque-a-lectus'
            ],
        ];
    }
};
?>

<section class="blog-posts" aria-labelledby="blog-section-title">
    <div class="container">
        <h2 id="blog-section-title" class="title-lg text-center mb-4">
            From Our Blog
        </h2>

        <div class="owl-carousel owl-simple mb-4" data-toggle="owl" data-owl-options='{
                "nav": false,
                "dots": true,
                "items": 3,
                "margin": 20,
                "loop": false,
                "responsive": {
                    "0": {"items":1},
                    "520": {"items":2},
                    "768": {"items":3},
                    "992": {"items":4}
                }
            }' role="list" aria-label="Latest blog posts">
            @foreach ($posts as $post)
                <livewire:components.ui.post-card :post="$post" />
            @endforeach
        </div>

        <div class="more-container text-center mt-1">
            <a href="{{ route('blog.index') }}" class="btn btn-outline-lightgray btn-more btn-round"
                title="View all blog articles" rel="nofollow">
                <span>View more articles</span>
                <i class="icon-long-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>