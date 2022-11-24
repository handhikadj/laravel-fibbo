# Laravel Fibbo

## Preliminary
On this README, we use docker compose v2 which uses `docker compose` instead of `docker-compose`

## System Requirements
- Docker
- Docker compose

## Installation

1. Clone this repo
2. Run `sudo chmod -R 777 .` to avoid all docker installation problems
3. Run `cp .env.example .env`
4. Run `docker compose up -d --build`. Wait until finish
5. Run `docker compose run --rm composer install`
6. Run `docker compose run --rm artisan migrate && docker compose run --rm artisan db:seed`
7. If everything goes well, the API is available on port 8075 and phpmyadmin is available on port 8085

## Endpoints

Headers (Required for all endpoints):

```json
{
    'Accept': 'application/json',
    'Content-Type': 'application/json',
}
```

- `api/login`: get access token

    Method: POST
   
    Example response:
    ```json
    {
        "access_token": string
    }
    ```

    Test credentials (based on seeder):
     - Username: test@test.com
     - Password: password

- `api/fibonacci/compute`: Compute Nth fibonacci

    Headers (Required):
    ```json
    {
        'Authorization': `Bearer ${access_token}`
    }
    ```

    Method: POST

    Request Body:
    ```json
    {
        numb: required|integer
        timeout: integer
    }
    ```

    Example response:
    ```json
    {
        "message": "Request accepted"
    }
    ```

- `api/fibonacci/result`: See result from `api/fibonacci/compute` endpoint

    Headers (Required):
    ```json
    {
        'Authorization': `Bearer ${access_token}`
    }
    ```

    Method: GET

    Example response:
    ```json
    {
        "status": "Processed",
        "result": "6765"
    }
    ```

