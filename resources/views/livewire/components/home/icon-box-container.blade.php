@php
    $iconBoxes = [
        ['icon' => 'icon-rocket', 'title' => 'Free Shipping', 'description' => 'Orders $50 or more'],
        ['icon' => 'icon-rotate-left', 'title' => 'Free Returns', 'description' => 'Within 30 days'],
        ['icon' => 'icon-info-circle', 'title' => 'Get 20% Off 1 Item', 'description' => 'when you sign up'],
        ['icon' => 'icon-life-ring', 'title' => 'We Support', 'description' => '24/7 amazing services'],
    ];
@endphp

<div class="icon-boxes-container icon-boxes-separator bg-transparent">
    <div class="container">
        <div class="row">
            @foreach ($iconBoxes as $box)
                <div class="col-sm-6 col-lg-3">
                    <livewire:components.ui.icon-box :icon="$box['icon']" :title="$box['title']"
                        :description="$box['description']" />
                </div>
            @endforeach
        </div>
    </div>
</div>