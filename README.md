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

The fixture creates several users. You can find the usernames and their common password in the fixture file located at `src/DataFixtures/AppFixtures.php`.

## Contributing

Feel free to fork the repository and submit pull requests.

## License

This project is licensed under the MIT License.
