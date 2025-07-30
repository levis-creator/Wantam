<?php

use Livewire\Volt\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

new class extends Component {
    public $post;

    public function mount($post)
    {
        // Ensure fallback/defaults if needed
        $this->post['comments'] = $this->post['comments'] ?? 0;
    }
};
?>

<article class="entry" itemscope itemtype="https://schema.org/BlogPosting">
    <figure class="entry-media">
        <a href="{{ route('blog.show', $post['slug']) }}" title="{{ $post['title'] }}" itemprop="url">
            <img src="{{ asset($post['image']) }}" alt="{{ $post['title'] }} image" itemprop="image">
        </a>
    </figure>

    <div class="entry-body text-center">
        <div class="entry-meta">
            <time datetime="{{ Carbon::parse($post['date'])->toDateString() }}" itemprop="datePublished">
                {{ $post['date'] }}
            </time>,
            <span>{{ $post['comments'] }} {{ Str::plural('Comment', $post['comments']) }}</span>
        </div>

        <h3 class="entry-title" itemprop="headline">
            <a href="{{ route('blog.show', $post['slug']) }}" title="{{ $post['title'] }}" itemprop="mainEntityOfPage">
                {{ $post['title'] }}
            </a>
        </h3>

        <div class="entry-content" itemprop="articleBody">
            <p>{{ $post['excerpt'] }}</p>
            <a href="{{ route('blog.show', $post['slug']) }}" class="read-more"
                aria-label="Read more about {{ $post['title'] }}">
                READ MORE
            </a>
        </div>
    </div>
</article>