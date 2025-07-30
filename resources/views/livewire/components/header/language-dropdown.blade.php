<?php
use Livewire\Volt\Component;

new class extends Component {
    public $languages;
    public $selectedLanguage = 'English';

    public function selectLanguage($languageCode)
    {
        $this->selectedLanguage = collect($this->languages)->firstWhere('code', $languageCode)['name'];
        session(['locale' => $languageCode]);
    }
}
?>

<div class="header-dropdown" x-data="{ open: false }">
    <a href="#" x-on:click.prevent="open = !open" aria-label="Select language" title="Choose your language">
        {{ $selectedLanguage }}
    </a>
    <div class="header-menu" x-show="open" x-on:click.outside="open = false">
        <ul>
            @foreach($languages as $language)
                <li>
                    <a href="{{ route('home', ['locale' => $language['code']]) }}" hreflang="{{ $language['hreflang'] }}"
                        wire:click="selectLanguage('{{ $language['code'] }}')"
                        title="Switch to {{ $language['name'] }} language">
                        {{ $language['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div><!-- End .header-menu -->
</div><!-- End .header-dropdown -->