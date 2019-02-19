<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">

        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">
                <li class="menu-title">Menu</li>

                @if(in_array(auth()->user()->role_id, [1,2]))
                <li>
                    <a href="{{ route('home') }}" class="waves-effect">
                        <i class="mdi mdi-view-dashboard"></i><span> Dashboard </span>
                    </a>
                </li>
                @endif

                @if(in_array(auth()->user()->role_id, [1,2,3,4]))
                <li>
                    <a href="{{ route('work-order.index') }}" class="waves-effect"><i class="mdi mdi-calendar"></i><span> Work Order </span></a>
                </li>
                @endif

                @if(in_array(auth()->user()->role_id, [1,2,4]))
                <li>
                    <a href="{{ route('maintenance.index') }}" class="waves-effect @if(request()->is('maintenance/*')) active @endif"><i class="mdi mdi-wrench"></i><span> Maintenance </span></a>
                </li>
                @endif

                @if(in_array(auth()->user()->role_id, [1,2,6]))
                <li>
                    <a href="{{ route('inventory.index') }}" class="waves-effect"><i class="fas fa-cubes"></i><span> Inventory </span></a>
                </li>
                @endif

                @if(in_array(auth()->user()->role_id, [1,2]))
                <li>
                    <a href="{{ route('equipment.index') }}" class="waves-effect"><i class="mdi mdi-database"></i><span> Equipment </span></a>
                </li>
                @endif

                @if(in_array(auth()->user()->role_id, [1,2,4]))
                <li>
                    <a href="{{ route('energy-report.index') }}" class="waves-effect"><i class="mdi mdi-flash"></i><span> Energy Report </span></a>
                </li>
                <li>
                    <a href="{{ route('pool-management.index') }}" class="waves-effect"><i class="mdi mdi-pool"></i><span> Pool Management </span></a>
                </li>
                @endif

                @if(in_array(auth()->user()->role_id, [1,2]))
                <li>
                    <a href="{{ route('work-report.index') }}" class="waves-effect @if(request()->is('work-report/*')) active @endif"><i class="mdi mdi-file-document"></i><span> Daily Activities </span></a>
                </li>
                @endif

                @if(in_array(auth()->user()->role_id, [1,2]))
                <li>
                    <a href="{{ route('account.index') }}" class="waves-effect"><i class="mdi mdi-account-multiple"></i><span> Account </span></a>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-desktop-tower"></i><span> Master Data <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="{{ route('master.department.index') }}">Department</a></li>
                        <!-- <li><a href="{{ route('master.energy.index') }}">Energy</a></li> -->
                        <li><a href="{{ route('master.location.index') }}">Location</a></li>
                        <li><a href="{{ route('master.inventory-model.index') }}">Inventory Category</a></li>
                        <li><a href="{{ route('master.equipment-model.index') }}">Equipment & Maintenance</a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
        <div class="clearfix"></div>

    </div>
</div>
