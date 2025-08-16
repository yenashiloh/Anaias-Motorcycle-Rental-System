<h1>Anaia's Motorcycle Rental System</h1>

<p><strong>Anaia's Motorcycle Rental</strong> is a motorcycle and passenger vehicle rental business operating in multiple locations around Cavite and Laguna—including Bacoor, Molino, Sta. Rosa, Tagaytay, and Naic.</p>

<h3><strong>About Anaia's Motorcycle Rental</strong></h3>

<p>Anaia's Motorcycle Rental provides convenient and reliable vehicle rental services across key locations in Cavite and Laguna provinces. The business specializes in motorcycle rentals while also offering passenger vehicle options to meet diverse transportation needs. With strategic locations in Bacoor, Molino, Sta. Rosa, Tagaytay, and Naic, the company ensures accessible rental services for both local residents and tourists exploring the scenic areas of these provinces.</p>

<p>The rental service caters to various customer needs, from daily commuting solutions to weekend adventure trips, particularly popular among those visiting Tagaytay's tourist attractions or needing reliable transportation in urban areas like Bacoor and Sta. Rosa. The business maintains a fleet of well-maintained motorcycles and vehicles, ensuring customer safety and satisfaction across all rental locations.</p>

<div align="center">
    <img src="images/homepage-screenshot.png" alt="Anaia's Rental Homepage" width="600">
</div>

<h2>📋 <strong>PROJECT OVERVIEW</strong></h2>
<br>

<p>This web-based motorcycle rental management system was developed to streamline the vehicle rental process for both customers and administrators. The platform eliminates manual booking processes and provides real-time tracking and management capabilities, making vehicle rental more efficient and user-friendly.</p>

<h3><strong>MISSION</strong></h3>
<br>

<p>To modernize the vehicle rental experience by:</p>

<ul>
    <li>Enabling customers to easily browse and book vehicles online</li>
    <li>Providing real-time rental tracking and notifications</li>
    <li>Streamlining payment processing with digital payment options</li>
    <li>Offering comprehensive fleet and customer management tools</li>
    <li>Ensuring seamless communication between customers and administrators</li>
</ul>
<br>

<h2>🚀 <strong>FEATURES</strong></h2>

<div align="center">
    <img src="images/features-overview.png" alt="Features Overview" width="700">
</div>

<h3><strong>For Customers</strong></h3>

<img src="images/customer-dashboard.png" alt="Customer Dashboard" width="500" align="right">

<ul>
    <li><strong>User Registration & Login System</strong> - Secure account creation with email verification notification</li>
    <li><strong>Vehicle Browsing and Selection</strong> - Browse available motorcycles and vehicles by location and type</li>
    <li><strong>Booking/Reservation System</strong> - Easy online booking with date and time selection</li>
    <li><strong>Payment Processing</strong> - Secure payment through GCash scanning system</li>
    <li><strong>User Dashboard</strong> - Personal dashboard to manage bookings and rental history</li>
    <li><strong>Rental Tracking</strong> - Real-time tracking of rental status and duration</li>
    <li><strong>Real-time Notifications</strong> - Instant updates on booking confirmations, payment status, and rental updates</li>
</ul>

<br clear="all">

<h3><strong>For Administrators</strong></h3>

<img src="images/admin-dashboard.png" alt="Admin Dashboard" width="500" align="left">

<ul>
    <li><strong>Admin Management System</strong> - Comprehensive administrative control panel</li>
    <li><strong>Customer Management</strong> - Manage customer accounts, bookings, and rental history</li>
    <li><strong>Vehicle Fleet Management</strong> - Add, edit, and manage motorcycle and vehicle inventory</li>
    <li><strong>Booking Management</strong> - Approve, modify, or cancel customer reservations</li>
    <li><strong>Payment Tracking</strong> - Monitor GCash payments and transaction history</li>
    <li><strong>Real-time Notifications</strong> - Instant alerts for new bookings, payments, and rental activities</li>
    <li><strong>Content Management</strong> - Update website content, pricing, and promotional materials</li>
    <li><strong>Location Management</strong> - Manage rental locations across Cavite and Laguna</li>
</ul>

<br clear="all">

<h2>🛠️ <strong>TECHNOLOGY STACK</strong></h2>

<ul>
    <li><strong>Frontend:</strong> HTML5, CSS3, Bootstrap 5, JavaScript</li>
    <li><strong>Backend:</strong> Laravel (PHP Framework)</li>
    <li><strong>Database:</strong> MySQL</li>
    <li><strong>Payment System:</strong> GCash QR Code Integration</li>
    <li><strong>Notifications:</strong> Real-time WebSocket/Pusher Integration</li>
    <li><strong>Server:</strong> Apache/Nginx compatible</li>
</ul>

<h2>📦 <strong>INSTALLATION</strong></h2>

<h3><strong>Prerequisites</strong></h3>

<ul>
    <li>PHP >= 8.0</li>
    <li>Composer</li>
    <li>MySQL >= 5.7</li>
    <li>Node.js & NPM (for asset compilation)</li>
</ul>

<h3><strong>Setup Instructions</strong></h3>

<strong>1. Clone the repository</strong>
<pre>
<code>
git clone https://github.com/yourusername/anaia-motorcycle-rental.git
cd anaia-motorcycle-rental
</code>
</pre>

<strong>2. Install PHP dependencies</strong>
<pre>
<code>
composer install
</code>
</pre>

<strong>3. Install JavaScript dependencies</strong>
<pre>
<code>
npm install
</code>
</pre>

<strong>4. Environment Configuration</strong>
<pre>
<code>
cp .env.example .env
php artisan key:generate
</code>
</pre>

<strong>5. Configure your `.env` file</strong>
<pre>
<code>
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=anaia_rental
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls

# GCash Payment Configuration
GCASH_MERCHANT_ID=your_merchant_id
GCASH_API_KEY=your_api_key

# Real-time Notifications
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_key
PUSHER_APP_SECRET=your_pusher_secret
PUSHER_APP_CLUSTER=your_cluster
</code>
</pre>

<strong>6. Database Setup</strong>
<pre>
<code>
php artisan migrate
php artisan db:seed
</code>
</pre>

<strong>7. Compile Assets</strong>
<pre>
<code>
npm run dev
# or for production
npm run build
</code>
</pre>

<strong>8. Start the Server</strong>
<pre>
<code>
php artisan serve
</code>
</pre>

Visit <code>http://127.0.0.1:8000</code> to access the application.

<h2>📁 <strong>PROJECT STRUCTURE</strong></h2>

<pre>
<code>
anaia-motorcycle-rental/
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   ├── Mail/
│   └── Events/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   └── images/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
└── storage/
</code>
</pre>

<h2>🎯 <strong>USAGE</strong></h2>

<h3><strong>For Customers</strong></h3>

<ul>
    <li><strong>Register</strong> for a new account and verify email</li>
    <li><strong>Browse</strong> available motorcycles and vehicles by location</li>
    <li><strong>Select</strong> rental dates and vehicle type</li>
    <li><strong>Book</strong> your preferred vehicle</li>
    <li><strong>Pay</strong> using GCash QR code scanning</li>
    <li><strong>Track</strong> your rental status in real-time</li>
    <li><strong>Receive</strong> notifications for booking updates</li>
</ul>

<h3><strong>For Administrators</strong></h3>

<ul>
    <li><strong>Login</strong> to the admin dashboard</li>
    <li><strong>Manage</strong> vehicle fleet and availability</li>
    <li><strong>Process</strong> customer bookings and payments</li>
    <li><strong>Monitor</strong> real-time rental activities</li>
    <li><strong>Update</strong> content and pricing information</li>
    <li><strong>Manage</strong> multiple location inventories</li>
    <li><strong>Generate</strong> rental and financial reports</li>
</ul>

<h2>📧 <strong>NOTIFICATION SYSTEM</strong></h2>

<p>The system provides real-time notifications for:</p>

<h3><strong>Customer Notifications</strong></h3>
<ul>
    <li>Account registration confirmation</li>
    <li>Email verification status</li>
    <li>Booking confirmation and updates</li>
    <li>Payment confirmation</li>
    <li>Rental start and end reminders</li>
    <li>Vehicle return confirmations</li>
</ul>

<h3><strong>Admin Notifications</strong></h3>
<ul>
    <li>New customer registrations</li>
    <li>Incoming booking requests</li>
    <li>Payment notifications</li>
    <li>Vehicle return alerts</li>
    <li>System maintenance reminders</li>
</ul>

<h2>💳 <strong>PAYMENT SYSTEM</strong></h2>

<p>Secure payment processing through:</p>
<ul>
    <li><strong>GCash QR Code Integration</strong> - Customers scan QR codes for instant payment</li>
    <li><strong>Payment Verification</strong> - Automatic payment confirmation system</li>
    <li><strong>Transaction Tracking</strong> - Complete payment history and receipts</li>
    <li><strong>Refund Management</strong> - Automated refund processing for cancellations</li>
</ul>

<h2>🔒 <strong>SECURITY FEATURES</strong></h2>

<ul>
    <li>Password hashing and secure authentication</li>
    <li>Email verification for account security</li>
    <li>CSRF protection</li>
    <li>File upload validation and security</li>
    <li>Role-based access control (Customer vs Admin roles)</li>
    <li>Secure session management</li>
    <li>Payment encryption and secure processing</li>
    <li>Real-time activity monitoring</li>
</ul>

<h2>🏍️ <strong>RENTAL LOCATIONS</strong></h2>

<p>Anaia's Motorcycle Rental operates in the following locations:</p>
<ul>
    <li><strong>Bacoor, Cavite</strong> - Urban area rentals and commuter solutions</li>
    <li><strong>Molino, Cavite</strong> - Residential area coverage</li>
    <li><strong>Sta. Rosa, Laguna</strong> - Commercial district rentals</li>
    <li><strong>Tagaytay, Cavite</strong> - Tourist and leisure rentals</li>
    <li><strong>Naic, Cavite</strong> - Coastal area and local transportation</li>
</ul>

<h2>🤝 <strong>CONTRIBUTING</strong></h2>

<ul>
    <li>Fork the repository</li>
    <li>Create a feature branch (<code>git checkout -b feature/AmazingFeature</code>)</li>
    <li>Commit your changes (<code>git commit -m 'Add some AmazingFeature'</code>)</li>
    <li>Push to the branch (<code>git push origin feature/AmazingFeature</code>)</li>
    <li>Open a Pull Request</li>
</ul>

<h2>📝 <strong>LICENSE</strong></h2>

<p>This project is licensed under the MIT License - see the <a href="LICENSE.md">LICENSE.md</a> file for details.</p>

<p><strong>Anaia's Motorcycle Rental</strong></p>

