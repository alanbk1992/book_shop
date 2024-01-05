Skill Test
Position : IT Fullstack Developer
Name : Alan Budi Kusumah

API Login :
http://127.0.0.1:8000/api/auth/login

Parameter :

{"email":"admin@gmail.com","password":"admin123"}

Response :

{
    "status": 200,
    "message": "ok",
    "data": [
        {
            "id": 2,
            "name": "admin",
            "email": "admin@gmail.com",
            "password": "$2y$10$E1iJQgsHQTEkyj.kBvykBO0p315YvQSqWtda61GB1jWv54HPQzolm",
            "token": "M4I3qsS2nRvv2xn",
            "is_login": 1,
            "status_id": 1,
            "updated_at": "2024-01-05 05:22:54",
            "created_at": "2024-01-05 05:22:54"
        }
    ]
}

API Get Books:
http://127.0.0.1:8000/api/books

Parameter:
{"user_id":"2","token":"M4I3qsS2nRvv2xn"}

Response:

{
    "status": 200,
    "message": "ok",
    "data": [
        {
            "book_id": 1,
            "title": "Buku 1",
            "authors": "Alan"
        }
    ]
}


API Search Books:
http://127.0.0.1:8000/api/books

Parameter:
{"user_id":"2","token":"M4I3qsS2nRvv2xn", "search" :"b"}


Response:

{
    "status": 200,
    "message": "ok",
    "data": [
        {
            "book_id": 1,
            "title": "Buku 1",
            "authors": "Alan"
        }
    ]
}