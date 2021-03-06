@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-2">
            <div class="card">
                <div class="card-body">
                    <div id="jobs-sidemenu">
                        <button class="buttons {{ Request::segment(2)=='profile' ? 'active' : '' }}" >
                            <a href="/admin/profile">
                                <i class="fa fa-suitcase fa-lg main-icon-1"></i>
                                <p class="main_text">My Profile</p> 
                            </a>
                        </button>
                        <button class="buttons {{ Request::segment(3)=='settings' ? 'active' : '' }}" >
                            <a href="{{ route('admin.settings.index') }}">
                                <i class="fa fa-cog fa-lg main-icon-1"></i>
                                <p class="main_text">@lang('menu.businessSettings')</p> 
                            </a>
                        </button>
                        <hr>
                        @if(0)
                        <button class="buttons {{ Request::segment(3)=='role-permission' ? 'active' : '' }}" >
                            <a href="{{ route('admin.role-permission.index') }}">
                                <i class="fa fa-key fa-lg main-icon-1"></i>
                                <p class="main_text">@lang('menu.rolesPermission')</p> 
                            </a>
                        </button>
                        @endif
                        <button class="buttons {{ Request::segment(3)=='payment-settings' ? 'active' : '' }}" >
                            <a href="{{ route('admin.payment-setting.index') }}">
                                <i class="fa fa-dollar fa-lg main-icon-1"></i>
                                <p class="main_text">Payment & Methods</p> 
                            </a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-10">
            <div class="card">
                <div class="card-body">
                    <form id="editSettings" class="ajax-form">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">@lang('app.name')</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ ucwords($user->name) }}">
                        </div>
                        <div class="form-group">
                            <label for="email">@lang('app.email')</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label for="company_phone">@lang('app.password')</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <span class="help-block"> @lang('messages.passwordNote')</span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">@lang('app.image')</label>
                            <div class="card">
                                <div class="card-body">
                                    <input type="file" id="input-file-now" name="image" accept=".png,.jpg,.jpeg" class="dropify"
                                           data-default-file="{{ $user->profile_image_url  }}"
                                    />
                                </div>
                            </div>
                        </div>


                        <button type="button" id="save-form"
                                class="btn btn-success waves-effect waves-light m-r-10">
                            @lang('app.save')
                        </button>
                        <button type="reset"
                                class="btn btn-inverse waves-effect waves-light">@lang('app.reset')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')
    <script src="{{ asset('assets/node_modules/dropify/dist/js/dropify.min.js') }}" type="text/javascript"></script>
    <script>
        $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang('app.largeFile')'
            }
        });

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.profile.update', $user->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });
    </script>

@endpush