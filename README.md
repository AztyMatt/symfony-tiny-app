# Symfony Tiny App

## Installation

Follow these steps to set up the project:

1. Clone the repository:

    ```bash
    git clone git@github.com:AztyMatt/symfony-tiny-app.git
    ```

2. Navigate to the project directory:

    ```bash
    cd symfony-tiny-app
    ```

3. Start the Docker containers:

    ```bash
    docker compose up -d
    ```

4. Access the PHP container:

    ```bash
    docker compose exec -ti php bash
    ```

5. Install the project dependencies:

    ```bash
    composer install
    ```

6. Set the application secret:

    ```bash
    php bin/console secrets:set APPSECRET
    ```

7. Load the database fixtures:
    ```bash
    php bin/console doctrine:fixtures:load -n
    ```

## Usage

After completing the installation steps, your Symfony Tiny App (NextTask) should be up and running. You can access it via your web browser:

-   **HTTP:** Port 80
-   **HTTPS:** Port 443

### Admin User

Use the following credentials to log in as an admin:

-   **Email:** admin@next-task.com
-   **Password:** n3xtT@sk

### Fixture Users

### User Fixtures

The fixture creates several user accounts, all of which have the same password: `password`.  
The available email addresses are:  
- alice@example.com  
- bob@example.com  
- charlie@example.com  
- dave@example.com  
- eve@example.com  
- frank@example.com  
- grace@example.com  
- heidi@example.com  
- ivan@example.com  
- judy@example.com  

For more details, you can check the fixture file located at `src/DataFixtures/AppFixtures.php`.

## License

This project is licensed under the MIT License.
