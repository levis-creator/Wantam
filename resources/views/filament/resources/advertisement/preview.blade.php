<?php

use Livewire\Volt\Component;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;

new class extends Component {
    public $record;

    public function mount($record)
    {
        $this->record = $record ?? new \App\Models\Advertisement();
    }

} ?>
<div class="w-full relative overflow-auto ">
    <div class="intro-slider-container slider-container-ratio">
        <div class="intro-slider">
            <livewire:components.ui.slide :record="$record" />
        </div>
    </div>

</div>
