<x-app-layout title="User Management" subTitle="Role">
    <x-card-component col="12" title="Data Role">
        <div class="row mb-3">
            <div class="col-xl-3 col-sm-6">
                <div class="mt-2">
                    <h5>{{$role->name}} Permission</h5>
                </div>
            </div>
            <div class="col-xl-9 col-sm-6">
                <form class="mt-4 mt-sm-0 float-sm-end d-flex align-items-center">
                    <div class="search-box mb-2 me-2">
                        <div class="position-relative">
                            <button type="button" class="btn btn-primary waves-light waves-effect" onclick="checkList()"><i class="fas fa-square"></i></button>
                            <button type="button" class="btn btn-primary waves-light waves-effect" onclick="checkList2()"><i class="fas fa-check-square"></i></button>
                        </div>
                    </div>                                   
                </form>
            </div>
        </div>

        <form action="{{route('admin.user-management.role.update', $role->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" value="{{ $role->id }}">
            <div class="row">
                @foreach ($groups as $title => $subtitles)
                    <div class="col-xl-4 col-sm-6">
                        <div class="card shadow-none border">
                            <div class="card-body p-3">
                                <div class="">
                                    <h5>{{$title}}</h5>
                                    <br>
                                    <div class="row">
                                        @foreach ($subtitles as $subtitle)
                                            <div class="col-lg-4">
                                                <input class="form-check-input" type="checkbox" id="chk{{++$i}}" name="permission[]" value="{{$title.' -'.$subtitle.')'}}" @checked(in_array($permissions_id[$i-1], $rolePermissions))>
                                                <label for="chk{{$i}}" class="toggle">{{$subtitle}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="hstack gap-3" style="float: right;">
                <a href="{{route('admin.user-management.role.index')}}">
                    <button type="button" class="btn btn-secondary">Back</button>
                </a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </x-card-component>

    @push('js')
        <script>
            function checkList(){
                $(".form-check-input").prop('checked', false)
            }
            
            function checkList2(){
                $(".form-check-input").prop('checked', true)
            }
        </script>
    @endpush
</x-app-layout>