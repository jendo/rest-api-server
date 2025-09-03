# Dockerized Symfony REST API Example

This project is a **ready-to-use REST API** built with **Symfony**, featuring real endpoints and complete functionality.  
It serves as a showcase of my custom REST API implementation.
The provided Docker setup establishes a modern development environment with **Nginx**, **MariaDB**, and **PHP**, and integrates essential development tools—**PHPUnit**, **PHPStan**, and **PHPCS**—accessible via a convenient Makefile.

Use this repository to explore a working example of a production-grade Symfony REST API, including OpenAPI documentation for all endpoints.

## Prerequisites

Make sure you have the following installed:

1. [Docker](https://www.docker.com/get-started)
2. [Docker Compose](https://docs.docker.com/compose/install/)
3. **Make** (Included by default on Linux/macOS; for Windows, install via [Make for Windows](http://gnuwin32.sourceforge.net/packages/make.htm)).

## Getting Started

### 1. Configuration

- The `config` folder contains configuration files for each service:
    - **`adminer.ini`**: Adminer configuration.
    - **`mysql.cnf`**: MariaDB settings.
    - **`nginx.cnf`**: Nginx server configuration.
    - **`php.ini`**: PHP settings, including Xdebug.
- The `docker` folder contains Dockerfiles for custom images.

After making changes to configurations or Dockerfiles, use the provided Makefile commands to rebuild and start the containers.

### 2. How to run application

1. Clone the repo and go to the application folder: ```git clone git@github.com:jendo/rest-api-server.git && cd rest-api-server```
2. Run the setup command to start Docker containers, install dependencies, create the database schema and load sample data (fixtures): ```make setup```
3. To stop and remove all Docker containers, run: ```make down```

### 3. Accessing Services

- **Symfony (Nginx/PHP):** [http://localhost:90](http://localhost:90)
    - The Symfony skeleton runs in the `project/` directory.
- **Adminer:** [http://localhost:8080](http://localhost:8080)
- **MariaDB:** Connect using `localhost`, username, and password as configured in `.env`. 

### 4. Enable Xdebug (Optional)
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
├── project/             # Symfony REST API application (source code, controllers, endpoints)
│   └── ...              # REST API source, config, endpoints, tests, etc.
├── .env                 # Environment variables (optional)
└── README.md            # Documentation
```

- The **`project/`** directory contains the full source code of the REST API, including controllers, endpoints, configuration, and tests.

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
