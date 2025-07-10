@if($type == 'color')
    <div class="col-md-{{ $col }}">
        <div class="mb-3 row">
            <label class="form-label col-md-4">{{ $title }} {!! $required ? null : '<span class="text-danger">*</span>' !!}</label>
            <div class="col-md-8">
                <input type="text" class="form-control color" name="{{ $name ?? $id }}" id="{{ $id }}" value="{{ $value }}">
            </div>
        </div>
    </div>
@elseif($type == 'text-editor')
    <div class="col-md-{{ $col }}">
        <div class="mb-3 row">
            <label class="col-md-4 col-form-label">{{ $title }} <span class="text-danger">*</span></label>
            <div class="col-md-8">
                <textarea id="{{ $id }}" name="{{ $name ?? $id }}" class="form-control">{!! $value !!}</textarea>
            </div>
        </div>
    </div>
@elseif($type == 'drop-down')
    <div class="col-md-{{ $col }}">
        <div class="mb-3 row">
            <label class="col-md-4 col-form-label">{{ $title }} {!! $required ? null : '<span class="text-danger">*</span>' !!}</label>
            <div class="col-md-8">
                <select name="{{ $name ?? $id }}" id="{{ $id }}" class="form-control {{ $filter ? 'select-filter' : 'select2' }}" style="width: 100%;">
                    <option value="" selected hidden disabled>==Select {{ $title }}==</option>
                    {{ $slot }}
                    @foreach($options as $option)
                        <option value="{{ $option->id }}" @selected(request($name ?? 'null') == $option->id)>{{ $option->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
@elseif($type == 'choose')
    <div class="col-md-{{ $col }}">
        <div class="mb-3 row">
            <label class="col-md-4 col-form-label">{{ $title }} {!! $required ? null : '<span class="text-danger">*</span>' !!}</label>
            <div class="col-md-8">
                <select name="{{ ($name ?? $id) . ($multiple ? '[]' : '') }}"  id="{{ $id }}"  class="form-control {{ $filter ? 'select-filter' : 'select2' }}"  style="width: 100%;"  {{ $multiple ? 'multiple' : null }}>
                    @if(!$multiple)
                        <option value="" selected hidden disabled>==Select {{ $title }}==</option>
                    @endif
                    {{ $slot }}
                </select>
            </div>
        </div>
    </div>
@else
    <div class="col-md-{{ $col }}">
        <div class="mb-3 row">
            <label for="example-text-input" class="col-md-4 col-form-label">{{ $title }} {!! $required ? null : '<span class="text-danger">*</span>' !!}</label>
            <div class="col-md-8">
                <input type="{{ $type }}" step="{{ $step }}" class="form-control {{ $type == 'file' ? null : 'max-length' }}" @if($type != 'file') maxlength="{{ $max }}" @endif name="{{$name ?? $id }}" id="{{ $id }}" value="{{ $value }}" {{ $readonly ? 'readonly' : null }} {{ $multiple ? 'multiple' : null }}>
            </div>
        </div>
    </div>
@endif