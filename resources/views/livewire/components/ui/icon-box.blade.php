<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $icon;
    public string $title;
    public string $description;

};
?>

<div class="icon-box icon-box-side">
    <span class="icon-box-icon text-primary">
        <i class="{{ $icon }}"></i>
    </span>

    <div class="icon-box-content">
        <h3 class="icon-box-title">{{ $title }}</h3>
        <p>{{ $description }}</p>
    </div>
</div>