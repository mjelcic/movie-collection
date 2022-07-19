# The movie-collection project
This is a test project for adding movies to the database.

## How to run the project
1. Clone project
```git
git clone https://github.com/mjelcic/movie-collection.git
```
2. Run the following command: 
```docker
docker-compose up
```

Base URL will be: 0.0.0.0:80

You can send requests on following endpoints using Postman or any other similar tool.

## Exposed endpoints

### GET api/movies
#### Example output
```json
[
    {
        "id": 1,
        "ratings": {
            "imdb": 7.8,
            "rotten_tomatto": 8.2
        },
        "name": "The Titanic",
        "casts": [
            "DiCaprio",
            "Kate Winslet"
        ],
        "releaseDate": "1998-01-18T00:00:00+01:00",
        "director": "James Cameron"
    }
 ]
```

### GET api/movies/{id}
#### Example output
```json
    {
        "id": 1,
        "ratings": {
            "imdb": 7.8,
            "rotten_tomatto": 8.2
        },
        "name": "The Titanic",
        "casts": [
            "DiCaprio",
            "Kate Winslet"
        ],
        "releaseDate": "1998-01-18T00:00:00+01:00",
        "director": "James Cameron"
    }
```

### POST api/movies
#### Input parameters
- name: string,
- casts: array,
- release_date: int,
- director: int,
- ratings: array
#### Example output
```json
{
    "id": 1,
    "ratings": {
        "imdb": 7.8,
        "rotten_tomatto": 8.2
    },
    "name": "The Titanic",
    "casts": [
        "DiCaprio",
        "Kate Winslet"
    ],
    "releaseDate": "18-01-1998",
    "director": "James Cameron"
}
```

### PUT api/movies
#### Input parameters
- id : int,
- name: string,
- casts: array,
- release_date: int,
- director: int,
- ratings: array
#### Example output
```json
{
    "id": 1,
    "ratings": {
        "imdb": 7.8,
        "rotten_tomatto": 8.2
    },
    "name": "The Titanic",
    "casts": [
        "DiCaprio",
        "Kate Winslet"
    ],
    "releaseDate": "18-01-1998",
    "director": "James Cameron"
}
```

### POST api/user
#### Input parameters
- username: string,
- password: string,
- email: string
#### Example output
```json
{
    "id": 3,
    "email": "user1",
    "username": "abc@def.ghi"
}
```

### POST api/login
#### Input parameters
- username: string,
- password: string
#### Example output
```json
{
    "token": string,
}
```

### Default account
- username: **admin**
- password: **admin**

## Authentication
All endpoints except api/login require authentication.

## Mail setup
To be able to receive mail notification on inserting new movie, update MAILER_DSN in .env file.
