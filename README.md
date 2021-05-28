# Laravel API's with JSON (JWT) Web Token

## Step 1: Download project from Github

```bash
git clone origin https://github.com/MalikAqeelArshad/ride-to-the-future.git
```

Then navigate to `ride-to-the-future` directory. Open this project in your favorite text editor or IDE like Visual Studio Code/vim/Sublime Text or PHPStorm.

## Step 2: Copy .env.example to .env and Update Database credentials in environmental file

```bash
cp .env.example .env
```

Now open the `.env` file and change following:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ridetothefuture
DB_USERNAME=root
DB_PASSWORD=
```

## Step 3: Install packages using composer command

In command line interface (CLI) enter following command:

```bash
composer install or composer update
```

## Step 4: Run the artisan command for creating new tables to the database

```bash
php artisan migrate
```

## Step 4: Run the artisan command for inserting dummy data to the database like users, questions and question_comments

```bash
php artisan db:seed
```

After run the `db:seed` command you can see some users and questions will be added to the database

## Step 5: Run the server command

Enter the following command:

```bash
php artisan serve
```

## Step 6: Open the `Postman` and follow all of these api's

API Endpoints:

1. Login

`127.0.0.1:8000/api/auth/login`: POST method.

Required post parameters `email` and `password`

2. Register

`127.0.0.1:8000/api/auth/register`: POST method.

Required post parameters `role`, `name`, `email` and `password`. role can be `support or customer`

3. User (Authenticated)

   `127.0.0.1:8000/api/auth/profile?token=VALID_TOKEN`: GET method

4. To view all questions, and To search by user name or question status (Authenticated)

   `127.0.0.1:8000/api/questions?token=VALID_TOKEN`: GET method

   `127.0.0.1:8000/api/questions?token=VALID_TOKEN&name=USER_NAME&status=QUESTION_STATUS_ID`: GET method

    **Description**: To view all questions created by the logged in user and support user can see all questions

5. To create question (Authenticated)

    `127.0.0.1:8000/api/questions?token=VALID_TOKEN`: POST method

    Required post parameters `title` and `status`.

6. To delete question (Authenticated)

    `127.0.0.1:8000/api/questions/id?token=VALID_TOKEN`: DELETE method

7. To edit question (Authenticated)

    `127.0.0.1:8000/api/questions/id?token=VALID_TOKEN`: PUT/PATCH method

    Required post parameters `title` and `status`.

8. To create new comment for question (Authenticated) Email should be sent when support user will create new comment on any question.

    `127.0.0.1:8000/api/questions/question_id/comment?token=VALID_TOKEN`: GET method

9. To logout (Authenticated)

    `127.0.0.1:8000/api/auth/logout?token=VALID_TOKEN`: GET method


## Note: For email testing please set the mailtrap credentials form mailtrap.io

If you want to check email after repling the any question please set these credentials:

```env
MAIL_MAILER=smtp
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=mailtrap_username
MAIL_PASSWORD=mailtrap_passsword
MAIL_ENCRYPTION=tls
```

## Note: Run the schedule command

If you want to check all the question status are changed or not please following command and check the status of all questions:

```bash
php artisan schedule:run
```

If you face any difficulty, please contact me: `0569369306` or email `malik.aqeelarshad@gmail.com`

# Thanks