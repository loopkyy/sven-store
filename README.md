🌟 Lunaya Store — CodeIgniter 4 + React
✨ Overview
Lunaya Store is a modern e-commerce web application built using:

🔧 CodeIgniter 4 (PHP) — as backend framework (API + admin panel)

⚛️ React — as frontend for customers (/frontend-react)

🎨 Chakra UI on frontend, Sneat Admin template on backend

📦 Packaged with Composer, using .env for configuration

This repository is a monorepo to manage both backend and frontend in one place.

🚀 Installation & Setup
Backend (CodeIgniter 4)
bash
Copy
Edit
# Clone the repo
git clone https://github.com/kamu-user/lunaya-store.git
cd lunaya-store

# Install dependencies
composer install

# Copy .env file
cp env .env

# Setup .env
# (Edit app.baseURL, database settings, etc.)

# Migrate the database
php spark migrate

# Serve the project
php spark serve
Frontend (React)
bash
Copy
Edit
# Navigate to frontend folder
cd frontend-react

# Install React dependencies
npm install

# Start the React dev server
npm run dev
⚠️ Make sure your API endpoints in React are correctly pointing to your backend baseURL.

📁 Project Structure
pgsql
Copy
Edit
lunaya-store/
├── app/                 → CodeIgniter 4 backend
├── public/              → Public folder (index.php)
├── frontend-react/      → React frontend app
├── writable/            → CI4 writable folder
├── .env                 → Environment settings
├── composer.json        → PHP dependencies
└── README.md
🌐 Deployment Notes
Point your web server (Apache/Nginx) to the public/ directory.

Use a separate domain or subdomain for frontend (e.g., store.example.com).

Build frontend for production:

bash
Copy
Edit
npm run build
Always commit your .env.example, never your real .env.

🧑‍💻 Developer Notes
Uses RESTful API between frontend and backend.

Authentication via session or token-based (custom implementation).

Wishlist & cart functionality uses localStorage/sessionStorage on frontend.

🔧 Requirements
PHP 8.1+

Composer

Node.js & npm

MySQL or compatible database

Apache/Nginx for production

📚 Resources
CodeIgniter Docs

React Docs

Chakra UI

Sneat Template

