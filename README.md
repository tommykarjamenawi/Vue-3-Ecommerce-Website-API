# Docker setup that runs a demo REST api
This repository provides a helper project for a Vue frontend assignment.

It contains:
* NGINX webserver
* PHP FastCGI Process Manager with PDO MySQL support
* MariaDB (GPL MySQL fork)
* PHPMyAdmin

## Installation

1. Install Docker Desktop on Windows or Mac, or Docker Engine on Linux.
1. Clone the project

## Usage

In a terminal, run:
```bash
docker-compose up
```

NGINX will now serve files in the app/public folder. Visit localhost in your browser to check.
PHPMyAdmin is accessible on localhost:8080

If you want to stop the containers, press Ctrl+C. 
Or run:
```bash
docker-compose down
```

## USER-DETAILS
1. username: username
2. password: $2y$10$DQlV0u9mFmtOWsOdxXX9H.4kgzEB3E8o97s.S.Pdy4klUAdBvtVh.
3. email: username@password.com

## User Accounts

### Admin
* Username: "tk@shop.nl"
* Password: "test"

### Customer
* Username: "test@shop.nl"
* Password: "test"