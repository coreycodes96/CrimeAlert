# Crime Alert

Crime Alert is a website that allows people to report a crime in their city.

You can create posts and if approved they'll be displayed on the timeline to notify others.

You can like, comment and like comments on posts.

You can favourite users profiles and see those users posts on your timeline also.

There are also live notifications to see interactions on your posts and comments

---

## Software I Used:
* Laravel
* VueJS
* Vuex
* TailwindCSS
---


## How To Use Crime Alert.

1. Open A Command Line And Run
```
composer install &&
npm install &&
php artisan key:generate &&
php artisan migrate &&
php artisan db:seed
```
---

2. Open A __Second__ Command Line And Run

```
php artisan serve --host 192.168.1.114
```
---

3. Open A __Third__ Command Line And Run

```
npm run watch
```
---

4. Open A __Forth__ Command Line and Run

```
php websockets:serve
```
---

___*Notes:*___

These are the dependency versions that worked for this project. So please be sure to have this (package.json).
```
"laravel-echo": "^1.10.0",
"pusher-js": "^4.3.1"

```