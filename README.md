#Recruitment
This is guide to run the project

1. Pull Laravel project from git repository:
    https://github.com/SafaaMohamedGamal/InterviewsManagement_GP
2. Create a database locally
3. Rename .env.example file to .env inside your project root and fill the database information
4. Run composer install 
5. Add configuration variable of pusher and twilio in ‘.env’ file
6. Run php artisan migrate then php artisan db:seed then php artisan serve to start your php server
