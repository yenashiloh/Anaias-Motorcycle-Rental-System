//navigation motorcycle
document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.nav-item.nav-link');

    function setActiveLink() {
        const currentPath = window.location.pathname;
        const currentHash = window.location.hash;
        const currentSection = currentHash.slice(1) || 'home';

        navLinks.forEach(link => {
            const section = link.getAttribute('data-section');
            if (currentPath === '/' || currentPath === '/home') {
                link.classList.toggle('active', section === currentSection);
            } else if (currentPath.startsWith('/details-motorcycle')) {
                link.classList.toggle('active', section === 'motorcycles');
            } else {
                link.classList.toggle('active', `/${section}` === currentPath);
            }
        });
    }

    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            const section = this.getAttribute('data-section');

            if (section !== 'motorcycles' && (window.location.pathname === '/' || window.location.pathname === '/home')) {
                e.preventDefault();
                const targetElement = document.getElementById(section);

                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                    history.pushState(null, '', href);
                    setActiveLink();
                }
            } else {
                setActiveLink();
            }
        });
    });

    setActiveLink();
    window.addEventListener('popstate', setActiveLink);
});

//logout sweet alert
document.getElementById('logoutButton').addEventListener('click', function () {
    Swal.fire({
        title: 'Logout',
        text: "Are you sure you want to logout?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, logout!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logoutForm').submit();
        }
    });
});

//fetch notification
document.addEventListener("DOMContentLoaded", function () {
    fetchNotifications();

    function fetchNotifications() {
        fetch('/notifications')
            .then(response => {
                if (response.status === 401) {
                    displayNotifications([]);
                    return;
                }
                return response.json();
            })
            .then(data => {
                displayNotifications(data);
            })
            .catch(error => console.error('Error fetching notifications:', error));
    }

    function displayNotifications(notifications) {
        const notificationList = document.getElementById('notificationList');
        const notificationBadge = document.querySelector('.notification-bell + .badge');
    
        notificationList.innerHTML = `
            <li><div class="dropdown-title text-center">Notifications</div></li>
            <li><hr class="dropdown-divider"></li>
        `;
    
        if (Array.isArray(notifications) && notifications.length > 0) {
            const unreadCount = notifications.filter(notification => !notification.read).length;
            if (unreadCount > 0) {
                notificationBadge.textContent = unreadCount;
                notificationBadge.style.display = 'flex';
            } else {
                notificationBadge.style.display = 'none';
            }
    
            notifications.forEach(notification => {
                const notificationItem = document.createElement('li');
                const formattedTime = formatTime(new Date(notification.created_at));
    
                const historyUrl = `/history/view/${notification.reservation_id}#violations-section`;
    
                let notificationItemHTML = `
                                <a class="dropdown-item${!notification.read ? ' new-notification' : ''}" href="${historyUrl}">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle fa-1x me-2 text-danger"></i>
                            <div>
                                <p class="mb-0"><strong>Admin</strong></p>
                                <p class="mb-0 small">${notification.message}</p>
                                <small class="time">${formattedTime}</small>
                            </div>
                        </div>
                    </a>
                `;
                notificationItem.innerHTML = notificationItemHTML;
                notificationList.appendChild(notificationItem);
    
                if (!notification.read) {
                    notificationItem.querySelector('a').classList.add('new-notification');
                }
            });
        } else {
            notificationBadge.style.display = 'none';
            notificationList.innerHTML += '<li><p class="text-center">No new notifications</p></li>';
        }
    
        const notificationItems = notificationList.querySelectorAll('li');
        if (notificationItems.length > 5) {
            notificationList.style.maxHeight = '400px';
            notificationList.style.overflowY = 'auto';
        } else {
            notificationList.style.maxHeight = 'none';
            notificationList.style.overflowY = 'visible';
        }
    }
    
    function formatTime(date) {
        const now = new Date();
        const secondsElapsed = Math.floor((now - date) / 1000);
        
        if (secondsElapsed < 60) {
            return `${secondsElapsed} second${secondsElapsed === 1 ? '' : 's'} ago`;
        } else if (secondsElapsed < 3600) {
            const minutesElapsed = Math.floor(secondsElapsed / 60);
            return `${minutesElapsed} minute${minutesElapsed === 1 ? '' : 's'} ago`;
        } else if (secondsElapsed < 86400) {
            const hoursElapsed = Math.floor(secondsElapsed / 3600);
            return `${hoursElapsed} hour${hoursElapsed === 1 ? '' : 's'} ago`;
        } else {
            return date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
        }
    }
});

const notificationBell = document.getElementById('notificationDropdown');
notificationBell.addEventListener('click', markNotificationsAsRead);

function markNotificationsAsRead() {
    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
    if (!csrfTokenElement) {
        console.error('Meta tag for CSRF token not found');
        return;
    }

    fetch('/notifications/mark-as-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': csrfTokenElement.getAttribute('content')
        }
    })
    .then(response => {
        if (response.ok) {
            const notificationBadge = document.querySelector('.notification-bell + .badge');
            if (notificationBadge) {
                notificationBadge.style.display = 'none';
            }

            fetchNotifications();
        } else {
            console.error('Failed to mark notifications as read', response.statusText);
        }
    })
    .catch(error => {
        console.error('Error marking notifications as read:', error);
    });
}
