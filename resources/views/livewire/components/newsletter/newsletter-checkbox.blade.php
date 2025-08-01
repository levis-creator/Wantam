<?php
use Livewire\Volt\Component;

new class extends Component {
}; ?>

<div class="custom-control custom-checkbox" x-data="{ dontShow: $persist(false) }"
    x-init="$watch('dontShow', value => !value && $('#newsletter-popup-form').magnificPopup('open'))">
    <input type="checkbox" class="custom-control-input" id="register-policy-2" x-model="dontShow"
        aria-label="Do not show this popup again">
    <label class="custom-control-label" for="register-policy-2">Do not show this popup again</label>
</div>
