# CurrecyFair Test
This repository contains three different applications, three in one but every commit involves a single feature of an application.

* `/rt` contains real time server in Socket.io to manage real time data visualization
* `/backend` constains API system written in PHP on my last library [penny](https://github.com/gianarb/penny).
* `/frontend` contains a single file that help you to visualize data, I use bootstrap and jquery.

Into the project root I wrote a Makefile to manage primary tasks.

## RT
```
make socket_build
```
This command builds the socket server, it downloads depenendcies and build them.

```
make socket_start
```
It starts socket server on port `9090`

## Backend
```
make backend_build
```
It prepares backend, downloads dependencies...

```
make backend_test
```
it run tests. It written in PHPUnit.

```
make backend_start
```
It runs backend server on port `8080`

## Frontend
```
make frontend_start
```
It run frontend server on port `8085`
