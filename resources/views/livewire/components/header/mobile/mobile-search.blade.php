<?php
use Livewire\Volt\Component;

new class extends Component {
    public $query = '';

    public function search()
    {
        return redirect()->route('shop.index', ['q' => $this->query]);
    }
}; ?>

<form action="{{ route('shop.index') }}" method="GET" class="mobile-search">
    <label for="mobile-search" class="sr-only">Search</label>
    <input type="search" class="form-control" name="q" id="mobile-search" wire:model="query"
        placeholder="Search products..." required>
    <button class="btn btn-primary" type="submit" wire:click="search" title="Search products">
        <i class="icon-search" aria-hidden="true"></i>
    </button>
</form>
