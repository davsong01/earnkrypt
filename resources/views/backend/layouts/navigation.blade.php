<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                 <!-- Admin only -->
                <li class="sidebar-item {{ Request::is('/') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/" aria-expanded="false" target="_blank"><i class="fa fa-home"></i><span class="hide-menu">Home</span></a></li>

                @if(auth()->user()->user_types != 1)
                    <li class="sidebar-item {{ Request::is('dashboard') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/dashboard" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                    <li class="sidebar-item {{ Request::is('tasks*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('tasks.index') }}" aria-expanded="false"><i class="fa fa-list"></i><span class="hide-menu">Tasks</span></a></li>

                    <li class="sidebar-item {{ Request::is('plans*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('plans.index') }}" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Plans</span></a></li>
                    <li class="sidebar-item {{ Request::is('vendor*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('vendor.index') }}" aria-expanded="false"><i class="fa fa-industry"></i><span class="hide-menu">Vendor Management</span></a></li>

                    <li class="sidebar-item {{ Request::is('user*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('user.index') }}" aria-expanded="false"><i class="ti-user"></i><span class="hide-menu">Subscribers</span></a></li>
                    <li class="sidebar-item {{ Request::is('withdraw*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('withdraw.index') }}" aria-expanded="false"><i class="mdi mdi-wallet-travel"></i><span class="hide-menu">Withdrawals</span></a></li>
                    <li class="sidebar-item {{ Request::is('advert*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('advert.index') }}" aria-expanded="false"><i class="fa fa-trophy" aria-hidden="true"></i><span class="hide-menu">Advert Placements</span></a></li>
                    <li class="sidebar-item {{ Request::is('design*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('design.index') }}" aria-expanded="false"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="hide-menu">Design Orders</span></a></li>

                    <li class="sidebar-item {{ Request::is('medal*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('medal.index') }}" aria-expanded="false"><i class="fa fa-certificate"></i><span class="hide-menu">Medals</span></a></li>
                    
                    <li class="sidebar-item {{ Request::is('admins*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admins.index') }}" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu"> System Admins</span></a></li>
                    <li class="sidebar-item {{ Request::is('transaction*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('transaction.index') }}" aria-expanded="false"><i class="fa fa-bitcoin"></i><span class="hide-menu">Transactions</span></a></li>
                    <li class="sidebar-item {{ Request::is('setting*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('setting.index') }}" aria-expanded="false"><i class="mdi mdi-settings"></i><span class="hide-menu">Settings</span></a></li>
                @endif
                @if(auth()->user()->user_types == 1)
                <li class="sidebar-item {{ Request::is('promote*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('promote.index') }}" aria-expanded="false"><i class="fa fa-play"></i><span class="hide-menu">Promote</span></a></li>
                <li class="sidebar-item {{ Request::is('withdraw*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('withdraw.index') }}" aria-expanded="false"><i class="mdi mdi-wallet-travel"></i><span class="hide-menu">Withdrawals</span></a></li>
                <li class="sidebar-item {{ Request::is('referral*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('referrals') }}" aria-expanded="false"><i class="mdi mdi-share-variant"></i><span class="hide-menu">Referrals</span></a></li>
                <li class="sidebar-item {{ Request::is('medal*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('medals.get') }}" aria-expanded="false"><i class="fa fa-certificate"></i><span class="hide-menu">Medals</span></a></li>
                <li class="sidebar-item {{ Request::is('profile*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('profile.edit', auth()->user()->id) }}" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Account</span></a></li>
                <li class="sidebar-item {{ Request::is('advert*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('advert.index') }}" aria-expanded="false"><i class="fa fa-trophy" aria-hidden="true"></i><span class="hide-menu">Advert Placements</span></a></li>  
                <li class="sidebar-item {{ Request::is('design*') ? 'active' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('design.index') }}" aria-expanded="false"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="hide-menu">Order a design</span></a></li>
                @endif
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" aria-expanded="false"><i class="fas fa-sign-out-alt"></i>&nbsp Sign out</span></a></li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </nav>
    </div>
</aside>