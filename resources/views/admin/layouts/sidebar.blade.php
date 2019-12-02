<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <!-- brand -->
    <div class="sidebar-brand">
      <a href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>
    </div>
    <!-- shortbrand -->
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ route('home') }}">{{ config('app.shortname', 'LV') }}</a>
    </div>

    <!-- menu -->
    <ul class="sidebar-menu">
      <!-- dahsboard header -->
      <li class="menu-header">{{ __('Dashboard') }}</li>

      <!-- home -->
      <li class="{{ (request()->is('admin/home')?'active':'') }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="fa fa-home"></i> <span>{{ __('Home') }}</span>
        </a>
      </li>

      <!-- menu header -->
      <li class="menu-header">{{ __('Menu') }}</li>

      <!-- competition -->
      <li class="{{ (request()->is('admin/competition')||request()->is('/admin/competition/*')?'active':'') }}">
        <a class="nav-link" href="{{ route('admin.competition.index') }}">
          <i class="fa fa-trophy"></i> <span>{{ __('Competition') }}</span>
        </a>
      </li>

      <!-- contest -->
      <li class="{{ (request()->is('admin/contest')||request()->is('/admin/contest/*')?'active':'') }}">
        <a class="nav-link" href="{{ route('admin.contest.index') }}">
          <i class="fas fa-flag-checkered"></i><span>{{ __('Contest') }}</span>
        </a>
      </li>

      <!-- school -->
      <li class="{{ (request()->is('admin/school')||request()->is('/admin/school/*')?'active':'') }}">
        <a class="nav-link" href="{{ route('admin.school.index') }}">
          <i class="fa fa-university"></i> <span>{{ __('Schools') }}</span>
        </a>
      </li>

      <!-- setting -->
      <li class="dropdown {{ (request()->is('admin/user')||request()->is('admin/user/*')||request()->is('admin/juri')||request()->is('admin/juri/*')||request()->is('admin/administrator')||request()->is('admin/administrator/*')?'active':'') }}">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa fa-cogs"></i> <span>{{ __('Settings') }}</span></a>
        <ul class="dropdown-menu">
          <li class="{{ (request()->is('admin/administrator')||request()->is('admin/administrator/*')?'active':'') }}"><a class="nav-link" href="{{ route('admin.administrator.index') }}">{{ __('Administrator') }}</a></li>
          <li class="{{ (request()->is('admin/juri')||request()->is('admin/juri/*')?'active':'') }}"><a class="nav-link" href="{{ route('admin.juri.index') }}">{{ __('Judges') }}</a></li>
          <li class="{{ (request()->is('admin/user')||request()->is('admin/user/*')?'active':'') }}"><a class="nav-link" href="{{ route('admin.user.index') }}">{{ __('Users') }}</a></li>
        </ul>
      </li>

      <!-- logout header -->
      <li class="menu-header">{{ __('Logout') }}</li>
      <li>
        <!-- logout -->
        <a class="nav-link text-danger" href="{{ route('logout') }}"
          onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i> <span>{{ __('Logout') }}</span>
        </a>
      </li>
    </ul>
  </aside>
</div>