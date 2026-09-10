<li class="treeview @if(Request::is('/settings', '/users', '/roles', '/settings/*', '/roles/*', '/users/*')) active menu-open @endif">
    <a href="#">
        <i class="fa fa-cogs text-danger"></i> <span>{{ __('System Config') }}</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        @if(auth()->user()->can('browse_api_manager') || auth()->user()->hasRole('super-admin'))
            <li class="@if(Request::is('/settings','/settings/*'))active @endif"><a
                    href="{{url('/settings')}}"><i class="fa fa-cogs text-danger"></i> {{ __('General Setting') }}</a></li>
        @endif
        @if(auth()->user()->can('browse_users') || auth()->user()->hasRole('super-admin'))
            <li class="@if(Request::is('/users','/users/*'))active @endif"><a href="{{url('/users')}}"><i
                        class="fa fa-users text-aqua"></i> {{ __('Users') }}</a></li>
        @endif
        @if(auth()->user()->can('browse_roles') || auth()->user()->hasRole('super-admin'))
            <li class="@if(Request::is('/roles','/roles/*'))active @endif"><a href="{{url('admin/roles')}}"><i
                        class="fa fa-key text-red"></i> {{ __('Roles') }}</a></li>
        @endif
        @if(auth()->user()->can('browse_permissions') || auth()->user()->hasRole('super-admin'))
                <li class="@if(Request::is('admin/permissions','admin/permissions/*'))active @endif"><a href="{{url('admin/permissions')}}"><i
                            class="fa fa-key text-red"></i> {{ __('Permissions') }}</a></li>
        @endif

    </ul>
</li>
