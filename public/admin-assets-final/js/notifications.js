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
    
                        const notificationLink = `{{ route('admin.reservation.view-bookings', ':id') }}`.replace(':id', notification.reservation_id);
    
                        notifItem.innerHTML = `
                            <div class="notif-item" data-href="${notificationLink}">
                                <div class="notif-icon notif-primary">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="notif-content">
                                    <span class="block">${notification.message}</span>
                                    <span class="time">${formattedTime}</span>
                                </div>
                            </div>
                        `;
    
                        // Add the event listener here, right after setting the innerHTML
                        notifItem.addEventListener("click", function(e) {
                            // Prevent default dropdown behavior
                            e.stopPropagation();
                            
                            // Mark notification as read
                            markNotificationAsRead(notification.id);
                            
                            // Get the URL from data-href and navigate
                            const url = this.querySelector('.notif-item').dataset.href;
                            window.location.href = url;
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
