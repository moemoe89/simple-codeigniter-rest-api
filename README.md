# Simple Codeigniter REST API
Simple source code for learning basic backend developer using REST API (login, CRUD).

# Demo
[Visit Here](https://www.youtube.com/watch?v=MbkMrnisyo4)

# Setup
Download or clone [Master File](simple-codeigniter-rest-api)
and then config & import database:

-MySQL
-PostgreSQL


You can use [POSTMAN](https://www.getpostman.com/) or anything else for simulate frontend

# Test the API
You can test the API by including header `Content-Type`,`Client-Service` & `Auth-Key` with value `application/json`,`frontend-client` & `simplerestapi` in every request

And for API except `login` you must include `id` & `token` that you get after successfully login. The header for both look like this `User` & `Authorization`

List of the API :

`[POST]` `/auth/login` json `{ "username" : "admin", "password" : "Admin123$"}`

`[GET]` `/book`

`[POST]` `/book/create` json `{ "title" : "x", "author" : "xx"}`

`[PUT]` `/book/update/:id` json `{ "title" : "y", "author" : "yy"}`

`[GET]` `/book/detail/:id`

`[DELETE]` `/book/delete/:id`

`[POST]` `/auth/logout`
