  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('dashboard') }}" class="nav-link" data-i18n="dashboard">{{ __('app.dashboard') }}</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Language Switcher (no page refresh) -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
          aria-expanded="false">
          <i class="fas fa-globe mr-1"></i>
          <span class="lang-current-label d-none d-sm-inline">{{ app()->getLocale() === 'km' ? 'ខ្មែរ' : 'EN' }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="javascript:void(0)" onclick="switchLocale('en')"
            class="dropdown-item lang-switcher-item {{ app()->getLocale() === 'en' ? 'active' : '' }}" data-locale="en">
            <span class="font-weight-bold">EN</span> &nbsp; English
          </a>
          <a href="javascript:void(0)" onclick="switchLocale('km')"
            class="dropdown-item lang-switcher-item {{ app()->getLocale() === 'km' ? 'active' : '' }}" data-locale="km">
            <span class="font-weight-bold">KH</span> &nbsp; ខ្មែរ
          </a>
        </div>
      </li>

      <!-- User Account Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">
          <i class="far fa-user-circle mr-1"></i>
          <span class="d-none d-sm-inline">{{ auth()->user()->name ?? 'Admin' }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="{{ route('profile.edit') }}" class="dropdown-item">
            <i class="fas fa-user-cog mr-2"></i> Profile
          </a>
          <div class="dropdown-divider"></div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item text-danger">
              <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
          </form>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
