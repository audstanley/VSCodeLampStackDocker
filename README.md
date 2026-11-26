# LAMP Stack Dev Container for VS Code

A ready-to-use PHP + MySQL development environment that runs in Docker and opens directly in VS Code. Clone it, open it in a dev container, and you have Apache, PHP, MySQL and phpMyAdmin running. You don't need to install any of them on your machine.

| Service | Image | URL / host |
|---|---|---|
| Apache + PHP (your code) | `php:8.4-apache` | http://localhost:9090 |
| phpMyAdmin | `phpmyadmin:5.2` | http://localhost:9091 |
| MySQL | `mysql:8.4` | `mysql-server:3306` (from inside the containers) |

The web container also includes Git, Node.js 22 and `jshint`, and PHP comes with the `mysqli`, `pdo` and `pdo_mysql` extensions.

## Requirements

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (or Docker Engine with Compose v2)
- [Visual Studio Code](https://code.visualstudio.com/) with the [Dev Containers](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers) extension

## Quick start

1. Clone the repository and open the folder in VS Code:

   ```sh
   git clone https://github.com/audstanley/VSCodeLampStackDocker.git
   code VSCodeLampStackDocker
   ```

2. When VS Code asks, click **Reopen in Container**. You can also open the Command Palette (`Ctrl+Shift+P` / `Cmd+Shift+P`) and run **Dev Containers: Reopen in Container**.
   The first build takes a few minutes.

3. Load the example database (see [Restore a database](#restore-a-database-from-a-sql-file) below). The steps are: create a database named `TestDataBase` in phpMyAdmin, then import `TestDataBase.sql`.

4. Open http://localhost:9090. You should see:

   ```
   SUCCESSFULLY CONNECTED TO MYSQL
   Alice is 22 years old.
   Bob is 23 years old.
   ```

   followed by the PHP info page.

### Without VS Code

The stack is plain Docker Compose, so you can also start it from a terminal at the repository root:

```sh
docker compose -f .devcontainer/docker-compose.yml up -d --build
```

Stop it with `docker compose -f .devcontainer/docker-compose.yml down`.

## Project layout

```
.devcontainer/
  devcontainer.json    VS Code dev container settings and extensions
  docker-compose.yml   web-server, mysql-server and phpmyadmin services
  Dockerfile           PHP/Apache image for the web-server service
.mysql-data/           MySQL data files (kept out of Git)
index.php              Example page that connects to MySQL
TestDataBase.sql       Example database dump
```

The repository root is mounted as Apache's document root (`/var/www/html`), so any `.php` file you add is served at http://localhost:9090 right away. You don't need to rebuild.

## Connecting to MySQL from PHP

Inside the containers, the database host is the service name `mysql-server`, not `localhost`:

```php
$dbh = new PDO('mysql:dbname=TestDataBase;host=mysql-server', 'root', 'secret');
```

See [index.php](index.php) for a complete example.

### Credentials

| | Value |
|---|---|
| Host | `mysql-server` |
| Port | `3306` (not published to your machine) |
| User | `root` |
| Password | `secret` |

> [!WARNING]
> These credentials are for local development only. Don't deploy this setup or expose its ports on a public network.

## Managing the database

MySQL stores its data in the `.mysql-data/` folder in the repository. That folder is listed in `.gitignore`, so your local data never gets committed. To share a database with your team, export it as a `.sql` file and commit that instead.

### Back up a database

1. Open phpMyAdmin at http://localhost:9091.
2. Select the database in the left sidebar.
3. Click **Export**, keep the **Quick** method and **SQL** format, and click **Export**.

Back up regularly, and always back up before resetting the database or changing the MySQL image version.

### Restore a database from a SQL file

1. Open phpMyAdmin at http://localhost:9091.
2. Click **New** in the left sidebar.
3. Enter the database name (for the example: `TestDataBase`) and click **Create**.
4. Click **Import** at the top of the page.
5. Click **Choose File** and select the `.sql` file (for example `TestDataBase.sql`).
6. Click **Import** at the bottom of the page.

### Reset to an empty database

Removing or rebuilding the containers does not clear the database, because the data lives in `.mysql-data/` on your machine. To start fresh:

1. [Back up](#back-up-a-database) anything you want to keep.
2. Stop the containers. In VS Code, run **Dev Containers: Reopen Folder Locally**, then stop the stack in Docker Desktop. From a terminal, run `docker compose -f .devcontainer/docker-compose.yml down`.
3. Delete everything inside `.mysql-data/` **except** the `.empty` file.
4. Reopen the folder in the container. MySQL starts with a brand new, empty data directory.
5. Create your database again and [restore](#restore-a-database-from-a-sql-file) it from a `.sql` file if needed.

## Updating

The images use minor-version tags (`php:8.4-apache`, `mysql:8.4`, `phpmyadmin:5.2`), so rebuilding picks up the latest patch and security releases. After pulling changes, or every so often, run **Dev Containers: Rebuild Container** in VS Code. From a terminal, run:

```sh
docker compose -f .devcontainer/docker-compose.yml build --pull
docker compose -f .devcontainer/docker-compose.yml pull
```

Pulling new code alone doesn't update a running container; you have to rebuild it.

## Troubleshooting

- **"Connection failed" on http://localhost:9090**: MySQL can take a few seconds to start the first time. Wait a moment and refresh. Also check that the `TestDataBase` database exists.
- **Port 9090 or 9091 already in use**: change the left side of the `ports` mapping in `.devcontainer/docker-compose.yml`, for example `"8080:80"`.
- **Code changes don't show up**: make sure you're editing files in the repository root, which is what Apache serves.

## License

[MIT](LICENSE)
