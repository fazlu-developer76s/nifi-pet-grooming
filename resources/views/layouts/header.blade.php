
<div id="header" class="app-header">
    <div class="navbar-header"> <a href="{{ route('dashboard') }}" class="navbar-brand"><img src="{{ asset('storage/'.$company->favicon) }}"></a>

        <button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile"> <span
                class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    </div>
    <div class="navbar-nav">
        <!-- Dropdown Button -->
       


        {{-- <a href="{{ route('lead.create') }}"><button class="btn btn-primary">Add Lead</button></a> --}}
        <div class="navbar-item navbar-user dropdown">
            <a href="#"
                class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"> <img
                    src="{{ asset('assets/img/user.png') }}" /> <span> <span class="d-none d-md-inline">{{ Auth::user()->name }}</span> <b
                        class="caret"></b> </span>
                     </a>
            <div class="dropdown-menu dropdown-menu-end me-1">
                {{-- <a href="javascript:;" class="dropdown-item">Edit Profile</a>
                <a href="javascript:;" class="dropdown-item">Change Password</a>
                <a href="manage-contact.php" class="dropdown-item">Setting</a> --}}
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

            </div>
        </div>
    </div>
</div>
