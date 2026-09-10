<div class="container">
    <div class="content-tab-title">
        <h4>{{__('User Permission')}} </h4>
    </div>
    <!-- Tab Manu Start -->
    <div class="nav nav-tabs p-tab-manu" id="nav-tab" role="tablist">
        <button class="nav-link @if(Request::is('admin/users','admin/users/*'))active @endif" id="users-tab" data-bs-toggle="tab"
                data-bs-target="#users" type="button" role="tab" aria-controls="users" aria-selected="false"
                @if(url()->full()!=route('backend.users.index')) onclick="location.href='{{route('backend.users.index')}}'" @endif
        >{{__('Users')}}
        </button>
        <button class="nav-link @if(Request::is('admin/roles','admin/roles/*'))active @endif" id="roles-tab" data-bs-toggle="tab"
                data-bs-target="#roles" type="button" role="tab" aria-controls="roles" aria-selected="false"
                @if(url()->full()!=route('backend.roles.index')) onclick="location.href='{{route('backend.roles.index')}}'" @endif
        >{{__('Roles')}}
        </button>
        <button class="nav-link @if(Request::is('admin/permissions','admin/permissions/*'))active @endif" id="permission-tab"
                data-bs-toggle="tab" data-bs-target="#permission" type="button" role="tab" aria-controls="permission"
                aria-selected="false"
                @if(url()->full()!=route('backend.permissions.index')) onclick="location.href='{{route('backend.permissions.index')}}'" @endif
        >{{__('Permission')}}
        </button>
    </div>
    <!-- Tab Manu End -->
</div>