@php
    $role = Auth::user()->role ?? 'user';
    $dashboardRoute = match ($role) {
        'admin' => route('dashboard.admin'),
        'restaurant' => route('dashboard.restaurant'),
        default => route('dashboard.user'),
    };
    $panels = [
        'admin' => ['label' => 'Admin Panel', 'route' => route('dashboard.admin')],
        'restaurant' => ['label' => 'Restaurant Panel', 'route' => route('dashboard.restaurant')],
        'user' => ['label' => 'User Home', 'route' => route('dashboard.user')],
    ];
    $panel = $panels[$role] ?? $panels['user'];
@endphp
 
<style>
    .nav-link.active {
        font-weight: bold;
        color: #0d6efd; /* Bootstrap primary color */
    }

</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <!-- Brand / Logo -->
        <a class="navbar-brand" href="{{ $dashboardRoute }}">
            <x-application-logo style="height:40px;" />
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Dashboard Link -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->url() === $dashboardRoute ? 'active' : '' }}" href="{{ $dashboardRoute }}">
                        Dashboard
                    </a>
                </li>

                <!-- Role-based Panel -->
                @if($role !== 'user')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->url() === $panel['route'] ? 'active' : '' }}" href="{{ $panel['route'] }}">
                            {{ $panel['label'] }}
                        </a>
                    </li>
                @endif
            </ul>

            <!-- Profile Dropdown on the right -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Log Out
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
