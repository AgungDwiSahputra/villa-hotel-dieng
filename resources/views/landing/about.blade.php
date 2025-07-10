<x-app-landing-layout>
<section class="breadcumb-section">
    <div class="tf-container">
        <div class="row">
            <div class="col-lg-12 center z-index1">
                <h1 class="title">Tentang Kami</h1>
            </div>
        </div>
    </div>
</section>

<section class="terms-condition">
    <div class="tf-container">
        {!! $settings['page_about'] ?? null !!}
    </div>
</section>
</x-app-landing-layout>