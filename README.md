# EXPLORE MANAOAG: A Web-Based Online Platform for Enhancing Local Tourism

## 🚀 About This Project

[cite_start]**Explore Manaoag** is a web-based online platform designed to serve as a comprehensive virtual assistant and information hub for tourists visiting the Municipality of Manaoag, Pangasinan. [cite: 32] [cite_start]This system aims to enhance the local tourism experience by providing easy access to destinations, local products, services, and essential travel information. [cite: 32, 99]

[cite_start]This project was developed as a capstone requirement for the Bachelor of Science in Information Technology at COLEGIO DE SAN JUAN DE LETRAN-MANAOAG. [cite: 2, 5, 7]

## ✨ Key Features

### User (Tourist) Side:
* **Interactive Homepage:** A dynamic homepage that shows featured content (spots, products, guides) for logged-in users.
* **Detailed Information Pages:** Browseable pages for:
    * [cite_start]Tourist Spots (with Google Maps integration) [cite: 129]
    * [cite_start]Local Products & Delicacies [cite: 95]
    * [cite_start]Parking Areas [cite: 128]
    * [cite_start]Delivery Services [cite: 127]
    * [cite_start]Digital Tour Guides [cite: 129]
* **Government Officials:** View profiles for the Mayor, Vice-Mayor, and Councilors with their social media links.
* **AI Chatbot:** An integrated chatbot assistant (powered by a local Llama server) to answer user questions about attractions, products, and more.
* **User Profiles:** Tourists can register and log in to a personal profile.
* **Favorites System:** Logged-in users can save their favorite spots, products, and parking areas to their profile.
* **Push Notifications:** Users can subscribe to receive live updates and announcements from the admin.
* **iFrame Link Viewing:** External useful links (like the provincial website) open within the application's interface for a seamless experience.

### Admin Side:
* **Content Management System (CMS):** A secure admin panel to manage all website content.
* **Modal-Based Forms:** A clean UI where all "Add" and "Edit" forms open in modals for a smooth workflow.
* **Manage All Modules:** Full CRUD (Create, Read, Update, Delete) functionality for:
    * Site Content (Homepage text/images)
    * Government Officials
    * Tourist Spots
    * Products
    * Events
    * Parking, Guides, Delivery, and FAQs
* **User Management:** View and manage registered tourist accounts and other admin accounts.
* **Push Notification Sender:** A dedicated page to compose and send push notifications to all subscribed users.
* [cite_start]**Feedback Moderation:** Admins can approve or delete user-submitted feedback before it appears publicly. [cite: 122]

## 🛠️ Tech Stack

* **Backend:** PHP (OOP)
* **Frontend:** HTML, CSS, JavaScript
* **Styling:** TailwindCSS
* **Database:** MySQL / MariaDB
* **Push Notifications:** `minishlink/web-push` (Composer Package)
* **Chatbot (Optional):** Llama local server (external)

## 📦 Installation

1.  **Clone the repository:**
    ```bash
    git clone [https://your-repo-url.com/explore-manaoag.git](https://your-repo-url.com/explore-manaoag.git)
    cd explore-manaoag
    ```

2.  **Database Setup:**
    * Open `phpMyAdmin` and create a new database named `db_explore_manaoag`.
    * Import the `db_explore_manaoag.sql` file into the new database.

3.  **Backend Dependencies (Composer):**
    * Ensure you have [Composer](https://getcomposer.org/) installed.
    * Run the following command in the root folder:
    ```bash
    composer install
    ```

4.  **Frontend Dependencies (Node.js):**
    * Ensure you have [Node.js](https://nodejs.org/) installed.
    * Run the following command to install TailwindCSS:
    ```bash
    npm install
    ```

5.  **Configuration:**
    * **Database:** Open `src/core/Database.php` and `public/index.php`. Update the `$dbConfig` array with your local database credentials (username, password).
    * **Push Notifications:**
        * Generate your VAPID keys (e.g., using a web-push library).
        * Open `src/core/config.php` and paste your **Public Key** and **Private Key**.

## ⚙️ How to Use

### Running the Project

1.  **Start your XAMPP/WAMP server** (Apache & MySQL).
2.  **Compile TailwindCSS:**
    * To build the CSS once, run:
        ```bash
        npm run build
        ```
    * To automatically watch for changes while you code, run:
        ```bash
        npm run watch
        ```
3.  **Access the Website:**
    * Open your browser and go to: `http://localhost/explore-manaoag/public/`

### Admin Access

* **Admin Login:** `http://localhost/explore-manaoag/public/index.php?page=login`
* **Default User:** `admin`
* **Default Pass:** `admin` (or check the password_hash in the `admins` table)
