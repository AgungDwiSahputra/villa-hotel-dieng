<div id="{{ $id }}" class="modal fade bs-example-modal-{{ $type }}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-{{ $type }} modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: {{ $settings['theme'] ?? null }}">
                <h5 class="modal-title" id="myExtraLargeModalLabel"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
