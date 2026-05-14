<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('dashboard') }}" class="brand-link">
    <img src="{{ assetUrl('') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
    <span class="brand-text font-weight-light">{{ __('app.app_name') }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>{{ __('app.dashboard') }}</p>
          </a>
        </li>

        @canany(['students.view', 'guardians.view', 'staff.view', 'student_files.view', 'student_room_assignments.view', 'student_update_requests.view'])
        <li
          class="nav-item {{ request()->routeIs('students.*') || request()->routeIs('guardians.*') || request()->routeIs('staff.*') || request()->routeIs('student-files.*') || request()->routeIs('student-room-assignments.*') || request()->routeIs('student-update-requests.*') ? 'menu-open' : '' }}">
          <a href="#"
            class="nav-link {{ request()->routeIs('students.*') || request()->routeIs('guardians.*') || request()->routeIs('staff.*') || request()->routeIs('student-files.*') || request()->routeIs('student-room-assignments.*') || request()->routeIs('student-update-requests.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>{{ __('app.nav_people') }} <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            @can('students.view')
            <li class="nav-item">
              <a href="{{ route('students.index') }}"
                class="nav-link {{ request()->routeIs('students.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.all_students') }}</p>
              </a>
            </li>
            @endcan
            @can('students.create')
            <li class="nav-item">
              <a href="{{ route('students.create') }}"
                class="nav-link {{ request()->routeIs('students.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.add_student') }}</p>
              </a>
            </li>
            @endcan
            @can('guardians.view')
            <li class="nav-item">
              <a href="{{ route('guardians.index') }}"
                class="nav-link {{ request()->routeIs('guardians.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.guardians') }}</p>
              </a>
            </li>
            @endcan
            @can('staff.view')
            <li class="nav-item">
              <a href="{{ route('staff.index') }}"
                class="nav-link {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.staff') }}</p>
              </a>
            </li>
            @endcan
            @can('student_files.view')
            <li class="nav-item">
              <a href="{{ route('student-files.index') }}"
                class="nav-link {{ request()->routeIs('student-files.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.student_files') }}</p>
              </a>
            </li>
            @endcan
            @can('student_room_assignments.view')
            <li class="nav-item">
              <a href="{{ route('student-room-assignments.index') }}"
                class="nav-link {{ request()->routeIs('student-room-assignments.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.student_room_assignments') }}</p>
              </a>
            </li>
            @endcan
            @can('student_update_requests.view')
            <li class="nav-item">
              <a href="{{ route('student-update-requests.index') }}"
                class="nav-link {{ request()->routeIs('student-update-requests.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.student_update_requests') }}</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endcanany

        @canany(['courses.view', 'classes.view', 'enrollments.view', 'academic_years.view', 'shifts.view', 'attendances.view'])
        <li
          class="nav-item {{ request()->routeIs('courses.*') || request()->routeIs('classes.*') || request()->routeIs('enrollments.*') || request()->routeIs('academic-years.*') || request()->routeIs('shifts.*') || request()->routeIs('attendances.*') ? 'menu-open' : '' }}">
          <a href="#"
            class="nav-link {{ request()->routeIs('courses.*') || request()->routeIs('classes.*') || request()->routeIs('enrollments.*') || request()->routeIs('academic-years.*') || request()->routeIs('shifts.*') || request()->routeIs('attendances.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-book"></i>
            <p>{{ __('app.nav_academic') }} <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            @can('courses.view')
            <li class="nav-item">
              <a href="{{ route('courses.index') }}"
                class="nav-link {{ request()->routeIs('courses.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.courses') }}</p>
              </a>
            </li>
            @endcan
            @can('classes.view')
            <li class="nav-item">
              <a href="{{ route('classes.index') }}"
                class="nav-link {{ request()->routeIs('classes.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.classes') }}</p>
              </a>
            </li>
            @endcan
            @can('enrollments.view')
            <li class="nav-item">
              <a href="{{ route('enrollments.index') }}"
                class="nav-link {{ request()->routeIs('enrollments.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.enrollments') }}</p>
              </a>
            </li>
            @endcan
            @can('academic_years.view')
            <li class="nav-item">
              <a href="{{ route('academic-years.index') }}"
                class="nav-link {{ request()->routeIs('academic-years.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.academic_years') }}</p>
              </a>
            </li>
            @endcan
            @can('shifts.view')
            <li class="nav-item">
              <a href="{{ route('shifts.index') }}"
                class="nav-link {{ request()->routeIs('shifts.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.shifts') }}</p>
              </a>
            </li>
            @endcan
            @can('attendances.view')
            <li class="nav-item">
              <a href="{{ route('attendances.index') }}"
                class="nav-link {{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>ការចូលរៀន</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endcanany

        @can('rooms.view')
        <li class="nav-item {{ request()->routeIs('rooms.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-building"></i>
            <p>{{ __('app.nav_facilities') }} <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('rooms.index') }}"
                class="nav-link {{ request()->routeIs('rooms.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.buildings_rooms') }}</p>
              </a>
            </li>
          </ul>
        </li>
        @endcan

        @canany(['fee_types.view', 'invoices.view', 'payments.view'])
        <li class="nav-item {{ request()->routeIs('fees.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('fees.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-dollar-sign"></i>
            <p>{{ __('app.nav_finance') }} <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            @can('fee_types.view')
            <li class="nav-item">
              <a href="{{ route('fees.types') }}"
                class="nav-link {{ request()->routeIs('fees.types') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.fee_types') }}</p>
              </a>
            </li>
            @endcan
            @can('invoices.view')
            <li class="nav-item">
              <a href="{{ route('fees.invoices') }}"
                class="nav-link {{ request()->routeIs('fees.invoices') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.invoices') }}</p>
              </a>
            </li>
            @endcan
            @can('payments.view')
            <li class="nav-item">
              <a href="{{ route('fees.payments') }}"
                class="nav-link {{ request()->routeIs('fees.payments') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.payments') }}</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endcanany

        @canany(['print_templates.view', 'cards.view', 'certificates.view', 'diplomas.view'])
        <li
          class="nav-item {{ request()->routeIs('print-templates.*') || request()->routeIs('student-cards.*') || request()->routeIs('student-certificates.*') || request()->routeIs('student-diplomas.*') ? 'menu-open' : '' }}">
          <a href="#"
            class="nav-link {{ request()->routeIs('print-templates.*') || request()->routeIs('student-cards.*') || request()->routeIs('student-certificates.*') || request()->routeIs('student-diplomas.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-print"></i>
            <p>{{ __('app.nav_print') }} <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            @can('print_templates.view')
            <li class="nav-item">
              <a href="{{ route('print-templates.index') }}"
                class="nav-link {{ request()->routeIs('print-templates.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.print_templates') }}</p>
              </a>
            </li>
            @endcan
            @can('cards.view')
            <li class="nav-item">
              <a href="{{ route('student-cards.index') }}"
                class="nav-link {{ request()->routeIs('student-cards.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.student_cards') }}</p>
              </a>
            </li>
            @endcan
            @can('certificates.view')
            <li class="nav-item">
              <a href="{{ route('student-certificates.index') }}"
                class="nav-link {{ request()->routeIs('student-certificates.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.student_certificates') }}</p>
              </a>
            </li>
            @endcan
            @can('diplomas.view')
            <li class="nav-item">
              <a href="{{ route('student-diplomas.index') }}"
                class="nav-link {{ request()->routeIs('student-diplomas.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.student_diplomas') }}</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endcanany

        @canany(['branches.view', 'users.view', 'roles.view', 'permissions.view'])
        <li
          class="nav-item {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('branches.*') || request()->routeIs('branch-settings.*') ? 'menu-open' : '' }}">
          <a href="#"
            class="nav-link {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('branches.*') || request()->routeIs('branch-settings.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>{{ __('app.nav_administration') }} <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            @can('branches.view')
            <li class="nav-item">
              <a href="{{ route('branches.index') }}"
                class="nav-link {{ request()->routeIs('branches.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.branches') }}</p>
              </a>
            </li>
            @endcan
            @can('users.view')
            <li class="nav-item">
              <a href="{{ route('users.index') }}"
                class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.users') }}</p>
              </a>
            </li>
            @endcan
            @can('roles.view')
            <li class="nav-item">
              <a href="{{ route('roles.index') }}"
                class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.roles') }}</p>
              </a>
            </li>
            @endcan
            @can('permissions.view')
            <li class="nav-item">
              <a href="{{ route('permissions.index') }}"
                class="nav-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.permissions') }}</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endcanany

        @canany(['genders.view', 'locations.view', 'file_protection_rules.view'])
        <li
          class="nav-item {{ request()->routeIs('genders.*') || request()->routeIs('locations.*') || request()->routeIs('file-protection-rules.*') ? 'menu-open' : '' }}">
          <a href="#"
            class="nav-link {{ request()->routeIs('genders.*') || request()->routeIs('locations.*') || request()->routeIs('file-protection-rules.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cog"></i>
            <p>{{ __('app.nav_settings') }} <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            @can('genders.view')
            <li class="nav-item">
              <a href="{{ route('genders.index') }}"
                class="nav-link {{ request()->routeIs('genders.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.genders') }}</p>
              </a>
            </li>
            @endcan
            @can('locations.view')
            <li class="nav-item">
              <a href="{{ route('locations.index') }}"
                class="nav-link {{ request()->routeIs('locations.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.locations') }}</p>
              </a>
            </li>
            @endcan
            @can('file_protection_rules.view')
            <li class="nav-item">
              <a href="{{ route('file-protection-rules.index') }}"
                class="nav-link {{ request()->routeIs('file-protection-rules.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.file_protection') }}</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endcanany

        @can('reports.view')
        <li class="nav-item {{ request()->routeIs('reports.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>{{ __('app.reports') }} <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('reports.index') }}"
                class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.report_catalog') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.students') }}"
                class="nav-link {{ request()->routeIs('reports.students') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.student_master_list') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.new_admissions') }}"
                class="nav-link {{ request()->routeIs('reports.new_admissions') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.new_admissions') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.class_roster') }}"
                class="nav-link {{ request()->routeIs('reports.class_roster') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.class_roster') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.monthly_attendance') }}"
                class="nav-link {{ request()->routeIs('reports.monthly_attendance') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.monthly_attendance') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.daily_cash_receipts') }}"
                class="nav-link {{ request()->routeIs('reports.daily_cash_receipts') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.daily_cash_receipts') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.ar_aging') }}"
                class="nav-link {{ request()->routeIs('reports.ar_aging') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.ar_aging') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.revenue') }}"
                class="nav-link {{ request()->routeIs('reports.revenue') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.revenue_report') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('reports.fee_statement') }}"
                class="nav-link {{ request()->routeIs('reports.fee_statement') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.fee_statement') }}</p>
              </a>
            </li>
          </ul>
        </li>
        @endcan

        @canany(['audit_logs.view', 'report_logs.view', 'export_logs.view', 'print_logs.view', 'file_access_logs.view'])
        <li
          class="nav-item {{ request()->routeIs('audit-logs.*') || request()->routeIs('report-logs.*') || request()->routeIs('export-logs.*') || request()->routeIs('print-logs.*') || request()->routeIs('file-access-logs.*') ? 'menu-open' : '' }}">
          <a href="#"
            class="nav-link {{ request()->routeIs('audit-logs.*') || request()->routeIs('report-logs.*') || request()->routeIs('export-logs.*') || request()->routeIs('print-logs.*') || request()->routeIs('file-access-logs.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-history"></i>
            <p>{{ __('app.nav_logs') }} <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            @can('audit_logs.view')
            <li class="nav-item">
              <a href="{{ route('audit-logs.index') }}"
                class="nav-link {{ request()->routeIs('audit-logs.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.audit_logs') }}</p>
              </a>
            </li>
            @endcan
            @can('report_logs.view')
            <li class="nav-item">
              <a href="{{ route('report-logs.index') }}"
                class="nav-link {{ request()->routeIs('report-logs.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.report_logs') }}</p>
              </a>
            </li>
            @endcan
            @can('export_logs.view')
            <li class="nav-item">
              <a href="{{ route('export-logs.index') }}"
                class="nav-link {{ request()->routeIs('export-logs.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.export_logs') }}</p>
              </a>
            </li>
            @endcan
            @can('print_logs.view')
            <li class="nav-item">
              <a href="{{ route('print-logs.index') }}"
                class="nav-link {{ request()->routeIs('print-logs.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.print_logs') }}</p>
              </a>
            </li>
            @endcan
            @can('file_access_logs.view')
            <li class="nav-item">
              <a href="{{ route('file-access-logs.index') }}"
                class="nav-link {{ request()->routeIs('file-access-logs.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('app.file_access_logs') }}</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endcanany

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
