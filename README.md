# Docker WAMP Project

This project sets up a **Docker-based WAMP stack** (Windows, Nginx, MariaDB, PHP) using **Docker**, allowing you to run a local web development environment efficiently and consistently across different machines. While traditionally a WAMP stack consists of Windows, Apache, MySQL, and PHP, this project replaces **Apache** with **Nginx** and **MySQL** with **MariaDB**, offering modern and lightweight alternatives.

## Features
- **Nginx**: A high-performance web server, configured to listen on port **90**.
- **MariaDB**: A community-developed fork of MySQL for database management.
- **PHP**: A widely-used scripting language for dynamic web development.
- **Adminer**: A lightweight, web-based database management tool for MariaDB.
- **Xdebug**: Installed and can be enabled on demand via the `XDEBUG_ENABLE` environment variable.
- **Data Persistence**: MariaDB data is stored persistently in the `data/db/` folder.

## Prerequisites
Make sure you have the following installed on your machine:
1. [Docker](https://www.docker.com/get-started)
2. [Docker Compose](https://docs.docker.com/compose/install/)
3. **Make** (commonly included by default on Linux/macOS; for Windows, install via [Make for Windows](http://gnuwin32.sourceforge.net/packages/make.htm)).

## Getting Started
Follow these steps to set up and run the **Docker-based WAMP stack**:

### 1. Clone the Repository
```bash
git clone https://github.com/jendo/docker-wamp.git
cd docker-wamp
```

### 2. Configuration
The `config` folder contains configuration files for each service in this project. You can modify these files to customize the behavior of the stack:

- **`adminer.ini`**: Configuration for Adminer.
- **`mysql.cnf`**: MariaDB configuration (e.g., database settings).
- **`nginx.cnf`**: Nginx server configuration (e.g., virtual hosts, server blocks).
- **`php.ini`**: PHP settings (e.g., memory limits, execution time).

The `docker` folder contains the **Dockerfiles** for building custom Docker images for each service:


After making changes to the configuration or Dockerfiles, use the `Makefile` commands to rebuild and start the containers.

### 3. Start and Stop the Containers
The `Makefile` simplifies container management with the following commands:

- **Start the stack**:
  ```bash
  make up
  ```
  This command will build the Docker containers (if necessary) and start all services.

- **Stop the stack**:
  ```bash
  make down
  ```
  This command will stop and remove all running containers.

### 4. Access the Services
- **Nginx/PHP**: Open [http://localhost:90](http://localhost:90)
- **Adminer**: Open [http://localhost:8080](http://localhost:8080)
- **MariaDB**: Connect using `localhost`, username, and password as configured in `.env`.

### 5. Enable Xdebug (Optional)
**Xdebug** is installed in the PHP container and can be enabled on demand via the `XDEBUG_ENABLE` environment variable. 

Modify the `.env` file or pass the variable at runtime:
  ```bash
  XDEBUG_ENABLE=1 make up
  ```

## Project Structure
```
├── docker-compose.yml   # Docker Compose configuration
├── Makefile             # Makefile for simplified commands
├── docker/              # Dockerfiles for building custom images
├── config/              # Configuration files
│   ├── adminer.ini      # Adminer configuration
│   ├── mariadb.cnf      # MariaDB configuration
│   ├── nginx.cnf        # Nginx configuration
│   └── php.ini          # PHP configuration, includes Xdebug settings
├── data/                # Persistent data storage (e.g., MariaDB data)
├── project/             # Application folder
│   ├── public/          # Publicly accessible files (e.g., index.php)
│   │   └── index.php    # Entry point to the application
│   └── ...              # All other application files and directories
├── .env                 # Environment variables (optional)
└── README.md            # Project documentation
```

## Customization
- Modify files in the `config` folder to match your project requirements.
- Place all application files in the `project/` folder.
- Keep only `index.php` in the `project/public/` folder, which serves as the entry point.
- MariaDB stores its persistent data in the `data/` folder.

## Troubleshooting
- Check Docker logs for any errors:
```bash
docker-compose logs
```
- Ensure no other services are using ports 90 (Nginx), 8080 (Adminer) or 3306 (MariaDB).

## Contributing
Contributions are welcome! Feel free to submit a pull request or open an issue to suggest improvements.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
