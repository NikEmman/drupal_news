# News & Events Portal (Drupal 11)

A dynamic news and events portal built with **Drupal 11**, featuring categorized content, a RESTful API, and a custom front-end integration. This project demonstrates content modeling, custom module development, and the consumption of external APIs (Laravel).

## Features

### 1. News Management

- **Content Modeling:** Custom 'Article' content type with Taxonomy (Politics, Tech, Sports), Media images, and "Featured" flags.
- **Dynamic Views:**
- `/news`: A full listing of articles with **Infinite Scroll** and **Better Exposed Filters** for category-based searching.
- `/news/featured`: A filtered view showing only spotlighted content.
- `/api/news`: A REST Export endpoint providing JSON data for external consumption.

### 2. Custom Front Page (`/front-news`)

A 2-column layout implemented via a custom Drupal Controller and Twig template:

- **Left Column:** "Featured Spotlight" fetching the latest featured article.
- **Right Column:** A "Latest News" feed that consumes the `/api/news` JSON endpoint in real-time.

### 3. Events Display (Custom Module)

- **Module Name:** `events_display`
- **Functionality:** Uses Drupal's `HTTPClient` to fetch upcoming events from a companion **Laravel API** (`/api/v1/events`).
- **Performance:** Implements Drupal's Cache API to store API responses, optimizing load times.
- **Custom Block:** A configurable block that allows administrators to set the number of events displayed via the Drupal Block UI.

---

## Tech Stack

- **CMS:** Drupal 11.x
- **Theme:** Bootstrap Barrio (SASS-based)
- **Frontend:** Twig, Vanilla JavaScript, Bootstrap 5.3
- **Data Source:** Laravel 11 API (for Events)

---

## Installation & Setup

### Prerequisites

- Composer
- Local PHP environment (e.g., MAMP, XAMPP, or DDEV)
- Laravel server running the Events API (typically on `http://127.0.0.1:8000`), check [event_manager](https://github.com/NikEmman/laravel_event_manager) repo

### 1. Clone and Install Dependencies

```bash
git clone git@github.com:NikEmman/drupal_news.git
cd drupal_news
composer install
```

### 2. Start the server & initial setup

```bash
# Start the local server
php -S localhost:8888 -t web
```

Then visit `http://localhost:8888/` and go through setting up db and admin

### 3. Import data

Run the following command to import data, paths, pages. Replace `YOUR_DB_NAME` with the db name you set at the previous step

```bash
sudo mysql -u root -p YOUR_DB_NAME < db_backup.sql
```

Then clear cache by running:

```bash
vendor/bin/drush cr
```

### 4. Run the server again

```bash
php -S localhost:8888 -t web
```

---

## Configuration Notes

- **Events Block:** Navigate to `Structure > Block Layout` and place the **"Upcoming Events Block"** in any region. Click **Configure** to set the desired number of events.
- **Laravel API:** Ensure the Laravel Events API is active at the expected endpoint `http://localhost:8000/api/v1/events`for the`events_display` module to populate data.

---

## Project Structure

- `web/modules/custom/news_front`: Handles the custom route and Twig template for the front page.
- `web/modules/custom/events_display`: Contains the logic for the Laravel API integration and the Events block.
