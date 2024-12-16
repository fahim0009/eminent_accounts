<nav class="mt-2 mb-5">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      
           
      <li class="nav-item">
        <a href="{{route('admin.dashboard')}}" class="nav-link {{ (request()->is('admin/dashboard*')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('alladmin')}}" class="nav-link {{ (request()->is('admin/new-admin*')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Admin
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('admin.agent')}}" class="nav-link {{ (request()->is('admin/agent*')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Agent
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('admin.vendor')}}" class="nav-link {{ (request()->is('admin/vendor*')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Vendor
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('admin.setting')}}" class="nav-link {{ (request()->is('admin/setting*')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Setting
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('admin.account')}}" class="nav-link {{ (request()->is('admin/account*')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Account
          </p>
        </a>
      </li>
      {{-- <li class="nav-item">
        <a href="{{route('admin.businesspartner')}}" class="nav-link {{ (request()->is('admin/business-partner*')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Business Partner
          </p>
        </a>
      </li> --}}
      

      
      <li class="nav-item {{ (request()->is('admin/client*')) ? 'menu-open' : '' }}{{ (request()->is('admin/completed-clients*')) ? 'menu-open' : '' }}{{ (request()->is('admin/decline-clients*')) ? 'menu-open' : '' }}{{ (request()->is('admin/processing-clients*')) ? 'menu-open' : '' }}{{ (request()->is('admin/new-clients*')) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ (request()->is('admin/client*')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-copy"></i>
          <p>
            KSA with Job Client
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('admin.newclient')}}" class="nav-link {{ (request()->is('admin/new-clients*')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>New</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.processingclient')}}" class="nav-link {{ (request()->is('admin/processing-clients*')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Processing</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.completedclient')}}" class="nav-link {{ (request()->is('admin/completed-clients*')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Complete</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.declineclient')}}" class="nav-link {{ (request()->is('admin/decline-clients*')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Decline</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{route('admin.client')}}" class="nav-link {{ (request()->is('admin/client*')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>All Clients</p>
            </a>
          </li>

        </ul>
      </li>


      <li class="nav-item {{ (request()->is('admin/ksa-without-job-client*')) ? 'menu-open' : '' }}{{ (request()->is('admin/ksa-without-job-completed-clients*')) ? 'menu-open' : '' }}{{ (request()->is('admin/ksa-without-job-decline-clients*')) ? 'menu-open' : '' }}{{ (request()->is('admin/ksa-without-job-processing-clients*')) ? 'menu-open' : '' }}{{ (request()->is('admin/ksa-without-job-new-clients*')) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ (request()->is('admin/ksa-without-job*')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-copy"></i>
          <p>
            KSA without Job Client
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          
          <li class="nav-item">
            <a href="{{route('withoutjob.newclient')}}" class="nav-link {{ (request()->is('admin/ksa-without-job-new-clients*')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>New</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('withoutjob.processingclient')}}" class="nav-link {{ (request()->is('admin/ksa-without-job-processing-clients*')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Processing</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('withoutjob.completedclient')}}" class="nav-link {{ (request()->is('admin/ksa-without-job-completed-clients*')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Complete</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('withoutjob.declineclient')}}" class="nav-link {{ (request()->is('admin/ksa-without-job-decline-clients*')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Decline</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{route('withoutjob.client')}}" class="nav-link {{ (request()->is('admin/ksa-without-job-client*')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>All Clients</p>
            </a>
          </li>

        </ul>
      </li>


      <li class="nav-item">
        <a href="{{route('admin.loan')}}" class="nav-link {{ (request()->is('admin/loan*')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Loan
          </p>
        </a>
      </li>


      <li class="nav-item {{ (request()->is('admin/kafela-client*')) ? 'menu-open' : '' }}{{ (request()->is('admin/kafela-completed-clients*')) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ (request()->is('admin/kafela-client*')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-copy"></i>
          <p>
            Kafela Clients
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('admin.kafelaclient')}}" class="nav-link {{ (request()->is('admin/kafela-client*')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Processing</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.kafelacompletedclient')}}" class="nav-link {{ (request()->is('admin/kafela-completed-clients*')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Complete</p>
            </a>
          </li>
          

        </ul>
      </li>

      
      


      <li class="nav-item {{ (request()->is('admin/okala')) ? 'menu-open' : '' }} {{ (request()->is('admin/okala-assigned')) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ (request()->is('admin/okala')) ? 'active' : '' }} {{ (request()->is('admin/okala-assigned')) ? 'menu-open' : '' }}">
          <i class="nav-icon fas fa-table"></i>
          <p>
            My Okala
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>

        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('admin.okala')}}" class="nav-link {{ (request()->is('admin/okala')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Okala Details</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.assignokala')}}" class="nav-link {{ (request()->is('admin/okala-assigned')) ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Assigned</p>
            </a>
          </li>

        </ul>
      </li>
      <li class="nav-item">
        <a href="{{route('admin.okalapurchase')}}" class="nav-link {{ (request()->is('admin/okala-purchase')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-th"></i>
          <p>Okala Purchase</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('admin.okalasales')}}" class="nav-link {{ (request()->is('admin/okala-sales')) ? 'active' : '' }}">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Okala Sales
          </p>
        </a>
      </li>




    </ul>
  </nav>