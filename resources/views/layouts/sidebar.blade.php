<div id="sidebar" class="app-sidebar">
    <div class="app-sidebar-content find-link" data-scrollbar="true" data-height="100%">
        <div class="menu">
            <div class="menu-header">Navigation</div>

            <div class="menu-item">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <div class="menu-icon"> <i class="fa fa-home"></i> </div>
                    <div class="menu-text">Dashboard</div>
                </a>
            </div>
            @if (Auth::user()->role_id == 1)
                <div class="menu-item has-sub"> <a href="javascript:;" class="menu-link">
                        <div class="menu-icon"> <i class="fas fa-list"></i> </div>
                        <div class="menu-text">Member Management</div>
                        <div class="menu-caret"></div>
                    </a>
                    <div class="menu-submenu">
                        <div class="menu-item">
                            <a href="{{ route('roles') }}" class="menu-link">
                                <div class="menu-text">Manage Roles</div>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a href="{{ route('member') }}" class="menu-link">
                                <div class="menu-text">Members</div>
                            </a>
                        </div>
                        <div class="menu-item d-none">
                            <a href="{{ route('borrower') }}" class="menu-link d-none">
                                <div class="menu-text">Borrowers</div>
                            </a>
                        </div>
                        <div class="menu-item d-none">
                            <a href="{{ route('userlocation') }}" class="menu-link d-none">
                                <div class="menu-text">User Location</div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="menu-item has-sub"> <a href="javascript:;" class="menu-link d-none">
                        <div class="menu-icon"> <i class="fas fa-list"></i> </div>
                        <div class="menu-text">Route Management</div>
                        <div class="menu-caret"></div>
                    </a>
                    <div class="menu-submenu">
                        <div class="menu-item">
                            <a href="{{ route('route') }}" class="menu-link d-none">
                                <div class="menu-text">Route Creation </div>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a href="{{ route('routeassign') }}" class="menu-link d-none">
                                <div class="menu-text">Route Assign</div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="menu-item has-sub"> <a href="javascript:;" class="menu-link d-none">
                        <div class="menu-icon"> <i class="fas fa-list"></i> </div>
                        <div class="menu-text">Service Management</div>
                        <div class="menu-caret"></div>
                    </a>
                    <div class="menu-submenu">
                        <div class="menu-item">
                            <a href="{{ route('providers') }}" class="menu-link d-none">
                                <div class="menu-text">Manage Service </div>
                            </a>
                        </div>

                    </div>
                </div>
            @endif
            @if (Auth::user()->role_id == 5 || Auth::user()->role_id == 1)
                <div class="menu-item has-sub"> <a href="javascript:;" class="menu-link d-none">
                        <div class="menu-icon"> <i class="fas fa-list"></i> </div>
                        <div class="menu-text">Lead Management</div>
                        <div class="menu-caret"></div>
                    </a>
                    <div class="menu-submenu">
                        <div class="menu-item">
                            <a href="{{ route('lead.create') }}" class="menu-link d-none">
                                <div class="menu-text">Create Lead</div>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a href="{{ route('lead') }}" class="menu-link d-none">
                                <div class="menu-text">Lead Manager</div>
                            </a>
                        </div>
                        @if (Auth::user()->role_id == 1)
                            {{-- <div class="menu-item">
                        <a href="{{ route('lead.admin') }}" class="menu-link d-none">
                            <div class="menu-text">Lead Manager Admin</div>
                        </a>
                    </div> --}}
                            <div class="menu-item">
                                <a href="{{ route('lead.qualified') }}" class="menu-link d-none">
                                    <div class="menu-text">Qualified Leads</div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                @endif
                @if (Auth::user()->role_id == 1)
                <div class="menu-item has-sub"> <a href="javascript:;" class="menu-link d-none">
                    <div class="menu-icon"> <i class="fas fa-list"></i> </div>
                    <div class="menu-text">Bank Details</div>
                    <div class="menu-caret"></div>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item">
                            <a href="{{ route('payment_mode') }}" class="menu-link d-none">
                                <div class="menu-text">Manage Payment Mode </div>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a href="{{ route('bank') }}" class="menu-link d-none">
                                <div class="menu-text">Bank Detail </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="menu-item has-sub"> <a href="javascript:;" class="menu-link d-none">
                        <div class="menu-icon"> <i class="fas fa-list"></i> </div>
                        <div class="menu-text">Reports</div>
                        <div class="menu-caret"></div>
                    </a>
                    <div class="menu-submenu">
                        <div class="menu-item">
                            <a href="{{ route('payment_mode') }}" class="menu-link d-none">
                                <div class="menu-text">Today Collection </div>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a href="{{ route('bank') }}" class="menu-link d-none">
                                <div class="menu-text">Today Disbursment </div>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a href="{{ route('bank') }}" class="menu-link d-none">
                                <div class="menu-text">Emi </div>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a href="{{ route('bank') }}" class="menu-link d-none">
                                <div class="menu-text">Loans </div>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a href="{{ route('bank') }}" class="menu-link d-none">
                                <div class="menu-text">Overdue Emi </div>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a href="{{ route('bank') }}" class="menu-link d-none">
                                <div class="menu-text">Day Book </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="menu-item has-sub"> <a href="javascript:;" class="menu-link d-none">
                    <div class="menu-icon"> <i class="fas fa-list"></i> </div>
                    <div class="menu-text">Site Setting</div>
                    <div class="menu-caret"></div>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item">
                        <a href="{{ route('company.edit', 1) }}" class="menu-link d-none">
                            <div class="menu-text">Manage Site Setting</div>
                        </a>
                    </div>
                </div>
            </div>
                @endif

            <div class="menu-item d-flex"> <a href="javascript:;" class="app-sidebar-minify-btn ms-auto"
                    data-toggle="app-sidebar-minify"><i class="fa fa-angle-double-left"></i></a> </div>
        </div>
    </div>
</div>
