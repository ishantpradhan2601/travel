<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Travel Recommender System

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

A personalized travel recommendation system built with the Laravel framework. This application helps users find their perfect destination based on their budget, travel dates, and preferred activities.

## Features

- **Personalized Recommendations**: Get destination suggestions tailored to your preferences.
- **Budget Filtering**: Find destinations that fit your financial constraints.
- **Seasonality Logic**: Recommendations take into account the best time to visit each location.
- **Activity Mapping**: Choose between Adventure, Relaxation, Culture, Nature, and more.
- **Modern UI**: Clean and intuitive interface for an effortless planning experience.

## Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Blade, Vanilla CSS (Glassmorphism design)
- **Database**: MySQL/SQLite

## Setup Instructions

1.  **Clone the repository**:
    ```bash
    git clone https://github.com/sanmaaya/travel.git
    cd travel
    ```

2.  **Install dependencies**:
    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup**:
    - Copy `.env.example` to `.env`
    - Generate application key: `php artisan key:generate`
    - Configure your database in `.env`

4.  **Run Migrations & Seeders**:
    ```bash
    php artisan migrate --seed
    ```

5.  **Start the server**:
    ```bash
    php artisan serve
    ```

---

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks. You can also check out [Laracasts](https://laracasts.com) for thousands of video tutorials.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
