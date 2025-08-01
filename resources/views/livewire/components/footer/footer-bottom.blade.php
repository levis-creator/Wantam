<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $copyrightYear;
    public string $storeName = 'Molla Store';

    public function mount()
    {
        $this->copyrightYear = date('Y');
    }
}
?>
<div class="footer-bottom">
    <div class="container">
        <p class="footer-copyright">Copyright © {{ $copyrightYear }} {{ $storeName }}. All Rights Reserved.</p>
        <figure class="footer-payments">
            <img src="{{ asset('images/payments.png') }}" alt="Accepted payment methods" width="272" height="20">
        </figure>
    </div>
</div>
