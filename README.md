# Dockerized Symfony Skeleton

This project provides a **Dockerized Symfony skeleton** for rapid PHP web development. It sets up a modern development environment with **Nginx**, **MariaDB**, **PHP**, and **Symfony** (bare skeleton, created without the `--webapp` flag), along with essential development tools—**PHPUnit**, **PHPStan**, and **PHPCS**—integrated through convenient Makefile commands.

## Features

- **Symfony Skeleton**: Minimal [Symfony](https://symfony.com/) project in the `project/` directory, ready for custom development (created without `--webapp`).
- **Nginx**: High-performance web server, configured to listen on port **90**.
- **MariaDB**: Open-source MySQL-compatible database with persistent storage.
- **PHP**: Latest stable version, with Xdebug support (optional).
- **Adminer**: Lightweight web-based database management tool.
- **Testing and Quality Tools**: PHPUnit, PHPStan, and PHPCS are preinstalled and can be run directly via Makefile commands.
- **Data Persistence**: MariaDB data is stored in the `data/db/` folder.

## Prerequisites

Make sure you have the following installed:

1. [Docker](https://www.docker.com/get-started)
2. [Docker Compose](https://docs.docker.com/compose/install/)
3. **Make** (Included by default on Linux/macOS; for Windows, install via [Make for Windows](http://gnuwin32.sourceforge.net/packages/make.htm)).

## Getting Started

### 1. Clone the Repository
```bash
git clone https://github.com/jendo/symfony-webapp.git
cd symfony-webapp
```

### 2. Configuration

- The `config` folder contains configuration files for each service:
    - **`adminer.ini`**: Adminer configuration.
    - **`mysql.cnf`**: MariaDB settings.
    - **`nginx.cnf`**: Nginx server configuration.
    - **`php.ini`**: PHP settings, including Xdebug.
- The `docker` folder contains Dockerfiles for custom images.

After making changes to configurations or Dockerfiles, use the provided Makefile commands to rebuild and start the containers.

### 3. Start and Stop the Containers

- **Start the stack:**
  ```bash
  make up
  ```
  Builds images (if necessary) and starts all services.

- **Stop the stack:**
  ```bash
  make down
  ```
  Stops and removes all running containers.

### 4. Accessing Services

- **Symfony (Nginx/PHP):** [http://localhost:90](http://localhost:90)
    - The Symfony skeleton runs in the `project/` directory.
- **Adminer:** [http://localhost:8080](http://localhost:8080)
- **MariaDB:** Connect using `localhost`, username, and password as configured in `.env`. 

### 5. Enable Xdebug (Optional)
**Xdebug** is installed in the PHP container and can be enabled on demand via the `XDEBUG_ENABLE` environment variable.

Modify the `.env` file or pass the variable at runtime:
  ```bash
  XDEBUG_ENABLE=1 make up
  ```

## Testing and Code Quality

The environment includes essential tools for testing and static analysis:

- **PHPUnit** – Run unit tests.
- **PHPStan** – Static code analysis.
- **PHPCS** – Code style and quality checks.

Run these tools easily using the Makefile (executed inside the PHP container):

```bash
make phpunit           # Run PHPUnit tests
make phpstan           # Run PHPStan analysis
make phpcs             # Run PHPCS code style checks
```

## Project Structure

```
├── docker-compose.yml   # Docker Compose configuration
├── Makefile             # Makefile for command shortcuts (including QA/testing tools)
├── docker/              # Dockerfiles for custom images
├── config/              # Service configuration files
│   ├── adminer.ini      # Adminer config
│   ├── mariadb.cnf      # MariaDB config
│   ├── nginx.cnf        # Nginx config
│   └── php.ini          # PHP & Xdebug config
├── data/                # Persistent storage (MariaDB data)
├── project/             # Symfony skeleton application
│   ├── public/          # Web root (Symfony front controller: index.php)
│   │   └── index.php
│   └── ...              # Symfony directories, config, source, tests, etc.
├── .env                 # Environment variables (optional)
└── README.md            # Documentation
```

## Customization

- Develop your Symfony app in the `project/` directory.
- Keep only index.php in the `project/public/` folder, which serves as the entry point.
- Add PHP packages via Composer in that directory (e.g., using `make composer-update`).
- Adjust service configuration in the `config/` folder.
- Tool rules (PHPUnit, PHPStan, PHPCS) can be customized in the `project/` directory.

## Troubleshooting

- View Docker logs for errors:
  ```bash
  docker-compose logs
  ```
- Ensure no other services are using ports 90 (Nginx), 8080 (Adminer) or 3306 (MariaDB).

## Contributing

Contributions are welcome! Feel free to submit a pull request or open an issue to suggest improvements.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
