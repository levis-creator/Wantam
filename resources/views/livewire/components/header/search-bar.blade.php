<?php
use Livewire\Volt\Component;

new class extends Component {
    public $searchQuery = '';

    public function search()
    {
        $this->redirect(route('search', ['q' => $this->searchQuery]));
    }
}
?>

<div class="header-search">
    <a href="#" class="search-toggle" role="button" x-on:click="$refs.searchInput.focus()"
        aria-label="Toggle search input" title="Search products">
        <i class="icon-search" aria-hidden="true"></i>
    </a>
    <form action="{{ route('search') }}" method="get" x-data="{ open: false }">
        <div class="header-search-wrapper">
            <label for="q" class="sr-only">Search</label>
            <input type="search" class="form-control" name="q" id="q" placeholder="Search in..."
                wire:model.lazy="searchQuery" x-ref="searchInput" x-on:focus="open = true" x-on:blur="open = false"
                required>
        </div><!-- End .header-search-wrapper -->
    </form>
</div><!-- End .header-search -->