<style>
.unread {
    background-color: #e6f2ff; 
}

.read {
    background-color: #f8f9fa; 
    opacity: 0.7; 
}

.notif-item:hover {
    background-color: #f1f3f5;
    cursor: pointer;
}
</style>
<div class="main-panel">
  <div class="main-header">
    <div class="main-header-logo">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="white">
        <a href="index.html" class="logo">
          <img
            src="../../../../admin-assets-final/img/kaiadmin/logo_light.svg"
            alt="navbar brand"
            class="navbar-brand"
            height="20"
          />
        </a>
        <div class="nav-toggle">
          <button class="btn btn-toggle toggle-sidebar">
            <i class="gg-menu-right"></i>
          </button>
          <button class="btn btn-toggle sidenav-toggler">
            <i class="gg-menu-left"></i>
          </button>
        </div>
        <button class="topbar-toggler more">
          <i class="gg-more-vertical-alt"></i>
        </button>
      </div>
      <!-- End Logo Header -->
    </div>
    <!-- Navbar Header -->
    <nav
      class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
    >
      <div class="container-fluid">
        <nav
          class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
        >
          
        </nav>

        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
          <li class="nav-item topbar-icon dropdown hidden-caret">
            <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell"></i>
                <span class="notification" id="notifCount" style="display: none;">0</span>
            </a>
            <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                <li>
                    <div class="dropdown-title">
                        Notifications
                    </div>
                </li>
                <li>
                    <div class="notif-scroll scrollbar-outer">
                        <div class="notif-center" id="notifList">
                        </div>
                    </div>
                </li>
            </ul>
        </li>
      
          <li class="nav-item topbar-user dropdown hidden-caret">
            <a
              class="dropdown-toggle profile-pic"
              data-bs-toggle="dropdown"
              href="#"
              aria-expanded="false"
            >
            <div class="avatar-sm">
              <i class="fas fa-user-circle avatar-img rounded-circle" style="font-size: 37px;"></i>
          </div>
          <span class="profile-username">
              <span class="fw-bold">{{ $admin->first_name }} {{ $admin->last_name }}</span>
          </span>
          
            </a>
            <ul class="dropdown-menu dropdown-user animated fadeIn">
              <div class="dropdown-user-scroll scrollbar-outer">
                <li>
                  <div class="user-box">
                    <div class="avatar-sm">
                      <i class="fas fa-user-circle avatar-img rounded-circle" style="font-size: 43px;"></i>
                  </div>
                    <div class="u-text">
                      <h4>{{ $admin->first_name }} {{ $admin->last_name }}</h4>
                      <p class="text-muted">{{ $admin->email }}</p>
                      {{-- <a
                        href="profile.html"
                        class="btn btn-xs btn-secondary btn-sm"
                        >View Profile</a
                      > --}}
                    </div>
                  </div>
                </li>
                <li>
                  <div class="dropdown-divider"></div>
                  {{-- <a class="dropdown-item" href="#">My Profile</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Account Setting</a>
                  <div class="dropdown-divider"></div> --}}
                  <a class="dropdown-item" href="#" id="logoutLink">Logout</a>
                </li>
              </div>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  <!-- End Navbar -->
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
       const notifCount = document.getElementById("notifCount");
       const notifList = document.getElementById("notifList");
       const notifDropdownTitle = document.querySelector('.dropdown-title');
       let notifications = [];
   
       notifCount.style.display = 'none';
   
       function fetchNotifications() {
           fetch("{{ route('admin.notifications') }}")
               .then(response => response.json())
               .then(data => {
                   notifications = data;
                   notifList.innerHTML = '';
                   let unreadCount = 0;
   
                   if (notifications.length === 0) {
                       notifList.innerHTML = `<li><div class="notif-content text-center">No new notifications.</div></li>`;
                       notifDropdownTitle.textContent = 'Notifications';
                   } else {
                       notifDropdownTitle.textContent = `Notifications`;
   
                       notifications.forEach(notification => {
                           if (!notification.read) {
                               unreadCount++;
                           }
   
                           const createdAt = new Date(notification.created_at);
                           const timeDiff = new Date() - createdAt;
                           let formattedTime = getRelativeTime(timeDiff);
   
                           const notifItem = document.createElement("li");
                           notifItem.classList.add(notification.read ? 'read' : 'unread');
                           notifItem.innerHTML = `
                               <a href="#" class="notif-item">
                                   <div class="notif-icon notif-primary">
                                       <i class="fa fa-user"></i>
                                   </div>
                                   <div class="notif-content">
                                       <span class="block">${notification.message}</span>
                                       <span class="time">${formattedTime}</span>
                                   </div>
                               </a>
                           `;
   
                           notifItem.addEventListener("click", function() {
                               markNotificationAsRead(notification.id);
                           });
   
                           notifList.appendChild(notifItem);
                       });
   
                       notifCount.textContent = unreadCount > 0 ? unreadCount : '';
                       notifCount.style.display = unreadCount > 0 ? 'inline' : 'none';
                   }
               })
               .catch(error => console.error('Error fetching notifications:', error));
       }
   
       document.getElementById("notifDropdown").addEventListener("click", function() {
       markAllAsRead();
   });
   
   function markAllAsRead() {
       fetch('/admin/notifications/markAllRead', {
           method: 'POST',
           headers: {
               'Content-Type': 'application/json',
               'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
           }
       })
       .then(response => response.json())
       .then(data => {
           if (data.success) {
               notifCount.textContent = '';
               notifCount.style.display = 'none';
               fetchNotifications();
           }
       })
       .catch(error => console.error('Error marking all notifications as read:', error));
   }
   
       function getRelativeTime(timeDiff) {
           const seconds = Math.floor(timeDiff / 1000);
           const minutes = Math.floor(seconds / 60);
           const hours = Math.floor(minutes / 60);
           const days = Math.floor(hours / 24);
   
           if (seconds < 60) {
               return `${seconds} second${seconds !== 1 ? 's' : ''} ago`;
           } else if (minutes < 60) {
               return `${minutes} minute${minutes !== 1 ? 's' : ''} ago`;
           } else if (hours < 24) {
               return `${hours} hour${hours !== 1 ? 's' : ''} ago`;
           } else if (days < 7) {
               return `${days} day${days !== 1 ? 's' : ''} ago`;
           } else {
               return new Date(timeDiff).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
           }
       }
   
       document.getElementById("notifDropdown").addEventListener("click", function() {
           markAllAsRead();
       });
   
       setInterval(fetchNotifications, 30000);
       fetchNotifications();
   });
   
   </script>
   
    