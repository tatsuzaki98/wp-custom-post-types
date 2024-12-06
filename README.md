# WordPress Local Development Environment
Start WordPress server

```sh
# Copy .env.example to .env
install .env.example .env

# Start WordPress server
docker-compose up
```

Enable Tailwind hot reload
Tailwind output file is `/greenleaf/global.css`.

```sh
# Install npm packages
npm ci

# Start Tailwind hot reload
npm run watch
```
