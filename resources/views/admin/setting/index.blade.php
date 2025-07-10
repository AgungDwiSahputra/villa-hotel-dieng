<x-app-layout title="Setting" subTitle="Setting">
    <x-card-component col="12" title="Setting Apps">
        <div class="row">
            <div class="col-md-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link mb-2 active" id="v-general-tab" data-bs-toggle="pill" href="#v-general" role="tab" aria-controls="v-general" aria-selected="true">General</a>
                    <a class="nav-link mb-2" id="v-home-tab" data-bs-toggle="pill" href="#v-contact" role="tab" aria-controls="v-contact" aria-selected="true">Contact</a>
                    <a class="nav-link mb-2" id="v-sosmed-tab" data-bs-toggle="pill" href="#v-sosmed" role="tab" aria-controls="v-sosmed" aria-selected="true">Sosmed</a>
                    <a class="nav-link mb-2" id="v-page-tab" data-bs-toggle="pill" href="#v-page" role="tab" aria-controls="v-page" aria-selected="true">Page</a>
                   
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                    <div class="tab-pane fade active show" id="v-general" role="tabpanel" aria-labelledby="v-general-tab">
                       <form action="{{ route('admin.setting.general') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <x-input-form-component col="6" title="Name" id="name" value="{{ $settings['name'] ?? null }}" />
                                <x-input-form-component col="6" title="Comapany" id="company" value="{{ $settings['company'] ?? null }}" />
                                <x-input-form-component col="6" title="Icon Size" id="icon_size" value="{{ $settings['icon_size'] ?? null }}" />
                                <x-input-form-component col="6" title="Logo Size" id="logo_size" value="{{ $settings['logo_size'] ?? null }}" />
                                <x-input-form-component col="6" title="Header" type="color" id="header" value="{{ $settings['header'] ?? null }}" />
                                <x-input-form-component col="6" title="Theme" type="color" id="theme" value="{{ $settings['theme'] ?? null }}" />
                                <x-input-form-component col="6" title="Icon" type="file" id="icon" />
                                <x-input-form-component col="6" title="Logo" type="file" id="logo" />
                                <div class="col-md-6 mb-3">
                                    <img src="{{ asset('storage/'.($settings['icon'] ?? null)) }}" height="50px" alt="">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <img src="{{ asset('storage/'.($settings['logo'] ?? null)) }}" height="50px" alt="">
                                </div>
                                <x-input-form-component col="6" title="DP (%)" type="number" id="dp" value="{{ $settings['dp'] ?? null }}" />
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                       </form>
                    </div>
                    <div class="tab-pane fade" id="v-contact" role="tabpanel" aria-labelledby="v-contact-tab">
                       <form action="{{ route('admin.setting.contact') }}" method="POST">
                            @csrf
                            <div class="row">
                                <x-input-form-component col="6" title="Email" id="contact_email" value="{{ $settings['contact_email'] ?? null }}" />
                                <x-input-form-component col="6" title="Phone" id="contact_phone" value="{{ $settings['contact_phone'] ?? null }}" max="255" />
                                <x-input-form-component col="6" title="Address" id="contact_address" value="{{ $settings['contact_address'] ?? null }}" />
                                <x-input-form-component col="6" title="Maps" id="contact_maps" value="{{ $settings['contact_maps'] ?? null }}" />
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                       </form>
                    </div>
                    <div class="tab-pane fade" id="v-sosmed" role="tabpanel" aria-labelledby="v-sosmed-tab">
                       <form action="{{ route('admin.setting.sosmed') }}" method="POST">
                            @csrf
                            <div class="row">
                                <x-input-form-component col="6" title="Whatsapp" type="url" id="sosmed_whatsapp" value="{{ $settings['sosmed_whatsapp'] ?? null }}" />
                                <x-input-form-component col="6" title="Instagram" type="url" id="sosmed_instagram" value="{{ $settings['sosmed_instagram'] ?? null }}" />
                                <x-input-form-component col="6" title="Facebook" type="url" id="sosmed_facebook" value="{{ $settings['sosmed_facebook'] ?? null }}" />
                                <x-input-form-component col="6" title="Tiktok" type="url" id="sosmed_tiktok" value="{{ $settings['sosmed_tiktok'] ?? null }}" />
                                <x-input-form-component col="6" title="Youtube" type="url" id="sosmed_youtube" value="{{ $settings['sosmed_youtube'] ?? null }}" />
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                       </form>
                    </div>
                    <div class="tab-pane fade" id="v-page" role="tabpanel" aria-labelledby="v-page-tab">
                       <form action="{{ route('admin.setting.page') }}" method="POST">
                            @csrf
                            <div class="row">
                                <x-input-form-component col="12" title="Tentang Kami" type="text-editor" id="page_about" value="{{ $settings['page_about'] ?? null }}" />
                                <x-input-form-component col="12" title="Syarat & Ketentuan " type="text-editor" id="page_terms" value="{{ $settings['page_terms'] ?? null }}" />
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </x-card-component>

    @push('js')
        <script>
            $(document).ready(function() {
                tinymce.init({
                    selector: "textarea#page_about",
                    height: 300,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    ],
                    toolbar: "insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist ",
                    style_formats: [
                        { title: "Bold text", inline: "b" },
                        { title: "Red text", inline: "span", styles: { color: "#ff0000" } },
                        { title: "Red header", block: "h1", styles: { color: "#ff0000" } },
                        { title: "Example 1", inline: "span", classes: "example1" },
                        { title: "Example 2", inline: "span", classes: "example2" },
                        { title: "Table styles" },
                        { title: "Table row 1", selector: "tr", classes: "tablerow1" }
                    ],
                    init_instance_callback: function (editor) {
                        editor.on('change', function () {
                            page_about = editor.getContent();
                        });
                    }
                });
                tinymce.init({
                    selector: "textarea#page_terms",
                    height: 300,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    ],
                    toolbar: "insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist ",
                    style_formats: [
                        { title: "Bold text", inline: "b" },
                        { title: "Red text", inline: "span", styles: { color: "#ff0000" } },
                        { title: "Red header", block: "h1", styles: { color: "#ff0000" } },
                        { title: "Example 1", inline: "span", classes: "example1" },
                        { title: "Example 2", inline: "span", classes: "example2" },
                        { title: "Table styles" },
                        { title: "Table row 1", selector: "tr", classes: "tablerow1" }
                    ],
                    init_instance_callback: function (editor) {
                        editor.on('change', function () {
                            page_about = editor.getContent();
                        });
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>