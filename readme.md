# About S.P.R.F 
## S.P.R.F Is a single page application built using Vuejs, Laravel, Pusher, J.W.T, VueRouter etc: 

> Technologies/Libraries Used,
+   Laravel
+   Vuejs
+   Vuerouter
+   Pusher
+   Json Web Tokens
+   Materialize


Installation

- clone Project
- run `composer install`
- run the command `cp .env.example .env`
- run the command `php artisan key:generate`
- run the command `npm install`
- set up your database
- run the migrations and seeders `php artisan migrate:dbseed`
- set pusher account, and then change .env files with the neccessary keys.

-*Take note of the .env file (It contains the neccessary environmental configurations, eg PUSHER_APP_ID, PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_CLUSTER)*
*Hence ensure that you register and create a new app on pusher to get your pusher details*
-start the server, `php artisan serve`
-Ensure to start your queue workers as broadcasting uses database queue driver, run the command `php artisan queue:work`.
-`npm run watch`

## Screenshots of S.P.R.F !!
![Screenshots](https://res.cloudinary.com/demeqf2er/image/upload/v1577363287/samples/1sprf_jqvwmd.png)

![Screenshot](https://res.cloudinary.com/demeqf2er/image/upload/v1577363287/samples/1sprf_jqvwmd.png)
![Screenshot](https://res.cloudinary.com/demeqf2er/image/upload/v1577363287/samples/5sprf_vc77fa.png)
![Screenshot](https://res.cloudinary.com/demeqf2er/image/upload/v1577363286/samples/3sprf_y3ymdx.png)
[id]: https://res.cloudinary.com/demeqf2er/image/upload/v1577363286/samples/4sprf_w8p9cc.png)
![Screenshot](https://res.cloudinary.com/demeqf2er/image/upload/v1577363286/samples/2sprf_evl6eu.png)

> See **[Video Tutorial](https://res.cloudinary.com/demeqf2er/video/upload/v1577369337/samples/hNLbY1y3It_jat1hk.mp4)**.

[![Video Demo](https://res.cloudinary.com/demeqf2er/image/upload/v1577363286/samples/3sprf_y3ymdx.png)](https://res.cloudinary.com/demeqf2er/video/upload/v1577369337/samples/hNLbY1y3It_jat1hk.mp4 "Demo Video")

## Contributing
Fork the repo, clone your fork,checkout feature branch, make changes, commit and send a PR. Please do well to Star the project, thank you.

## Todos
Write tests


