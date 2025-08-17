<h1>Anaia's Motorcycle Rental System</h1>

<p><strong>Anaia's Motorcycle Rental</strong> is a motorcycle and passenger motorcycle rental business operating in multiple locations around Cavite and Laguna—including Bacoor, Molino, Sta. Rosa, Tagaytay, and Naic.</p>

<h3><strong>About Anaia's Motorcycle Rental</strong></h3>

<p>Anaia's Motorcycle Rental provides convenient and reliable motorcycle rental services across key locations in Cavite and Laguna provinces. The business specializes in motorcycle rentals while also offering passenger motorcycle options to meet diverse transportation needs. With strategic locations in Bacoor, Molino, Sta. Rosa, Tagaytay, and Naic, the company ensures accessible rental services for both local residents and tourists exploring the scenic areas of these provinces.</p>

<p>The rental service caters to various customer needs, from daily commuting solutions to weekend adventure trips, particularly popular among those visiting Tagaytay's tourist attractions or needing reliable transportation in urban areas like Bacoor and Sta. Rosa. The business maintains a fleet of well-maintained motorcycles and motorcycles, ensuring customer safety and satisfaction across all rental locations.</p>

<div align="center">

 <img src="https://raw.githubusercontent.com/yenashiloh/Anaias-Motorcycle-Reservation-System/main/public/assets/img/screenshot-anaia-hero.png" alt="Hero Section" width="800">
<img src="https://github.com/yenashiloh/Anaias-Motorcycle-Reservation-System/blob/main/public/assets/img/screenshot-anaia-features.png" alt="Hero Section" width="800">

  <br><br>
</div>

<h2>📋 <strong>PROJECT OVERVIEW</strong></h2>
<br>

<p>This web-based motorcycle rental management system was developed to streamline the motorcycle rental process for both customers and administrators. The platform eliminates manual booking processes and provides real-time tracking and management capabilities, making motorcycle rental more efficient and user-friendly.</p>

<h3><strong>MISSION</strong></h3>
<br>

<p>To modernize the motorcycle rental experience by:</p>

<ul>
    <li>Enabling customers to easily browse and book motorcycles online</li>
    <li>Providing real-time rental tracking and notifications</li>
    <li>Streamlining payment processing with digital payment options</li>
    <li>Offering comprehensive fleet and customer management tools</li>
    <li>Ensuring seamless communication between customers and administrators</li>
</ul>
<br>

<h2>🚀 <strong>FEATURES</strong></h2>

<h3><strong>For Customers</strong></h3>

<ul>
    <li><strong>User Registration & Login System</strong> - Secure account creation with email verification notification</li>
    <li><strong>Motorcycle Browsing and Selection</strong> - Browse available motorcycles and motorcycles by location and type</li>
    <li><strong>Booking/Reservation System</strong> - Easy online booking with date and time selection</li>
    <li><strong>Payment Processing</strong> - Secure payment through GCash scanning system</li>
    <li><strong>User Dashboard</strong> - Personal dashboard to manage bookings and rental history</li>
    <li><strong>Rental Tracking</strong> - Real-time tracking of rental status and duration</li>
    <li><strong>Real-time Notifications</strong> - Instant updates on booking confirmations, payment status, and rental updates</li>
</ul>

<br clear="all">

<h3><strong>For Administrators</strong></h3>

<ul>
    <li><strong>Admin Management System</strong> - Comprehensive administrative control panel</li>
    <li><strong>Customer Management</strong> - Manage customer accounts, bookings, and rental history</li>
    <li><strong>Motorcycle Fleet Management</strong> - Add, edit, and manage motorcycle and motorcycle inventory</li>
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
git clone https://github.com/yenashiloh/anaias-motorcycle-reservation-system.git
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

<h2>🤝 <strong>CONTRIBUTING</strong></h2>

<h2>📝 <strong>LICENSE</strong></h2>

<p>This project is licensed under the MIT License - see the <a href="https://github.com/yenashiloh/anaias-motorcycle-reservation-system/blob/main/LICENSE.md">LICENSE.md</a> file for details.</p>

