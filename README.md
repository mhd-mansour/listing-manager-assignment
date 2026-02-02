# Listing Manager

Property listing management system built with Laravel. Supports two types of listings (Solo & Project) with role-based access control.

## What it does

- Admins can create, edit, and delete property listings
- Viewers can only browse listings
- Two listing types: Solo properties and Project developments
- Image upload for thumbnails
- Clean, responsive interface

## Getting it running

### You'll need:
- PHP 8.1+
- Composer
- Node.js & NPM
- MySQL or PostgreSQL

### Setup:

1. **Get the code**
   ```bash
   git clone https://github.com/mhd-mansour/listing-manager-assignment.git
   cd listing-manager-assignment
   ```

2. **Install stuff**
   ```bash
   composer install
   npm install
   ```

3. **Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   
   Update your `.env` with database info:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=listing_manager
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Storage & assets**
   ```bash
   php artisan storage:link
   npm run build
   ```

7. **Start it up**
   ```bash
   php artisan serve
   ```
   
   For development with hot reload:
   ```bash
   # In another terminal
   npm run dev
   ```

## Login credentials

**Admin (can do everything):**
- Email: mohammed@listingmanager.com
- Password: admin123

**Viewer (read-only):**
- Email: viewer@listingmanager.com
- Password: viewer123

## How it works

### Solo Listings
For individual properties. Has fields for:
- Title & description
- Number of rooms/bathrooms
- Square footage
- Thumbnail image

### Project Listings
For developments with multiple units. Has:
- Title & description  
- Number of units
- Thumbnail image

### Permissions
- **Admin**: Full access - create, edit, delete anything
- **Viewer**: Can only view listings, no editing

## Tech stack

- Laravel 10 (backend)
- Blade templates + Tailwind CSS (frontend)
- Laravel Breeze (auth)
- MySQL/PostgreSQL (database)

## File structure

Main files you'll care about:
```
app/Http/Controllers/ListingController.php  # Main logic
app/Models/Listing.php                      # Listing model
app/Policies/ListingPolicy.php              # Permissions
resources/views/listings/                   # All the forms & views
```

That's it! Pretty straightforward Laravel app with some custom forms and permission checks.