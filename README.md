# CurrecyFair Test
This repository contains three different applications, three in one but every commit involves a single feature of an application.

* `/rt` contains real time server in Socket.io to manage real time data visualization
* `/backend` constains API system written in PHP on my last library [penny](https://github.com/gianarb/penny).
* `/frontend` contains a single file that help you to visualize data, I use bootstrap and jquery.

Into the project root I wrote a Makefile to manage primary tasks.

## RT
```bash
$ make socket_build
```
This command builds the socket server, it downloads dependencies and build them.

```bash
$ make socket_start
```
It starts socket server on port `9090`

## Backend
```bash
make backend_build
```
It prepares backend, downloads dependencies...

```bash
$ make backend_test
```
it run tests. It written in PHPUnit.

```bash
$ make backend_start
```
It runs backend server on port `8080`

### Rate Limit
If in 300s you call this api more of 10 times the system returns status code 429 (Rate Limit), you can unlock this status with `http://api-server:8080/reset?userId=134256`

## Frontend
```bash
$ make frontend_start
```
It run frontend server on port `8085`

### Config
Copy `/frontend/js/config.js.dist` into `/frontend/js/config.js` and you replace default configurations with correct token
