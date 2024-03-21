<div>
    <!-- <li><a class="dropdown-item" wire:click="logout">Logout</a></li> -->
    @if($authuser)
        <ul class="header-menu list-inline d-flex align-items-center mb-0 user-header-dropdown">
            <li class="list-inline-item dropdown">
                <a href="javascript:void(0);" class="d-inline-flex header-item" id="userdropdown"  aria-expanded="false"  onclick="showToggleDropDown(this)">
                    <img src="{{ asset('assets/imgs/usericon.png') }}" alt="Verona Harvey" width="35" height="35" class="rounded-circle me-1 mt-1 mr-2" />
                    <span class="text-left fw-medium icon-down" title="Hi, {{ auth()->user()->name }} ">Hi, {{ auth()->user()->name }} </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu" aria-labelledby="userdropdown">
                  <li><a class="dropdown-item" href="{{ route('account') }}" wire:navigate>Account</a></li>
                  <li><a class="dropdown-item" wire:click="logout">Logout</a></li> 
                </ul>
            </li>
        </ul>
    @else
        <div class="block-signin">
            <a class="text-link-bd-btom hover-up cursor-pointer" id="registerLink">Register</a>
            <a class="btn btn-default btn-shadow ml-40 hover-up " id="loginLink" > Sign in</a>
        </div>      
    @endif
</div>
